<?php

namespace Tests\Unit;

use Tests\TestCase;
use Modules\Cirugias\Http\Models\Equipo;

class EquipoTest extends TestCase
{
    /**
     * Test the creation of an Equipo instance.
     */
    public function test_create_equipo()
    {
        $equipo = Equipo::create([
            'nombre' => 'Equipo de prueba',
            'descripcion' => 'Descripción de prueba',
            'numero_serie' => '123456',
            'fecha_adquisicion' => now(),
            'fecha_mantenimiento' => now()->addDays(30),
            'estado' => 'disponible',
            'notas' => 'Notas de prueba'
        ]);

        $this->assertNotNull($equipo->id);
    }

    /**
     * Test the editing of an Equipo instance.
     */
    public function test_edit_equipo()
    {
        $equipo = Equipo::create([
            'nombre' => 'Equipo de prueba',
            'descripcion' => 'Descripción de prueba',
            'numero_serie' => '123456',
            'fecha_adquisicion' => now(),
            'fecha_mantenimiento' => now()->addDays(30),
            'estado' => 'disponible',
            'notas' => 'Notas de prueba'
        ]);

        $equipo->estado = 'en uso';
        $equipo->save();

        $this->assertEquals('en uso', $equipo->estado);
    }

    /**
     * Test the deletion of an Equipo instance.
     */
    public function test_delete_equipo()
    {
        $equipo = Equipo::create([
            'nombre' => 'Equipo de prueba',
            'descripcion' => 'Descripción de prueba',
            'numero_serie' => '123456',
            'fecha_adquisicion' => now(),
            'fecha_mantenimiento' => now()->addDays(30),
            'estado' => 'disponible',
            'notas' => 'Notas de prueba'
        ]);

        $equipoId = $equipo->id;
        $equipo->delete();

        $this->assertNull(Equipo::find($equipoId));
    }
}
