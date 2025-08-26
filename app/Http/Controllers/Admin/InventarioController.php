<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventario;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
    public function index(Request $request)
    {
        $inventarios = Inventario::with(['producto', 'proveedor'])->get();
        return view('admin.inventarios.index', compact('inventarios'));
    }

}
