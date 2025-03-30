<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cirugia;
use App\Models\Medico;
use App\Models\Hospital;
use Faker\Factory as Faker;

class CirugiaSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('es_ES');

        $medicos = Medico::all();
        $hospitales = Hospital::all();

        foreach (range(1, 10) as $i) {
            Cirugia::create([
                'tipo' => $faker->randomElement(['Craneotomía', 'Columna', 'Ortopédica']),
                'fecha' => $faker->dateTimeBetween('-1 year', 'now'),
                'medico_id' => $medicos->random()->id,
                'hospital_id' => $hospitales->random()->id,
            ]);
        }
    }
}
