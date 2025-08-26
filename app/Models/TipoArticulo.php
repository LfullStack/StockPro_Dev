<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class TipoArticulo extends Model
{   

    use HasFactory;

    protected $fillable = ['nombre', 'categoria_id'];
    

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
    public function producto()
    {
        return $this->hasMany(Producto::class, 'tipo_articulos_id', 'id');
    }
}
