<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ProveedorSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('proveedores')->insert([
            [
                'nombre'    => 'Distribuciones La Montaña',
                'nit'       => '9001234567',
                'telefono'  => '3101234567',
                'email'     => 'contacto@lamontana.com',
                'direccion' => 'Calle 45 #10-22',
                'ubicacion' => 'Medellín',
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now(),
            ],
            [
                'nombre'    => 'Comercializadora El Centro',
                'nit'       => '9007654321',
                'telefono'  => '3157654321',
                'email'     => 'ventas@elcentro.com',
                'direccion' => 'Carrera 12 #35-40',
                'ubicacion' => 'Bogotá',
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now(),
            ],
            [
                'nombre'    => 'Insumos Industriales SAS',
                'nit'       => '8001234560',
                'telefono'  => '3120001122',
                'email'     => 'info@insumos.com',
                'direccion' => 'Av. Industriales #70-30',
                'ubicacion' => 'Cali',
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now(),
            ],
            [
                'nombre'    => 'Proveedora del Caribe',
                'nit'       => '8112345678',
                'telefono'  => '3205556677',
                'email'     => 'caribe@proveedora.com',
                'direccion' => 'Calle 25 #5-60',
                'ubicacion' => 'Barranquilla',
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now(),
            ],
            [
                'nombre'    => 'Almacenes Global',
                'nit'       => '9012345678',
                'telefono'  => '3001112233',
                'email'     => 'global@almacenes.com',
                'direccion' => 'Transversal 24 #18-80',
                'ubicacion' => 'Cartagena',
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now(),
            ],
        ]);
    }
}
