<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FacturaCliente;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Models\Empresa;

class ReporteFacturaClienteController extends Controller
{
    public function index(Request $request)
    {
        $empresas = Empresa::pluck('nombre', 'id');
        $facturas = collect();

        // Si hay filtros aplicados
        if ($request->filled(['fecha_inicio', 'fecha_fin'])) {
            $query = FacturaCliente::with('cliente', 'empresa')
                ->whereBetween('created_at', [$request->fecha_inicio, $request->fecha_fin]);

            if ($request->filled('empresa_id')) {
                $query->where('empresa_id', $request->empresa_id);
            }

            $facturas = $query->get();
        }

        return view('admin.reportes.facturas_clientes.index', compact('empresas', 'facturas'));
    }



public function exportarExcel(Request $request): StreamedResponse
{
    $request->validate([
        'empresa_id' => 'nullable|exists:empresas,id',
        'fecha_inicio' => 'required|date',
        'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
    ]);

    $fechaInicioCarbon = Carbon::parse($request->input('fecha_inicio'));
    $fechaFinCarbon = Carbon::parse($request->input('fecha_fin'));

    $facturas = FacturaCliente::with('cliente', 'empresa')
        ->when($request->empresa_id, fn($q) => $q->where('empresa_id', $request->empresa_id))
        ->whereBetween('created_at', [$fechaInicioCarbon, $fechaFinCarbon])
        ->get();

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Facturas Clientes');

    // Cabeceras
    $sheet->fromArray([
        ['ID', 'Número Factura', 'Cliente', 'Empresa', 'Fecha', 'Total']
    ], null, 'A1');

    // Contenido
    $fila = 2;
    foreach ($facturas as $factura) {
        $sheet->fromArray([
            $factura->id,
            $factura->numero_factura,
            $factura->cliente->name ?? 'N/A',
            $factura->empresa->nombre ?? 'N/A',
            $factura->created_at->format('Y-m-d'),
            $factura->total,
        ], null, 'A' . $fila++);
    }

    $writer = new Xlsx($spreadsheet);

    $fechaInicio = $fechaInicioCarbon->format('Ymd');
    $fechaFin = $fechaFinCarbon->format('Ymd');
    $horaActual = now()->format('His');
    $fileName = "reporte_facturas_clientes_{$fechaInicio}_{$fechaFin}_{$horaActual}.xlsx";

    return response()->streamDownload(function () use ($writer) {
        $writer->save('php://output');
    }, $fileName);
}

}
