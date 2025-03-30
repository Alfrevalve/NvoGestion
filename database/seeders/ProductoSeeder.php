<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Producto;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('es_ES');

        foreach (range(1, 10) as $i) {
            Producto::create([
                'codigo' => strtoupper(Str::random(6)),
                'nombre' => ucfirst($faker->word()),
                'stock_minimo' => $faker->numberBetween(5, 50),
                'stock_actual' => $faker->numberBetween(5, 50),
            ]);
        }
    }
}
