<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AssignRolesSeeder extends Seeder
{
    public function run()
    {
        // Crear usuario super-admin si no existe
        $admin = User::firstOrCreate(
            ['email' => 'admin@nvogestion.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
            ]
        );

        // Asignar rol de super-admin
        $admin->assignRole('super-admin');

        // Crear usuarios de ejemplo para cada rol
        $this->createUserWithRole('medico@nvogestion.com', 'Médico', 'medico123', 'medico');
        $this->createUserWithRole('instrumentista@nvogestion.com', 'Instrumentista', 'instrumentista123', 'instrumentista');
        $this->createUserWithRole('almacenista@nvogestion.com', 'Almacenista', 'almacenista123', 'almacenista');
        $this->createUserWithRole('despachador@nvogestion.com', 'Despachador', 'despachador123', 'despachador');
    }

    private function createUserWithRole($email, $name, $password, $role)
    {
        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make($password),
                'email_verified_at' => now(),
            ]
        );

        $user->assignRole($role);
    }
}
