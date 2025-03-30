<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Ejecutar todos los seeders necesarios
        $this->call([
            UserSeeder::class,
            MedicoSeeder::class,
            HospitalSeeder::class,
            ProductoSeeder::class,
            ClienteSeeder::class,
            InstitucionSeeder::class,
            PacienteSeeder::class,
            InstrumentistaSeeder::class,
        ]);
    }
}
