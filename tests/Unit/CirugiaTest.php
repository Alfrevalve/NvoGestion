<?php

namespace Tests\Unit;

use Tests\TestCase;
use Modules\Cirugias\Http\Models\Cirugia;

class CirugiaTest extends TestCase
{
    /**
     * Test the creation of a Cirugia instance.
     */
    public function test_create_cirugia()
    {
        $cirugia = Cirugia::create([
            'institucion_id' => 1,
            'medico_id' => 1,
            'instrumentista_id' => 1,
            'equipo_id' => 1,
            'material_id' => 1,
            'fecha' => now(),
            'hora' => now(),
            'estado' => 'pendiente',
            'observaciones' => 'Observaciones de prueba',
            'duracion_estimada' => 60,
            'tipo_cirugia' => 'Tipo de prueba',
            'prioridad' => 'media'
        ]);

        $this->assertNotNull($cirugia->id);
    }

    /**
     * Test the editing of a Cirugia instance.
     */
    public function test_edit_cirugia()
    {
        $cirugia = Cirugia::create([
            'institucion_id' => 1,
            'medico_id' => 1,
            'instrumentista_id' => 1,
            'equipo_id' => 1,
            'material_id' => 1,
            'fecha' => now(),
            'hora' => now(),
            'estado' => 'pendiente',
            'observaciones' => 'Observaciones de prueba',
            'duracion_estimada' => 60,
            'tipo_cirugia' => 'Tipo de prueba',
            'prioridad' => 'media'
        ]);

        $cirugia->estado = 'programada';
        $cirugia->save();

        $this->assertEquals('programada', $cirugia->estado);
    }

    /**
     * Test the deletion of a Cirugia instance.
     */
    public function test_delete_cirugia()
    {
        $cirugia = Cirugia::create([
            'institucion_id' => 1,
            'medico_id' => 1,
            'instrumentista_id' => 1,
            'equipo_id' => 1,
            'material_id' => 1,
            'fecha' => now(),
            'hora' => now(),
            'estado' => 'pendiente',
            'observaciones' => 'Observaciones de prueba',
            'duracion_estimada' => 60,
            'tipo_cirugia' => 'Tipo de prueba',
            'prioridad' => 'media'
        ]);

        $cirugiaId = $cirugia->id;
        $cirugia->delete();

        $this->assertNull(Cirugia::find($cirugiaId));
    }
}
