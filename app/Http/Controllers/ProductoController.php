<?php

namespace App\Http\Controllers;


use App\Models\Producto;
use App\Models\Carrito;


class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::where('activo', 1)->get();
        return view('tienda.ecommerce', compact('productos'));
    }

    public function carritos()
{
    return $this->hasMany(Carrito::class);
}

}
