<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;

class TiendaController extends Controller
{
 public function login()
{
    $productosBajos = Producto::where('precio', '<', 20000)->get();
    $totalInventario = Producto::sum('cantidad'); 

    return view('dashboard', compact('productosBajos')); // ✅ aquí lo envías
}


    public function mostrarEcommerce(Request $request)
{
    $showLoginModal = false;
    $redirectTo = null;

    if ($request->has('show_login')) {
        $showLoginModal = true;
        $redirectTo = $request->input('redirect_to', route('tienda'));
    }

    $productosHogar = Producto::with(['categoria', 'inventario'])
        ->whereHas('categoria', function($query) {
            $query->where('nombre', 'Hogar');
        })
        ->get();

    $productos = Producto::all();
    $categorias = Categoria::all();
    $productosBajos = Producto::where('precio', '<', 20000)->get();

    return view('tienda.index', [
        'productosHogar' => $productosHogar,
        'productos' => $productos,
        'productosBajos' => $productosBajos,  // 👈 ¡Agregado!
        'categorias' => $categorias,
        'showLoginModal' => $showLoginModal,
        'redirectTo' => $redirectTo
    ]);
}

}