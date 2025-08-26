<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Proveedor;
use App\Models\TipoArticulo;
use App\Models\Categoria;
use App\Models\Inventario;

class Producto extends Model
{

    use HasFactory;

    protected $table = 'productos';

    protected $fillable = [
        'nombre',
        'precio',
        'unidad_medida_id',
        'descuento',
        'proveedor_id',
        'categoria_id',
        'tipo_articulos_id',
        'foto',

        'descripcion',

        'descripcion'
        ];
        
        public function proveedor()
        {
            return $this->belongsTo(Proveedor::class, 'proveedor_id', 'id');
        }

        public function tipoArticulo()
        {
            return $this->belongsTo(TipoArticulo::class,'tipo_articulos_id','id');
        }

        public function categoria()
        {

            return $this->belongsTo(Categoria::class, 'categoria_id', 'id');
        }
        // app/Models/Producto.php

        public function unidadMedida()
        {
            return $this->belongsTo(UnidadMedida::class);
        }
        // App\Models\Producto.php

        public function inventario()
        {
            return $this->hasOne(Inventario::class, 'producto_id'); // clave foránea en inventarios
        }
        public function getImagenUrlAttribute()
        {
            return 'https://miwebexterna.com/images/' . $this->imagen;
        }

        public function carritos() {
            return $this->hasMany(Carrito::class);
}


}
