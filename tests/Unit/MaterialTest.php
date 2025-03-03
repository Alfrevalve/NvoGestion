<?php

namespace Tests\Unit;

use Tests\TestCase;
use Modules\Cirugias\Http\Models\Material;

class MaterialTest extends TestCase
{
    /**
     * Test the creation of a Material instance.
     */
    public function test_create_material()
    {
        $material = Material::create([
            'nombre' => 'Material de prueba',
            'codigo' => 'MTR123',
            'cantidad' => 100,
            'cantidad_minima' => 10,
            'descripcion' => 'Descripción de prueba'
        ]);

        $this->assertNotNull($material->id);
    }

    /**
     * Test the editing of a Material instance.
     */
    public function test_edit_material()
    {
        $material = Material::create([
            'nombre' => 'Material de prueba',
            'codigo' => 'MTR123',
            'cantidad' => 100,
            'cantidad_minima' => 10,
            'descripcion' => 'Descripción de prueba'
        ]);

        $material->nombre = 'Material actualizado';
        $material->save();

        $this->assertEquals('Material actualizado', $material->nombre);
    }

    /**
     * Test the deletion of a Material instance.
     */
    public function test_delete_material()
    {
        $material = Material::create([
            'nombre' => 'Material de prueba',
            'codigo' => 'MTR123',
            'cantidad' => 100,
            'cantidad_minima' => 10,
            'descripcion' => 'Descripción de prueba'
        ]);

        $materialId = $material->id;
        $material->delete();

        $this->assertNull(Material::find($materialId));
    }
}
