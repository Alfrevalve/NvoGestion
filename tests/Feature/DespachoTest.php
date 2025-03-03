<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Modules\Despacho\Models\Despacho;

class DespachoTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_dispatch()
    {
        $response = $this->post(route('despacho.store'), [
            'pedido_id' => 1,
            'estado' => 'En tránsito',
            'fecha_despacho' => '2023-01-01',
            'destinatario' => 'Juan Pérez',
            'direccion' => 'Calle Falsa 123',
            'observaciones' => 'Ninguna',
        ]);

        $response->assertRedirect(route('despacho.index'));
        $this->assertDatabaseHas('despachos', [
            'pedido_id' => 1,
            'destinatario' => 'Juan Pérez',
        ]);
    }

    /** @test */
    public function it_displays_dispatches()
    {
        Despacho::factory()->create([
            'pedido_id' => 1,
            'destinatario' => 'Juan Pérez',
        ]);

        $response = $this->get(route('despacho.index'));
        $response->assertStatus(200);
        $response->assertSee('Juan Pérez');
    }
}
