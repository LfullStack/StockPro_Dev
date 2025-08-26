<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\MetaVenta;
use Illuminate\Http\Request;

class MetaVentaController extends Controller
{
    public function index()
    {
        $metas = MetaVenta::orderByDesc('created_at')->paginate(10);
        return view('admin.metas_ventas.index', compact('metas'));
    }

    public function create()
    {
        return view('admin.metas_ventas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'monto_meta' => 'required|numeric|min:1',
            'tipo' => 'required|in:mensual,semanal',
            'anio' => 'required|integer|min:2020|max:' . now()->year,
            'mes' => 'nullable|integer|between:1,12',
            'semana' => 'nullable|integer|between:1,53',
        ]);

        MetaVenta::create($request->all());

        return redirect()->route('admin.metas_ventas.index')->with('success', 'Meta de venta creada correctamente.');
    }

    public function edit(MetaVenta $metas_venta)
    {
        return view('admin.metas_ventas.edit', ['meta' => $metas_venta]);
    }

    public function update(Request $request, MetaVenta $metas_venta)
    {
        $request->validate([
            'monto_meta' => 'required|numeric|min:1',
            'tipo' => 'required|in:mensual,semanal',
            'anio' => 'required|integer|min:2020|max:' . now()->year,
            'mes' => 'nullable|integer|between:1,12',
            'semana' => 'nullable|integer|between:1,53',
        ]);

        $metas_venta->update($request->all());

        return redirect()->route('admin.metas_ventas.index')->with('success', 'Meta actualizada correctamente.');
    }

    public function destroy(MetaVenta $metas_venta)
    {
        $metas_venta->delete();

        return back()->with('success', 'Meta eliminada correctamente.');
    }
}
