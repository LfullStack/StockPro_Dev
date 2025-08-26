<?php

namespace App\Http\Controllers;

use App\Models\FacturaCliente;
use Illuminate\Support\Facades\Auth;

class FacturaClienteController extends Controller
{
    public function index()
    {
        $clienteId = Auth::id();

        $facturas = FacturaCliente::where('cliente_id', $clienteId)
            ->with(['productos'])
            ->get();

        return view('admin.reportes.facturas-clientes.index', compact('facturas'));
    }

    public function exportar()
    {
        return response()->json(['mensaje' => 'Exportando facturas de cliente...']);
    }
}
