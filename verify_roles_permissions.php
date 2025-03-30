<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "Verificando tablas de roles y permisos...\n";

// Verificar si existen las tablas
$tables = [
    'roles',
    'permissions',
    'model_has_roles',
    'model_has_permissions',
    'role_has_permissions',
    'users'
];

foreach ($tables as $table) {
    if (Schema::hasTable($table)) {
        echo "✓ Tabla {$table} existe\n";
    } else {
        echo "✗ Tabla {$table} no existe\n";
    }
}

// Contar roles
if (Schema::hasTable('roles')) {
    $rolesCount = DB::table('roles')->count();
    echo "\nRoles encontrados: {$rolesCount}\n";
    
    if ($rolesCount > 0) {
        $roles = DB::table('roles')->get();
        echo "Lista de roles:\n";
        foreach ($roles as $role) {
            echo "- " . $role->name . "\n";
        }
    } else {
        echo "No hay roles definidos en el sistema.\n";
    }
}

// Contar permisos
if (Schema::hasTable('permissions')) {
    $permissionsCount = DB::table('permissions')->count();
    echo "\nPermisos encontrados: {$permissionsCount}\n";
    
    if ($permissionsCount > 0) {
        echo "Primeros 10 permisos:\n";
        $permissions = DB::table('permissions')->limit(10)->get();
        foreach ($permissions as $permission) {
            echo "- " . $permission->name . "\n";
        }
        
        if ($permissionsCount > 10) {
            echo "... y " . ($permissionsCount - 10) . " más\n";
        }
    } else {
        echo "No hay permisos definidos en el sistema.\n";
    }
}

// Verificar usuarios con roles
if (Schema::hasTable('users') && Schema::hasTable('model_has_roles')) {
    $totalUsers = DB::table('users')->count();
    
    // Usuarios con roles asignados
    $usersWithRoles = DB::table('model_has_roles')
        ->select('model_id')
        ->distinct()
        ->where('model_type', 'App\\Models\\User')
        ->count();
    
    $usersWithoutRoles = $totalUsers - $usersWithRoles;
    
    echo "\nUsuarios encontrados: {$totalUsers}\n";
    echo "Usuarios con roles asignados: {$usersWithRoles}\n";
    echo "Usuarios sin roles asignados: {$usersWithoutRoles}\n";
    
    if ($usersWithoutRoles > 0) {
        echo "\nUsuarios sin roles asignados:\n";
        
        $usersWithRolesIds = DB::table('model_has_roles')
            ->select('model_id')
            ->where('model_type', 'App\\Models\\User')
            ->pluck('model_id')
            ->toArray();
        
        $usersWithoutRolesData = DB::table('users')
            ->whereNotIn('id', $usersWithRolesIds)
            ->get();
        
        foreach ($usersWithoutRolesData as $user) {
            echo "- ID: " . $user->id . ", Nombre: " . $user->name . ", Email: " . $user->email . "\n";
        }
    }
}

// Verificar relación entre roles y permisos
if (Schema::hasTable('role_has_permissions')) {
    $rolePermissionsCount = DB::table('role_has_permissions')->count();
    echo "\nRelaciones entre roles y permisos: {$rolePermissionsCount}\n";
    
    if ($rolePermissionsCount > 0 && Schema::hasTable('roles')) {
        echo "\nPermisos por rol:\n";
        $roles = DB::table('roles')->get();
        
        foreach ($roles as $role) {
            $permissionCount = DB::table('role_has_permissions')
                ->where('role_id', $role->id)
                ->count();
            
            echo "- " . $role->name . ": " . $permissionCount . " permisos\n";
        }
    }
}

echo "\nVerificación completada.\n";