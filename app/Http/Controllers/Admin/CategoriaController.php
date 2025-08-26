<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\TipoArticulo;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::with('tipoArticulos')->get();
        return view('admin.categorias.index', compact('categorias'));
    }

    public function create()
    {
        return view('admin.categorias.create');
    }

    public function store(Request $request)
    {
        
        $data = $request->validate([
            'nombre' => 'required|string|min:3|max:255|unique:categorias',
            'tipo_articulo' => 'required|string|min:3|max:255',
            
        ]);

        $categoria = Categoria::create([
            'nombre' => $data['nombre'],
        ]);

        TipoArticulo::create([
            'nombre' => $data['tipo_articulo'],
            'categoria_id' => $categoria->id,
        ]);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡ Muy bien !',
            'text' => 'Se ha creado la categoría con éxito'
        ]);

        return redirect()->route('admin.categorias.index');
    }

    public function show(Categoria $categoria)
    {
        //
    }

    public function edit(Categoria $categoria)
    {
        // Ya no se necesita pasar tipoArticulo
        return view('admin.categorias.edit', compact('categoria'));
    }

    public function update(Request $request, Categoria $categoria)
    {
        $data = $request->validate([
            'nombre' => 'required|string|min:3|max:255|unique:categorias',
        ]);

        $categoria->update([
            'nombre' => $data['nombre'],
        ]);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡ Actualizado !',
            'text' => 'Se ha actualizado la categoría con éxito'
        ]);

        return redirect()->route('admin.categorias.index');
    }

    public function destroy(Categoria $categoria)
    {
        $categoria->delete();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡ Eliminado !',
            'text' => 'Se ha eliminado la categoría con éxito'
        ]);

        return redirect()->route('admin.categorias.index');
    }
}
