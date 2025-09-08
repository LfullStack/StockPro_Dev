<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FacturaProveedor;
use App\Models\FacturaProveedorItem;
use App\Models\Proveedor;
use App\Models\Empresa;
use App\Models\Evento;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;


class FacturaProveedorController extends Controller
{
    public function index()
    {
        $facturas = FacturaProveedor::with('proveedor')->latest()->paginate(10);
        return view('admin.facturas_proveedores.index', compact('facturas'));
    }

    public function create()
    {
        $proveedores = Proveedor::all();
        $empresas = Empresa::all();
        $productos = Producto::with('unidadMedida')->get();
        return view('admin.facturas_proveedores.create', compact('proveedores', 'empresas', 'productos'));

        
    }

    public function store(Request $request)
{
    $request->validate([
        'numero_factura' => 'required|unique:facturas_proveedores',
        'fecha_pago' => 'required|date',
        'proveedor_id' => 'required',
        'empresa_id' => 'required',
        'items_json' => 'required|string', // Validamos que venga el JSON
    ]);

    $items = json_decode($request->items_json, true);

    if (!is_array($items) || count($items) === 0) {
        return back()->withInput()->with('error', 'No se recibieron ítems válidos.');
    }

    DB::transaction(function () use ($request, $items) {
        $factura = FacturaProveedor::create([
            'numero_factura' => $request->numero_factura,
            'proveedor_id' => $request->proveedor_id,
            'empresa_id' => $request->empresa_id,
            'fecha_pago' => $request->fecha_pago,
            'total' => 0,
            'user_id' => Auth::id(),
        ]);

        $total = 0;

        foreach ($items as $item) {
            if (!isset($item['producto_id'],$item['unidad_medida'], $item['cantidad'], $item['precio_unitario'], $item['descuento'],$item['impuesto'])) {
                continue; // Ignorar ítems incompletos
            }


            $cantidad = floatval($item['cantidad']);
            $precio = floatval($item['precio_unitario']);
            $impuesto = floatval($item['impuesto']);
            $subtotal = ($cantidad * $precio) + $impuesto;

            FacturaProveedorItem::create([

                'producto_id' => $item['producto_id'],
                'unidad_medida' => $item['unidad_medida'],
                'cantidad' => $cantidad,
                'precio_unitario' => $precio,
                'descuento' => $item['descuento'],
                'impuesto' => $impuesto,
                'subtotal' => $subtotal,
                'factura_id' => $factura->id,

            ]);

            $total += $subtotal;
        }

        $factura->update(['total' => $total]);

        // Generar PDF
        $pdf = Pdf::loadView('admin.facturas_proveedores.pdf', ['factura' => $factura->load('items.producto')]);
        $path = 'facturas/pdf/factura_' . $factura->id . '.pdf';
        $pdf->save(public_path($path));
        $factura->update(['pdf_path' => $path]);

        Evento::create([
            'titulo' => 'Factura Proveedor registrada',
            'descripcion' => 'Se registró la factura # "' . $factura->numero_factura . '" , del Proveedor "'. $factura->proveedor->nombre .'" en el sistema.',
            'tipo' => 'success',
            'modelo' => 'FacturaProveedor',
            'modelo_id' => $factura->id,
            'user_id' => Auth::id(),
            ]);
        });

        session()->flash('swal', [
                'icon' => 'success',
                'title' => '¡ Muy bien !',
                'text' => 'Se ha registrado una nueva factura con éxito'
        ]);

    return redirect()->route('admin.facturas_proveedores.index');
}


    public function edit(FacturaProveedor $factura)
    {
        $proveedores = Proveedor::all();
        $empresas = Empresa::all();
        $productos = Producto::all();
        $factura->load('items');
        return view('admin.facturas_proveedores.edit', compact('factura', 'proveedores', 'empresas', 'productos'));
    }

    public function update(Request $request, FacturaProveedor $factura)
    {
        // Similar al store(), con validaciones y actualización de items
    }

    public function destroy(FacturaProveedor $factura)
    {
        // Eliminar primero los ítems relacionados
        $factura->items()->delete(); // Asegúrate de tener la relación definida en el modelo

        // Luego eliminar la factura
        $factura->delete();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Eiminado!',
            'text' => 'Se ha eliminado la factura con éxito'
        ]);

        return redirect()->route('admin.facturas_proveedores.index');
    }


    public function show(FacturaProveedor $factura)
    {
        $factura->load('items.producto', 'proveedor', 'cliente');
        return view('admin.facturas_proveedores.show', compact('factura'));
    }

    public function downloadPdf(FacturaProveedor $factura)
    {
        if ($factura->pdf_path && file_exists(public_path($factura->pdf_path))) {
            return response()->download(public_path($factura->pdf_path));
        }

        abort(404, 'PDF no encontrado');
    }
}