<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Modules\Almacen\Models\Inventario;

class AlmacenTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_an_inventory_item()
    {
        $response = $this->post(route('almacen.store'), [
            'nombre' => 'Sutura',
            'cantidad' => 100,
            'estado' => 'Disponible',
            'ubicacion' => 'Estante 1',
            'tipo' => 'Material',
        ]);

        $response->assertRedirect(route('almacen.index'));
        $this->assertDatabaseHas('inventarios', [
            'nombre' => 'Sutura',
            'cantidad' => 100,
        ]);
    }

    /** @test */
    public function it_displays_inventory_items()
    {
        Inventario::factory()->create([
            'nombre' => 'Sutura',
            'cantidad' => 100,
        ]);

        $response = $this->get(route('almacen.index'));
        $response->assertStatus(200);
        $response->assertSee('Sutura');
    }
}
