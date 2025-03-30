<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hospital;
use Faker\Factory as Faker;

class HospitalSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('es_ES');

        foreach (range(1, 5) as $i) {
            Hospital::create([
                'nombre' => 'Hospital ' . $faker->city(),
                'direccion' => $faker->address(),
            ]);
        }
    }
}
