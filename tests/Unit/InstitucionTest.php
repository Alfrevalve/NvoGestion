<?php

namespace Tests\Unit;

use Tests\TestCase;
use Modules\Cirugias\Http\Models\Institucion;

class InstitucionTest extends TestCase
{
    /**
     * Test the creation of an Institucion instance.
     */
    public function test_create_institucion()
    {
        $institucion = Institucion::create([
            'nombre' => 'Institución de prueba',
            'direccion' => 'Dirección de prueba',
            'telefono' => '123456789'
        ]);

        $this->assertNotNull($institucion->id);
    }

    /**
     * Test the editing of an Institucion instance.
     */
    public function test_edit_institucion()
    {
        $institucion = Institucion::create([
            'nombre' => 'Institución de prueba',
            'direccion' => 'Dirección de prueba',
            'telefono' => '123456789'
        ]);

        $institucion->nombre = 'Institución actualizada';
        $institucion->save();

        $this->assertEquals('Institución actualizada', $institucion->nombre);
    }

    /**
     * Test the deletion of an Institucion instance.
     */
    public function test_delete_institucion()
    {
        $institucion = Institucion::create([
            'nombre' => 'Institución de prueba',
            'direccion' => 'Dirección de prueba',
            'telefono' => '123456789'
        ]);

        $institucionId = $institucion->id;
        $institucion->delete();

        $this->assertNull(Institucion::find($institucionId));
    }
}
