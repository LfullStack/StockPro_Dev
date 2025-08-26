<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    
    protected $table = 'proveedores';
    use HasFactory;
    protected $fillable = [
        'nombre',
        'nit',
        'telefono',
        'email', 
        'direccion',
        'ubicacion'
    ];
    public function productos()
    {
        return $this->hasMany(Producto::class, 'proveedor_id', 'id');
    }

}
