<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesYPermisosSeeder extends Seeder
{
    public function run(): void
    {
        // Limpiar caché de permisos
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Crear permisos (todos con guard_name 'web')
        $permissions = [
            
            // Asignacion de roles
            'admin.users.index',
            'admin.users.create',
            'admin.users.update',

            // Factura Proveedores
            'admin.facturas_proveedores.index',
            'admin.facturas_proveedores.create',
            'admin.facturas_proveedores.update',
            'admin.facturas_proveedores.delete',

            // Proveedores
            'admin.proveedores.index',
            'admin.proveedores.create',
            'admin.proveedores.update',
            'admin.proveedores.delete',

            // Productos
            'admin.productos.index',
            'admin.productos.create',
            'admin.productos.update',
            'admin.productos.delete',

            // Categorías
            'admin.categorias.index',
            'admin.categorias.create',
            'admin.categorias.update',
            'admin.categorias.delete',

            // Tipo de Artículos
            'admin.tipo_articulos.index',
            'admin.tipo_articulos.create',
            'admin.tipo_articulos.update',
            'admin.tipo_articulos.delete',

            // Inventario
            'admin.inventarios.index',
            'admin.inventarios.create',
            'admin.inventarios.update',
            'admin.inventarios.delete',

            // Empresa
            'admin.empresas.index',
            'admin.empresas.create',
            'admin.empresas.update',
            'admin.empresas.delete',

            // Dashboard
            'dashboard',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate([
                'name' => $perm,
                'guard_name' => 'web',
            ]);
        }

        // Crear roles (asegura el guard_name)
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $cliente = Role::firstOrCreate(['name' => 'cliente', 'guard_name' => 'web']);
        $aux = Role::firstOrCreate(['name' => 'aux', 'guard_name' => 'web']);

        // Asignar permisos
        $admin->syncPermissions(Permission::all());

        $cliente->givePermissionTo([
            // Agrega permisos específicos si aplica
        ]);

        $aux->givePermissionTo([
            'admin.productos.index',
            'admin.categorias.index',
            'admin.tipo_articulos.index',
            'admin.inventarios.index',
            'admin.proveedores.index',
            'admin.facturas_proveedores.index',
            'admin.facturas_proveedores.create',
        ]);
    }
}
