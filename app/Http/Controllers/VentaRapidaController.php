<?php

namespace App\Http\Controllers;

use App\Models\FacturaCliente;
use Illuminate\Support\Facades\Auth;


class VentaRapidaController extends Controller
{
    public function index()
    {
        $clienteId = Auth::id();

        $facturas = FacturaCliente::where('cliente_id', $clienteId)
            ->with(['productos'])
            ->get();

        return view('venta_rapida.index', compact('facturas'));
    }

    public function exportar()
    {
        return response()->json(['mensaje' => 'Exportando facturas de cliente...']);
    }
}
