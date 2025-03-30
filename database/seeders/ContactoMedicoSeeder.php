<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ContactoMedico;
use App\Models\Medico;
use App\Models\User;
use Faker\Factory as Faker;

class ContactoMedicoSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('es_ES');
        $medicos = Medico::all();
        $usuarios = User::all();

        foreach (range(1, 10) as $i) {
            ContactoMedico::create([
                'medico_id' => $medicos->random()->id,
                'fecha_contacto' => $faker->dateTimeBetween('-3 months', 'now'),
                'tipo_contacto' => $faker->randomElement(['Visita', 'Llamada', 'Email']),
                'detalle' => $faker->sentence(),
                'usuario_id' => $usuarios->random()->id,
            ]);
        }
    }
}
