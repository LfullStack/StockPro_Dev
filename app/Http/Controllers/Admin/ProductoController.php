<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\Categoria;
use App\Models\TipoArticulo;
use App\Models\UnidadMedida;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::with(['proveedor', 'categoria', 'tipoArticulo', 'unidadMedida'])->get();
        $proveedores = Proveedor::all();
        $categorias = Categoria::all();
        $tipoArticulos = TipoArticulo::all();
        $unidadMedidas = UnidadMedida::all();

        return view('admin.productos.index', compact(
            'productos', 'proveedores', 'categorias', 'tipoArticulos', 'unidadMedidas'
        ));

    }

    public function create()
    {
        $proveedores = Proveedor::all();
        $categorias = Categoria::all();
        $tipoArticulos = TipoArticulo::all();
        $unidadMedidas = UnidadMedida::all();

        return view('admin.productos.create', compact(
            'proveedores', 'categorias', 'tipoArticulos', 'unidadMedidas'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'descuento' => 'nullable|numeric',
            'categoria_id' => 'required|exists:categorias,id',
            'tipo_articulos_id' => 'required|exists:tipo_articulos,id',
            'proveedor_id' => 'required|exists:proveedores,id',
            'unidad_medida_id' => 'required|exists:unidad_medidas,id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto_url' => 'nullable|url',
            'descripcion' => 'nullable|string',
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('productos', 'public');
        } elseif ($request->filled('foto_url')) {
            $data['foto'] = $request->foto_url;
        }

        Producto::create($data);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'Producto creado con éxito'
        ]);

        return redirect()->route('admin.productos.index');
    }

    public function edit(Producto $producto)
    {
        $proveedores = Proveedor::all();
        $categorias = Categoria::all();
        $tipoArticulos = TipoArticulo::all();
        $unidadMedidas = UnidadMedida::all();

        return view('admin.productos.edit', compact(
            'producto', 'proveedores', 'categorias', 'tipoArticulos', 'unidadMedidas'
        ));
    }

    public function update(Request $request, Producto $producto)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'descuento' => 'nullable|numeric',
            'categoria_id' => 'required|exists:categorias,id',
            'tipo_articulos_id' => 'required|exists:tipo_articulos,id',
            'proveedor_id' => 'required|exists:proveedores,id',
            'unidad_medida_id' => 'required|exists:unidad_medidas,id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto_url' => 'nullable|url',
            'descripcion' => 'nullable|string',
        ]);

        if ($request->hasFile('foto')) {
            if ($producto->foto && !Str::startsWith($producto->foto, ['http://', 'https://'])) {
                Storage::disk('public')->delete($producto->foto);
            }
            $data['foto'] = $request->file('foto')->store('productos', 'public');
        } elseif ($request->filled('foto_url')) {
            $data['foto'] = $request->foto_url;
        }

        $producto->update($data);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Actualizado!',
            'text' => 'Producto actualizado con éxito'
        ]);

        return redirect()->route('admin.productos.index');
    }

    public function destroy(Producto $producto)
    {
        if ($producto->foto && !Str::startsWith($producto->foto, ['http://', 'https://']) && Storage::disk('public')->exists($producto->foto)) {
            Storage::disk('public')->delete($producto->foto);
        }

        $producto->delete();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Eliminado!',
            'text' => 'Producto eliminado con éxito'
        ]);

        return redirect()->route('admin.productos.index');
    }
}