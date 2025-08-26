<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CompraController extends Controller
{
    public function success(Request $request)
    {
        $carrito = session('carrito', []);

        // Si el carrito está vacío, redirigir para evitar errores
        if (empty($carrito)) {
            return redirect()->route('inicio')->with('error', 'Carrito vacío');
        }

        $direccion = json_decode($request->input('direccion'), true);
        $metodo = $request->input('metodo');

        $total = 0;
        foreach ($carrito as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }

        // Vaciar carrito
        session()->forget('carrito');

        return view('compra.success', [
            'productos' => $carrito,
            'direccion' => $direccion,
            'metodo' => $metodo,
            'total' => $total
        ]);
    }
}
