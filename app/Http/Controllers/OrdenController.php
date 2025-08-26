<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrdenController extends Controller
{
    public function storeContraentrega(Request $request)
{
    $direccion = json_decode($request->direccion, true);

    // Aquí podrías guardar la orden en la base de datos
    // y vaciar el carrito de sesión, por ejemplo:

    session()->forget('carrito'); // Vaciar carrito

    return view('orden.exito', [
        'direccion' => $direccion,
        'metodo' => 'Contraentrega'
    ]);
}

}
