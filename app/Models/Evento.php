<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class Evento extends Model
{
    use HasFactory;

    protected $table = 'eventos';

    protected $fillable = [
        'user_id',
        'titulo',
        'descripcion',
        'tipo',
        'modelo',
        'modelo_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
