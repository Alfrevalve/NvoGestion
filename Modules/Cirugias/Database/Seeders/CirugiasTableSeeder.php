<?php

namespace Modules\Cirugias\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CirugiasTableSeeder extends Seeder
{
    public function run()
    {
        // Crear una institución
        $institucionId = DB::table('instituciones')->insertGetId([
            'nombre' => 'Hospital Central',
            'direccion' => 'Av. Principal 123',
            'telefono' => '555-1234',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Crear un médico
        $medicoId = DB::table('medicos')->insertGetId([
            'nombre' => 'Dr. Juan Pérez',
            'especialidad' => 'Cirujano General',
            'telefono' => '555-5678',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Crear un instrumentista
        $instrumentistaId = DB::table('instrumentistas')->insertGetId([
            'nombre' => 'María García',
            'telefono' => '555-9012',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Crear un equipo
        $equipoId = DB::table('equipos')->insertGetId([
            'nombre' => 'Equipo Quirúrgico A',
            'descripcion' => 'Equipo completo para cirugía general',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Crear un material
        $materialId = DB::table('materiales')->insertGetId([
            'nombre' => 'Kit Quirúrgico Básico',
            'descripcion' => 'Instrumental básico para cirugía',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Crear cirugías de ejemplo
        $estados = ['pendiente', 'programada', 'en proceso', 'finalizada'];
        $fechaBase = Carbon::now();

        foreach ($estados as $index => $estado) {
            DB::table('cirugias')->insert([
                'fecha' => $fechaBase->copy()->addDays($index),
                'hora' => $fechaBase->copy()->setHour(9 + $index)->format('H:i:s'),
                'estado' => $estado,
                'institucion_id' => $institucionId,
                'medico_id' => $medicoId,
                'instrumentista_id' => $instrumentistaId,
                'equipo_id' => $equipoId,
                'material_id' => $materialId,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
