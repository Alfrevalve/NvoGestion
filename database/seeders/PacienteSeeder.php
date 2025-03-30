<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Paciente;
use Faker\Factory as Faker;

class PacienteSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('es_ES');

        foreach (range(1, 10) as $i) {
            Paciente::create([
                'nombre' => $faker->firstName(),
                'apellidos' => $faker->lastName(),
                'fecha_nacimiento' => $faker->date('Y-m-d', '-10 years'),
                'genero' => $faker->randomElement(['Masculino', 'Femenino']),
                'diagnostico' => $faker->sentence(),
            ]);
        }
    }
}
