<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Database\Seeders\CategoriaSeeder;
use Database\Seeders\RolesYPermisosSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\ProveedorSeeder;
use Database\Seeders\TipoArticuloSeeder;
use Database\Seeders\UnidadMedidaSeeder;
use Database\Seeders\ProductoSeeder;

use function Laravel\Prompts\password;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //User::factory(10)->create();

        
        
        
        $this->call([
        RolesYPermisosSeeder::class,
        UserSeeder::class,
        ProveedorSeeder::class,
        CategoriaSeeder::class,
        TipoArticuloSeeder::class,
        UnidadMedidaSeeder::class,
        ProductoSeeder::class,
        PostSeeder::class,
        EmpresaSeeder::class,
        
    ]);
    

    }
}
