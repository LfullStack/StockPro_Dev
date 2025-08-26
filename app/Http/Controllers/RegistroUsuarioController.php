<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegistroUsuarioController extends Controller
{
    /**
     * Mostrar listado de usuarios.
     */
    public function index()
    {
        $usuarios = User::all(); 
        return view('admin.registro_usuario.index', compact('usuarios'));
    }

    /**
     * Mostrar formulario de creación.
     */
    public function create()
    {
        return view('admin.registro_usuario.create');
    }

    /**
     * Guardar nuevo usuario.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'telefono' => 'nullable|string|max:20',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'telefono' => $request->telefono,
        ]);

        return redirect()->route('admin.registro_usuario.index')
            ->with('success', 'Usuario registrado correctamente.');
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit(User $usuario)
    {
        return view('admin.registro_usuario.edit', compact('usuario'));
    }

    /**
     * Actualizar usuario.
     */
    public function update(Request $request, User $usuario)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $usuario->id,
            'telefono' => 'nullable|string|max:20',
        ]);

        $usuario->update($request->only('name', 'email', 'telefono'));

        return redirect()->route('admin.registro_usuario.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Eliminar usuario.
     */
    public function destroy(User $usuario)
    {
        $usuario->delete();

        return redirect()->route('admin.registro_usuario.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }
}
