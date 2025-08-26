<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class EmpresaSeeder extends Seeder
{
    public function run(): void
    {
        $empresas = [
            [
                'nombre' => 'Comercializadora El Éxito S.A.S.',
                'nit' => '900123456789',
                'telefono' => '6041234567',
                'email' => 'contacto@exito.com.co',
                'direccion' => 'Carrera 43 #45-67',
                'ubicacion' => 'Medellín',
            ],
            [
                'nombre' => 'Distribuciones La 14 Ltda.',
                'nit' => '901234567891',
                'telefono' => '6027654321',
                'email' => 'ventas@la14.com.co',
                'direccion' => 'Calle 34 #10-22',
                'ubicacion' => 'Cali',
            ],
            [
                'nombre' => 'Industria Nacional de Alimentos S.A.',
                'nit' => '902345678912',
                'telefono' => '6013209876',
                'email' => 'info@inal.com.co',
                'direccion' => 'Av. Las Américas #23-10',
                'ubicacion' => 'Bogotá',
            ],
            [
                'nombre' => 'Tecnología Total Group',
                'nit' => '903456789123',
                'telefono' => '6049988776',
                'email' => 'soporte@tecnologiatotal.co',
                'direccion' => 'Carrera 65 #24-12',
                'ubicacion' => 'Medellín',
            ],
            [
                'nombre' => 'Agroindustrias del Norte S.A.S.',
                'nit' => '904567891234',
                'telefono' => '6055566778',
                'email' => 'servicio@agronorte.com',
                'direccion' => 'Calle 8 #50-80',
                'ubicacion' => 'Barranquilla',
            ],
        ];

        foreach ($empresas as $empresa) {
            DB::table('empresas')->insert(array_merge($empresa, [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]));
        }
    }
}
