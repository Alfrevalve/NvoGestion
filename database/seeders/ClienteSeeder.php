<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cliente;
use Faker\Factory as Faker;

class ClienteSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('es_ES');

        foreach (range(1, 10) as $i) {
            Cliente::create([
                'nombre' => $faker->company(),
                'tipo_documento' => 'ruc',
                'numero_documento' => $faker->unique()->numerify('20#########'),
                'direccion' => $faker->address(),
            ]);
        }
    }
}
