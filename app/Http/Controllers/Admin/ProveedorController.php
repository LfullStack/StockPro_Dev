<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $proveedores= Proveedor::all();

        return view('admin.proveedores.index', compact('proveedores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.proveedores.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|min:3|max:255|unique:proveedores',
            'nit' => 'required|string|min:10|max:12|unique:proveedores,nit',
            'telefono' => 'required|string|min:10|max:10',
            'email' => 'required|string|max:255|unique:proveedores,email',
            'direccion' => 'required|string|max:255',
            'ubicacion' => 'required|string|max:255'
        ]);

        Proveedor::create([
            'nombre' => $data['nombre'],
            'nit' => $data['nit'],
            'telefono' => $data['telefono'],
            'email' => $data['email'],
            'direccion' => $data['direccion'],
            'ubicacion' => $data['ubicacion'],
        ]);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡ Bien crack !',
            'text' => 'Se ha registado un nuevo proveedor con éxito'
        ]);
        
        return redirect()->route('admin.proveedores.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Proveedor $proveedor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Proveedor $proveedor)
    {
        return view('admin.proveedores.edit', compact('proveedor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Proveedor $proveedor)
    {
        $data = $request->validate([
            'nombre' => 'required|string|min:3|max:255',
            'nit' => 'required|string|min:10|max:12|',
            'telefono' => 'required|string|min:10|max:10',
            'email' => 'required|string|max:255|',
            'direccion' => 'required|string|max:255',
            'ubicacion' => 'required|string|max:255'
            
        ]);

        $proveedor->update([
            'nombre' => $data['nombre'],
            'nit' => $data['nit'],
            'telefono' => $data['telefono'],
            'email' => $data['email'],
            'direccion' => $data['direccion'],
            'ubicacion' => $data['ubicacion'],        ]);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡ Actualizado !',
            'text' => 'Se ha actualizado los datos del proveedor con éxito'
        ]);

        return redirect()->route('admin.proveedores.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Proveedor $proveedor)
    {
        $proveedor->delete();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡ Eliminado !',
            'text' => 'Se ha eliminado el proveedor con éxito'
        ]);

        return redirect()->route('admin.proveedores.index');
    }
}
