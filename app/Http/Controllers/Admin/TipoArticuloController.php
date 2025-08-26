<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\TipoArticulo;
use Illuminate\Http\Request;

class TipoArticuloController extends Controller
{
    public function index()
    {
        $tipoArticulos = TipoArticulo::with('categoria')->get();
        return view('admin.tipos_articulos.index', compact('tipoArticulos'));
    }

    public function create()
    {
        $categorias = Categoria::all();
        return view('admin.tipos_articulos.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        TipoArticulo::create($request->only('nombre', 'categoria_id'));

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡ Muy bien !',
            'text' => 'Se ha creado el tipo de artículo con éxito'
        ]);

        return redirect()->route('admin.tipos_articulos.index');
    }

   public function edit(TipoArticulo $tipoArticulo)
{
    $categorias = Categoria::all();
    return view('admin.tipos_articulos.edit', compact('tipoArticulo', 'categorias'));
}

public function update(Request $request, TipoArticulo $tipoArticulo)
{
    $data = $request->validate([
        'nombre' => 'required|string|max:255',
        'categoria_id' => 'required|exists:categorias,id',
    ]);

    $tipoArticulo->update([
        'nombre' => $data['nombre'],
        'categoria_id' => $data['categoria_id'],
    ]);

    session()->flash('swal', [
        'icon' => 'success',
        'title' => '¡Actualizado!',
        'text' => 'Se ha actualizado el tipo de artículo con éxito',
    ]);

    return redirect()->route('admin.tipos_articulos.index');
}

public function destroy(TipoArticulo $tipoArticulo)
{
    $tipoArticulo->delete();

    session()->flash('swal', [
        'icon' => 'success',
        'title' => '¡ Eliminado !',
        'text' => 'Se ha eliminado el tipo de artículo con éxito'
    ]);

    return redirect()->route('admin.tipos_articulos.index');
}
}
