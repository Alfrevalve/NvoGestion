<?php

namespace Tests\Unit;

use Tests\TestCase;
use Modules\Cirugias\Http\Models\Instrumentista;

class InstrumentistaTest extends TestCase
{
    /**
     * Test the creation of an Instrumentista instance.
     */
    public function test_create_instrumentista()
    {
        $instrumentista = Instrumentista::create([
            'nombre' => 'Instrumentista de prueba',
            'telefono' => '987654321'
        ]);

        $this->assertNotNull($instrumentista->id);
    }

    /**
     * Test the editing of an Instrumentista instance.
     */
    public function test_edit_instrumentista()
    {
        $instrumentista = Instrumentista::create([
            'nombre' => 'Instrumentista de prueba',
            'telefono' => '987654321'
        ]);

        $instrumentista->nombre = 'Instrumentista actualizado';
        $instrumentista->save();

        $this->assertEquals('Instrumentista actualizado', $instrumentista->nombre);
    }

    /**
     * Test the deletion of an Instrumentista instance.
     */
    public function test_delete_instrumentista()
    {
        $instrumentista = Instrumentista::create([
            'nombre' => 'Instrumentista de prueba',
            'telefono' => '987654321'
        ]);

        $instrumentistaId = $instrumentista->id;
        $instrumentista->delete();

        $this->assertNull(Instrumentista::find($instrumentistaId));
    }
}
