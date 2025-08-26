<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FacturaCliente extends Model
{
    protected $table = 'facturas_clientes';

    protected $fillable = [
        'numero_factura',
        'empresa_id',
        'cliente_id',
        'total',
        'user_id',
        'pdf_path',
    ];

    // Relaciones

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cliente_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(FacturaClienteItem::class);
    }
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    
}

