<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class FacturaProveedor extends Model
{
    protected $table = 'facturas_proveedores';
    use HasFactory;

    protected $fillable = [
        'numero_factura',
        'user_id',
        'proveedor_id',
        'empresa_id',
        'fecha_pago',
        'total',
        'pdf_path',
    ];
    
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function items()
    {
        return $this->hasMany(FacturaProveedorItem::class, 'factura_id');
    }
}
