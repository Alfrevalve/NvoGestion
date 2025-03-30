<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AsignacionConfiguracion;
use App\Models\Medico;
use App\Models\Producto;
use App\Models\Hospital;

class AsignacionConfiguracionSeeder extends Seeder
{
    public function run(): void
    {
        $medicos = Medico::all();
        $productos = Producto::all();
        $hospitales = Hospital::all();

        foreach (range(1, 10) as $i) {
            AsignacionConfiguracion::create([
                'medico_id' => $medicos->random()->id,
                'producto_id' => $productos->random()->id,
                'hospital_id' => $hospitales->random()->id,
            ]);
        }
    }
}
