<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Models\User;

echo "Verificando permisos de usuarios por rol...\n";

$users = User::all();
foreach ($users as $user) {
    echo "\nUsuario: {$user->name} ({$user->email})\n";
    
    // Obtener roles
    $roles = $user->getRoleNames();
    echo "Roles: " . implode(', ', $roles->toArray()) . "\n";
    
    // Obtener permisos
    $permissions = $user->getAllPermissions()->pluck('name');
    echo "Permisos: " . implode(', ', $permissions->toArray()) . "\n";
    
    echo "-------------------------------------------\n";
}

echo "\nVerificación completada.\n";