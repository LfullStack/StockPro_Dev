<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Categoria;
use Illuminate\Support\Carbon;

class TipoArticuloSeeder extends Seeder
{
    public function run(): void
    {
        // Verifica que ya existan categorías
        $categorias = Categoria::all();

        if ($categorias->isEmpty()) {
            $this->command->warn('No hay categorías. Ejecuta primero el CategoriaSeeder.');
            return;
        }

        $data = [];

        foreach ($categorias as $categoria) {
            $tipos = match ($categoria->nombre) {
                'Electrónica' => ['Celulares', 'Laptops', 'Accesorios'],
                'Hogar'       => ['Cocina', 'Decoración', 'Iluminación'],
                'Ropa'        => ['Camisas', 'Pantalones', 'Zapatos'],
                'Deportes'    => ['Balones', 'Zapatillas', 'Accesorios Fitness'],
                'Alimentos'   => ['Bebidas', 'Snacks', 'Enlatados'],
                default       => ['General 1', 'General 2', 'General 3'],
            };

            foreach ($tipos as $tipoNombre) {
                $data[] = [
                    'nombre' => $tipoNombre,
                    'categoria_id' => $categoria->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }
        }

        DB::table('tipo_articulos')->insert($data);
    }
}
