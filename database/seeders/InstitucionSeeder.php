<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Institucion;
use Faker\Factory as Faker;

class InstitucionSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('es_ES');

        foreach (range(1, 5) as $i) {
            Institucion::create([
                'nombre' => 'Institución ' . $faker->companySuffix(),
                'tipo' => $faker->randomElement(['Pública', 'Privada']),
                'ubicacion' => $faker->address(),
            ]);
        }
    }
}
