<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\UnidadMedida;
use App\Models\Proveedor;
use App\Models\TipoArticulo;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        $unidad = UnidadMedida::where('nombre', 'Unidad')->first(); // solo 'Unidad'
        $proveedores = Proveedor::all();

        $nombresPorTipo = [
            'Celulares' => [
                ['Smartphone Galaxy A14', 'Teléfono con pantalla 6.6", 128GB y cámara 50MP'],
                ['iPhone 13 Mini', 'Celular Apple 128GB, doble cámara, chip A15 Bionic'],
            ],
            'Laptops' => [
                ['Laptop Lenovo ThinkPad', 'Core i5, 8GB RAM, 256GB SSD, pantalla 14"'],
                ['HP Pavilion x360', 'Convertible táctil, 12GB RAM, 512GB SSD'],
            ],
            'Accesorios' => [
                ['Cargador Universal', 'Compatible con múltiples dispositivos'],
                ['Audífonos Inalámbricos', 'Bluetooth con micrófono y estuche de carga'],
            ],
            'Cocina' => [
                ['Batidora de Mano Philips', '300W con vaso medidor de 600ml'],
                ['Juego de Ollas 7 piezas', 'Antiadherentes, aptas para inducción'],
            ],
            'Decoración' => [
                ['Lámpara LED de Mesa', 'Regulable, base metálica'],
                ['Cuadro Moderno Tríptico', 'Diseño abstracto 90x60cm'],
            ],
            'Iluminación' => [
                ['Bombillo LED 12W', 'Luz cálida, rosca E27'],
                ['Tira LED 5M', 'Multicolor con control remoto'],
            ],
            'Camisas' => [
                ['Camisa Hombre Casual', 'Algodón, manga larga, talla M'],
                ['Camisa Mujer Formal', 'Seda sintética, botones ocultos'],
            ],
            'Pantalones' => [
                ['Jeans Slim Hombre', 'Color azul oscuro, stretch'],
                ['Pantalón Jogger Mujer', 'Tela suave, cintura ajustable'],
            ],
            'Zapatos' => [
                ['Zapatillas Deportivas', 'Talla 40, suela antideslizante'],
                ['Botines de Cuero', 'Elegantes, color marrón, talla 39'],
            ],
            'Balones' => [
                ['Balón Fútbol Adidas', 'Talla 5, costuras reforzadas'],
                ['Balón de Baloncesto', 'Tamaño oficial NBA, caucho sintético'],
            ],
            'Zapatillas' => [
                ['Zapatillas Running Nike', 'Con tecnología Air Zoom, talla 42'],
                ['Zapatillas Puma Mujer', 'Modelo casual urbano, talla 38'],
            ],
            'Accesorios Fitness' => [
                ['Mancuernas 5kg', 'Recubiertas en neopreno'],
                ['Cuerda para saltar', 'Alta velocidad con rodamientos'],
            ],
            'Bebidas' => [
                ['Gaseosa Cola 1.5L', 'Botella retornable'],
                ['Jugo de Naranja Natural', '100% exprimido, sin azúcar añadida'],
            ],
            'Snacks' => [
                ['Maní Salado 200g', 'Empaque sellado al vacío'],
                ['Papas Fritas BBQ', 'Sabor fuerte y crujiente, 100g'],
            ],
            'Enlatados' => [
                ['Atún en Aceite', 'Lata 160g, marca Del Mar'],
                ['Maíz Dulce enlatado', 'Presentación 300g'],
            ],
        ];

        foreach (TipoArticulo::with('categoria')->get() as $tipo) {
            $productosTipo = $nombresPorTipo[$tipo->nombre] ?? [];

            foreach ($productosTipo as [$nombre, $descripcion]) {
                DB::table('productos')->insert([
                    'nombre' => $nombre,
                    'precio' => rand(20000,250000),
                    'descuento' => rand(0, 20),
                    'foto' => 'https://via.placeholder.com/300x300.png?text=' . urlencode($nombre),
                    'descripcion' => $descripcion,
                    'unidad_medida_id' => $unidad?->id,
                    'proveedor_id' => $proveedores->random()->id,
                    'categoria_id' => $tipo->categoria_id,
                    'tipo_articulos_id' => $tipo->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }
}
