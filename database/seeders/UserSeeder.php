<?php

namespace Database\Seeders;

use App\Models\Usuario;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('es_ES');

        // Crear usuario admin fijo
        Usuario::create([
                'nombre' => 'Admin',

            'email' => 'jesus.valera@biomedsac.com.pe',
            'apellidos' => 'Valera',
            'password' => Hash::make('admin123'),
            'tipo_usuario' => 'administrador',
            'telefono' => $faker->phoneNumber(),
            'direccion' => $faker->address(),
                'activo' => true,


                'fecha_creacion' => now(),

            'remember_token' => Str::random(10),
        ]);

        // Crear otros 4 usuarios aleatorios
        foreach (range(1, 4) as $i) {
            User::create([
                'nombre' => $faker->name(),
                'apellidos' => $faker->lastName(),
                'email' => $faker->unique()->safeEmail(),
                'password' => Hash::make('password'),
                'tipo_usuario' => $faker->randomElement(['instrumentista', 'despachador', 'almacenista', 'vendedor']),
                'telefono' => $faker->phoneNumber(),
                'direccion' => $faker->address(),
                'activo' => true,
                'fecha_creacion' => now(),
                'remember_token' => Str::random(10),
            ]);
        }
    }
}
