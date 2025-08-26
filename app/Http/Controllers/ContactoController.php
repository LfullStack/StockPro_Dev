<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactoController extends Controller
{
    public function enviar(Request $request)
    {
        // Aquí puedes validar o guardar el mensaje
        return back()->with('mensaje', 'Formulario enviado correctamente.');
    }
}