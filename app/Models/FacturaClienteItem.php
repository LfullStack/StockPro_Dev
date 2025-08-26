<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FacturaClienteItem extends Model
{
    protected $table = 'factura_cliente_items';

    protected $fillable = [
        'factura_cliente_id',
        'producto_id',
        'cantidad',
        'unidad_medida',
        'precio_unitario',
        'impuesto',
        'descuento',
        'subtotal',
    ];

    // Relaciones

    public function factura(): BelongsTo
    {
        return $this->belongsTo(FacturaCliente::class, 'factura_cliente_id');
    }

    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class);
    }
    public function inventario(): BelongsTo
    {
        return $this->belongsTo(Inventario::class, 'producto_id');
    }

    
}
