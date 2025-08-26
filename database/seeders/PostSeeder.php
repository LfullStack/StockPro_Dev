<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\User;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener 5 usuarios distintos
        $usuarios = User::inRandomOrder()->take(5)->get();

        $posts = [
            [
                'titulo' => 'Lanzamiento del nuevo catálogo 2025',
                'asunto' => 'Información sobre la disponibilidad de nuevos productos',
                'contenido' => 'Nos complace anunciar que el catálogo 2025 ya está disponible con más de 500 productos nuevos para nuestros clientes.',
            ],
            [
                'titulo' => 'Mantenimiento programado del sistema',
                'asunto' => 'Actualización de servidores el fin de semana',
                'contenido' => 'Informamos a todos los usuarios que el sistema estará en mantenimiento este sábado de 10pm a 4am.',
            ],
            [
                'titulo' => 'Promoción especial en productos de hogar',
                'asunto' => 'Descuentos hasta del 40% por tiempo limitado',
                'contenido' => 'Aprovecha nuestra promoción en línea para todos los artículos del hogar durante esta semana.',
            ],
            [
                'titulo' => 'Nueva funcionalidad de búsqueda avanzada',
                'asunto' => 'Encuentra productos más rápido con filtros inteligentes',
                'contenido' => 'Hemos mejorado el sistema de búsqueda para ayudarte a localizar productos de manera más eficiente.',
            ],
            [
                'titulo' => 'Capacitación obligatoria para auxiliares',
                'asunto' => 'Curso virtual disponible en el portal interno',
                'contenido' => 'Todos los auxiliares deben completar el curso de inducción de seguridad y operación antes del 30 de julio.',
            ],
        ];

        foreach ($usuarios as $index => $usuario) {
            DB::table('posts')->insert([
                'titulo' => $posts[$index]['titulo'],
                'asunto' => $posts[$index]['asunto'],
                'contenido' => $posts[$index]['contenido'],
                'user_id' => $usuario->id,
                'created_at' => Carbon::now()->subDays(rand(1, 10)),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
