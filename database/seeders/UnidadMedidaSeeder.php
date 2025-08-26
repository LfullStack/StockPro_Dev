<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UnidadMedida;

class UnidadMedidaSeeder extends Seeder
{
    public function run(): void
    {
        $unidades = [
            ['nombre' => 'Unidad', 'prefijo' => 'Und'],
            ['nombre' => 'Kilogramo', 'prefijo' => 'Kg'],
            ['nombre' => 'Gramos', 'prefijo' => 'g'],
            ['nombre' => 'Centímetro', 'prefijo' => 'cm'],
            ['nombre' => 'Litro', 'prefijo' => 'L'],
            ['nombre' => 'Mililitro', 'prefijo' => 'ml'],
        ];

        foreach ($unidades as $unidad) {
            UnidadMedida::create($unidad);
        }
    }
}
