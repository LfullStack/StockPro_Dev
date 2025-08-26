<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class MetaVenta extends Model
{
    protected $table = 'metas_ventas';
    protected $fillable = ['monto_meta', 'tipo', 'anio', 'mes', 'semana'];
}
