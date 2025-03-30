<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Actividad;
use App\Models\User;
use Faker\Factory as Faker;

class ActividadSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('es_ES');
        $usuarios = User::all();

        foreach (range(1, 10) as $i) {
            Actividad::create([
                'nombre' => $faker->sentence(3),
                'descripcion' => $faker->paragraph(),
                'fecha' => $faker->dateTimeBetween('-2 months', 'now'),
                'usuario_id' => $usuarios->random()->id,
                'last_seen_at' => now(),
            ]);
        }
    }
}
