<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Modules\Cirugias\Models\ReporteCirugia;

class ReporteCirugiaTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_generates_reports_based_on_filters()
    {
        // Create test data
        ReporteCirugia::factory()->create([
            'fecha' => '2023-01-01',
            'tipo_cirugia' => 'Cardiaca',
            'estado' => 'finalizada',
            'prioridad' => 'alta',
        ]);

        ReporteCirugia::factory()->create([
            'fecha' => '2023-01-02',
            'tipo_cirugia' => 'Ortopedica',
            'estado' => 'programada',
            'prioridad' => 'media',
        ]);

        // Test report generation with filters
        $response = $this->get('/reportes/generate?fecha_inicio=2023-01-01&fecha_fin=2023-01-02&estado=finalizada&prioridad=alta');

        $response->assertStatus(200);
        $response->assertViewHas('reports');
        $this->assertCount(1, $response->viewData('reports'));
    }
}
