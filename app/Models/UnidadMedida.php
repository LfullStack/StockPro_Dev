<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UnidadMedida extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'prefijo'];

    public function productos()
    {
        return $this->hasMany(Producto::class);
    }
}
