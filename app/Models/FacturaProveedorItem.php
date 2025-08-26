<?php

namespace App\Models;

use App\Models\FacturaProveedor;
use App\Models\Producto;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FacturaProveedorItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'factura_id',
        'producto_id',
        'unidad_medida',
        'cantidad',
        'precio_unitario',
        'descuento',
        'impuesto',
        'subtotal',
    ];

    public function factura()
    {
        return $this->belongsTo(FacturaProveedor::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    protected static function booted()
    {
        static::created(function ($item) {
            $factura = $item->factura;

            if (!$factura) return; // Seguridad por si no se carga la relación

            $inventario = \App\Models\Inventario::firstOrNew([
                'producto_id' => $item->producto_id,
                'empresa_id' => $factura->empresa_id,
            ]);

            if (!$inventario->exists) {
                $inventario->unidad_medida = $item->unidad_medida;
                $inventario->nombre = $item->producto->nombre ?? 'Sin nombre';
                $inventario->descuento = 0;
            }

            $inventario->cantidad += $item->cantidad;
            $inventario->precio = $item->precio_unitario;
            $inventario->save();
        });

        static::deleted(function ($item) {
            $factura = $item->factura;

            if (!$factura) return;

            $inventario = \App\Models\Inventario::where([
                'producto_id' => $item->producto_id,
                'empresa_id' => $factura->empresa_id,
            ])->first();

            if ($inventario) {
                $inventario->cantidad -= $item->cantidad;
                $inventario->cantidad = max(0, $inventario->cantidad);
                $inventario->save();
            }
        });
    }
}
