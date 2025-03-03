<?php

namespace Tests\Unit;

use Tests\TestCase;
use Modules\Cirugias\Http\Models\Medico;

class MedicoTest extends TestCase
{
    /**
     * Test the creation of a Medico instance.
     */
    public function test_create_medico()
    {
        $medico = Medico::create([
            'nombre' => 'Médico de prueba',
            'especialidad' => 'Especialidad de prueba',
            'telefono' => '123456789'
        ]);

        $this->assertNotNull($medico->id);
    }

    /**
     * Test the editing of a Medico instance.
     */
    public function test_edit_medico()
    {
        $medico = Medico::create([
            'nombre' => 'Médico de prueba',
            'especialidad' => 'Especialidad de prueba',
            'telefono' => '123456789'
        ]);

        $medico->nombre = 'Médico actualizado';
        $medico->save();

        $this->assertEquals('Médico actualizado', $medico->nombre);
    }

    /**
     * Test the deletion of a Medico instance.
     */
    public function test_delete_medico()
    {
        $medico = Medico::create([
            'nombre' => 'Médico de prueba',
            'especialidad' => 'Especialidad de prueba',
            'telefono' => '123456789'
        ]);

        $medicoId = $medico->id;
        $medico->delete();

        $this->assertNull(Medico::find($medicoId));
    }
}
