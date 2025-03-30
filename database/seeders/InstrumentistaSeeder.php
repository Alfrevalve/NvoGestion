<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Instrumentista;
use Faker\Factory as Faker;

class InstrumentistaSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('es_ES');

        foreach (range(1, 8) as $i) {
            Instrumentista::create([
                'nombre' => $faker->name(),
                'telefono' => $faker->phoneNumber(),
                'email' => $faker->unique()->safeEmail(),
                'activo' => true,
            ]);
        }
    }
}
