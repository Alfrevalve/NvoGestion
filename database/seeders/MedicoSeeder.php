<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Medico;
use Faker\Factory as Faker;

class MedicoSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('es_ES');

        foreach (range(1, 10) as $i) {
            Medico::create([
                'codigo' => strtoupper(Str::random(5)),
                'nombre' => $faker->firstName(),
                'apellidos' => $faker->lastName(),
                'especialidad' => $faker->randomElement(['Neurocirugía', 'Ortopedia', 'Cardiología']),
                'telefono' => $faker->phoneNumber(),
                'email' => $faker->unique()->safeEmail(),
                'direccion' => $faker->address(),
                'hospital_principal' => $faker->company(),
                'observaciones' => $faker->sentence(),
                'activo' => true,
            ]);
        }
    }
}
