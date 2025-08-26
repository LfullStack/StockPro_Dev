<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class CarritoController extends Controller
{
    public function index()
    {
        $carrito = session('carrito', []);
        return view('carrito.index', compact('carrito'));
    }

    public function agregar($id)
    {
        $producto = Producto::findOrFail($id);
        $carrito = session()->get('carrito', []);
        
        if (isset($carrito[$id])) {
            $carrito[$id]['cantidad']++;
        } else {
            $carrito[$id] = [
                "nombre" => $producto->nombre,
                "precio" => $producto->precio,
                "foto" => $producto->foto,
                "cantidad" => 1
            ];
        }

        session()->put('carrito', $carrito);
        
        return response()->json([
            'success' => true,
            'message' => 'Producto añadido al carrito',
            'cart_count' => count($carrito),
            'cart_items' => $carrito
        ]);
    }

    public function eliminar($id)
    {
        $carrito = session()->get('carrito', []);
        
        if (isset($carrito[$id])) {
            unset($carrito[$id]);
            session()->put('carrito', $carrito);
        }

        return response()->json([
            'success' => true,
            'message' => 'Producto eliminado del carrito',
            'cart_count' => count($carrito),
            'cart_items' => $carrito
        ]);
    }

    public function dropdownContent()
    {
        $carrito = session()->get('carrito', []);
        return view('partials.cart-dropdown-content', ['carrito' => $carrito]);
    }
}
