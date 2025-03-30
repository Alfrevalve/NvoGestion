<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class AssignRolesToUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Asegurarse de que todos los usuarios tengan un rol
        $users = User::all();
        $rolesAsignados = 0;
        
        foreach ($users as $user) {
            if (!$user->hasAnyRole(Role::all())) {
                // Si el usuario no tiene ningún rol, asignarle uno basado en su email
                if (strpos($user->email, 'admin') !== false) {
                    $user->assignRole('administrador');
                    $rolesAsignados++;
                } else if (strpos($user->email, 'medico') !== false || strpos($user->email, 'doctor') !== false) {
                    $user->assignRole('medico');
                    $rolesAsignados++;
                } else if (strpos($user->email, 'instrumentista') !== false) {
                    $user->assignRole('instrumentista');
                    $rolesAsignados++;
                } else if (strpos($user->email, 'almacen') !== false) {
                    $user->assignRole('almacenista');
                    $rolesAsignados++;
                } else if (strpos($user->email, 'despacho') !== false) {
                    $user->assignRole('despachador');
                    $rolesAsignados++;
                } else {
                    // Por defecto, asignar el rol de instrumentista
                    $user->assignRole('instrumentista');
                    $rolesAsignados++;
                }
            }
        }

        $this->command->info("Se asignaron roles a {$rolesAsignados} usuarios que no tenían roles.");
    }
}