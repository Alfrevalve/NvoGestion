<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Crear permisos para cada módulo
        // Cirugías
        $this->createPermissions([
            'ver cirugias',
            'crear cirugias',
            'editar cirugias',
            'eliminar cirugias',
            'ver calendario',
        ]);

        // Almacén
        $this->createPermissions([
            'ver inventario',
            'crear items',
            'editar items',
            'eliminar items',
            'gestionar stock',
        ]);

        // Despacho
        $this->createPermissions([
            'ver despachos',
            'crear despachos',
            'editar despachos',
            'eliminar despachos',
            'gestionar entregas',
        ]);

        // Administración
        $this->createPermissions([
            'ver usuarios',
            'crear usuarios',
            'editar usuarios',
            'eliminar usuarios',
            'gestionar roles',
            'ver configuracion',
            'editar configuracion',
        ]);

        // Crear roles y asignar permisos
        // Super Admin
        $role = Role::create(['name' => 'super-admin']);
        $role->givePermissionTo(Permission::all());

        // Administrador
        $role = Role::create(['name' => 'administrador']);
        $role->givePermissionTo([
            'ver cirugias', 'crear cirugias', 'editar cirugias',
            'ver inventario', 'gestionar stock',
            'ver despachos', 'gestionar entregas',
            'ver usuarios', 'editar usuarios',
            'ver configuracion',
        ]);

        // Médico
        $role = Role::create(['name' => 'medico']);
        $role->givePermissionTo([
            'ver cirugias', 'crear cirugias', 'editar cirugias',
            'ver calendario',
            'ver inventario',
            'ver despachos',
        ]);

        // Instrumentista
        $role = Role::create(['name' => 'instrumentista']);
        $role->givePermissionTo([
            'ver cirugias',
            'ver calendario',
            'ver inventario',
            'ver despachos',
        ]);

        // Almacenista
        $role = Role::create(['name' => 'almacenista']);
        $role->givePermissionTo([
            'ver inventario', 'crear items', 'editar items', 'eliminar items', 'gestionar stock',
            'ver despachos', 'crear despachos', 'editar despachos',
        ]);

        // Despachador
        $role = Role::create(['name' => 'despachador']);
        $role->givePermissionTo([
            'ver despachos', 'crear despachos', 'editar despachos', 'gestionar entregas',
            'ver inventario',
        ]);
    }

    private function createPermissions(array $permissions)
    {
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
