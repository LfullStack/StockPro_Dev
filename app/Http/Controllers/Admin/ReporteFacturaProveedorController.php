<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Proveedor;
use Carbon\Carbon;
use App\Models\FacturaProveedor;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReporteFacturaProveedorController extends Controller
{
    public function index(Request $request)
    {
        $proveedores = Proveedor::pluck('nombre', 'id');
        $facturas = collect();

        // Si hay filtros aplicados
        if ($request->filled(['fecha_inicio', 'fecha_fin'])) {
            $query = FacturaProveedor::with('empresa', 'proveedor')
                ->whereBetween('created_at', [$request->fecha_inicio, $request->fecha_fin]);

            if ($request->filled('proveedor_id')) {
                $query->where('proveedor_id', $request->proveedor_id);
            }

            $facturas = $query->get();
        }

        return view('admin.reportes.facturas_proveedores.index', compact('proveedores', 'facturas'));
    }
    public function exportarExcel(Request $request): StreamedResponse
    {
        $request->validate([
            'proveedor_id' => 'nullable|exists:empresas,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        $fechaInicioCarbon = Carbon::parse($request->input('fecha_inicio'));
    $fechaFinCarbon = Carbon::parse($request->input('fecha_fin'));

    $facturas = FacturaProveedor::with('proveedor', 'empresa')
        ->when($request->proveedor_id, fn($q) => $q->where('proveedor_id', $request->proveedor_id))
        ->whereBetween('created_at', [$fechaInicioCarbon, $fechaFinCarbon])
        ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Facturas Proveedores');

        // Cabeceras
        $sheet->fromArray([
            ['ID', 'Número Factura', 'Proveedor', 'Empresa', 'Fecha', 'Total']
        ], null, 'A1');

        // Contenido
        $fila = 2;
        foreach ($facturas as $factura) {
            $sheet->fromArray([
                $factura->id,
                $factura->numero_factura,
                $factura->proveedor->nombre ?? 'N/A',
                $factura->empresa->nombre ?? 'N/A',
                $factura->created_at->format('Y-m-d'),
                $factura->total,
            ], null, 'A' . $fila++);
        }

    $writer = new Xlsx($spreadsheet);

    $fechaInicio = $fechaInicioCarbon->format('Ymd');
    $fechaFin = $fechaFinCarbon->format('Ymd');
    $horaActual = now()->format('His');
    $fileName = "reporte_facturas_proveedores_{$fechaInicio}_{$fechaFin}_{$horaActual}.xlsx";

    return response()->streamDownload(function () use ($writer) {
        $writer->save('php://output');
    }, $fileName);
    }
}
