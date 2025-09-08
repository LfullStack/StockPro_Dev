<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FacturaCliente;
use App\Models\FacturaClienteItem;
use App\Models\Empresa;
use App\Models\Inventario;
use App\Models\Producto;
use App\Models\User;
use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Mail\EnviarCorreo;
use Illuminate\Support\Facades\Auth;


use Illuminate\Support\Facades\File;

class FacturaClienteController extends Controller
{
    public function index()
    {
        $facturas = FacturaCliente::with('empresa')->get();
        return view('admin.facturas_clientes.index', compact('facturas'));
    }

    public function create()
    {
        $empresas = Empresa::all();
        $clientes = User::all();

        $productos = Producto::with('inventario')
            ->whereHas('inventario', function ($query) {
                $query->where('cantidad', '>', 0);
            })->get();

        $inventario = $productos->map(function ($p) {
            return [
                'id' => $p->id,
                'precio' => $p->precio ?? 0,
                'descuento' => $p->descuento ?? 0,
                'cantidad' => $p->inventario->cantidad ?? 0,
                'unidad_medida' => $p->inventario->unidad_medida ?? 'unidad',
                'empresa_id' => $p->inventario->empresa_id ?? null,
                'producto' => [
                    'id' => $p->id,
                    'nombre' => $p->nombre,
                ],
            ];

        // condicional para mostrar modal de producto registrado exitosamente




        
        });

        return view('admin.facturas_clientes.create', [
            'productos' => $productos,
            'empresas' => $empresas,
            'inventario' => $inventario->values(),
            'clientes' => $clientes,
            
        ]);

        

    }

    public function store(Request $request)
    {
        $request->validate([
            'empresa_id' => 'required|exists:empresas,id', 
            'cliente_id' => 'required|exists:users,id',
            'items_json' => 'required|string',
            
        ]);

        $items = json_decode($request->items_json, true);
        if (!is_array($items) || count($items) === 0) {
            return redirect()->back()->withInput()->with('error', 'Debe agregar al menos un ítem a la factura.');
        }

        DB::beginTransaction();

        try {
            $numeroFactura = FacturaCliente::max('numero_factura') + 1;

            $factura = FacturaCliente::create([
                'empresa_id' => $request->empresa_id,
                'cliente_id' => $request->cliente_id,
                'numero_factura' => $numeroFactura,
                'total' => 0,
                'user_id' => Auth::id(), 
            ]);

            
            

            $total = 0;

            foreach ($items as $item) {
                $inventario = Inventario::where('producto_id', $item['producto_id'])->first();

                if (!$inventario) {
                    throw new \Exception("Producto ID {$item['producto_id']} no existe en el inventario.");
                }

                if ($inventario->cantidad < $item['cantidad']) {
                    throw new \Exception("Stock insuficiente para el producto: {$inventario->producto->nombre}");
                }

                $precio_unitario = $item['precio_unitario'];
                $descuento = $item['descuento'] ?? 0;
                $cantidad = $item['cantidad'];
                $impuesto = $item['impuesto'] ?? 0;
                $unidad_medida = $inventario->unidad_medida ?? 'unidad';

                $subtotal = ($precio_unitario - $descuento) * $cantidad + $impuesto;
                $total += $subtotal;

                FacturaClienteItem::create([
                    'factura_cliente_id' => $factura->id,
                    'producto_id' => $inventario->producto_id,
                    'cantidad' => $cantidad,
                    'unidad_medida' => $unidad_medida,
                    'precio_unitario' => $precio_unitario,
                    'descuento' => $descuento,
                    'impuesto' => $impuesto,
                    'subtotal' => $subtotal,
                ]);

                $inventario->cantidad -= $cantidad;
                $inventario->save();
            }

            $factura->total = $total;

            $carpetaPDF = public_path('facturas_ventas/pdf');
            if (!File::exists($carpetaPDF)) {
                File::makeDirectory($carpetaPDF, 0755, true);
            }

            $nombreArchivo = "factura_venta_{$factura->numero_factura}.pdf";
            $rutaPDF = "facturas_ventas/pdf/{$nombreArchivo}";

            $pdf = Pdf::loadView('admin.facturas_clientes.pdf', [
                'factura' => $factura->load('items.producto', 'empresa', 'cliente')
            ]);

            $pdf->save(public_path($rutaPDF));
            $factura->pdf_path = $rutaPDF;
            $factura->save();

            // Enviar correo al cliente
            $factura->load('cliente', 'items.producto');




            DB::commit();

            $cliente = $factura->cliente;

            if ($cliente && $cliente->email) {
                Mail::to($cliente->email)->send(new EnviarCorreo($factura, $rutaPDF));

            Evento::create([
            'titulo' => 'Factura registrada',
            'descripcion' => 'Se registró la factura de Venta # "' . $factura->numero_factura . '" , de la Empresa "'. $factura->empresa->nombre .'" en el sistema.',
            'tipo' => 'success',
            'modelo' => 'FacturaCliente',
            'modelo_id' => $factura->id,
            'user_id' => Auth::id(),
            ]);
            }


            session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡ Muy bien !',
            'text' => 'Se ha registrado una nueva factura con éxito'
        ]);

            return redirect()->route('admin.facturas_clientes.index');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Error al guardar la factura: ' . $e->getMessage());
        }
    }

    public function show(FacturaCliente $factura)
    {
        $factura->load('empresa', 'cliente', 'items.producto');
        return view('admin.facturas_clientes.show', compact('factura'));
    }

    public function destroy($id)
    {
        $factura = FacturaCliente::findOrFail($id);
        $factura->items()->delete();
        $factura->delete();

        return redirect()->route('admin.facturas_clientes.index')->with('success', 'Factura eliminada correctamente.');
    }

    public function descargarPDF(FacturaCliente $factura)
    {
        if (!$factura->pdf_path || !file_exists(public_path($factura->pdf_path))) {
            return redirect()->back()->with('error', 'PDF no encontrado.');
        }

        return response()->download(public_path($factura->pdf_path));
    }
}
