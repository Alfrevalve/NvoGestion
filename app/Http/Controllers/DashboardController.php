<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Actividad;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Estadísticas de Cirugías
        $cirugiasPendientes = $this->getCirugiasPendientes();
        $cirugiasCompletadas = $this->getCirugiasCompletadas();

        // Estadísticas de Almacén
        $stockBajo = $this->getStockBajo();

        // Estadísticas de Despacho
        $despachosPendientes = $this->getDespachosPendientes();

        // Eventos del Calendario
        $eventos = $this->getEventosCalendario();

        // Actividades Recientes
        $actividades = Actividad::with('user')
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($actividad) {
                return [
                    'titulo' => $actividad->descripcion,
                    'descripcion' => $actividad->detalles,
                    'icono' => $this->getIconoActividad($actividad->tipo),
                    'created_at' => $actividad->created_at
                ];
            });

        return view('dashboard', compact(
            'cirugiasPendientes',
            'cirugiasCompletadas',
            'stockBajo',
            'despachosPendientes',
            'eventos',
            'actividades'
        ));
    }

    private function getCirugiasPendientes()
    {
        try {
            return app('Modules\Cirugias\Models\Cirugia')::where('estado', 'pendiente')->count();
        } catch (\Exception $e) {
            return 0;
        }
    }

    private function getCirugiasCompletadas()
    {
        try {
            return app('Modules\Cirugias\Models\Cirugia')::where('estado', 'finalizada')->count();
        } catch (\Exception $e) {
            return 0;
        }
    }

    private function getStockBajo()
    {
        try {
            return app('Modules\Almacen\Models\Inventario')::whereRaw('cantidad <= stock_minimo')->count();
        } catch (\Exception $e) {
            return 0;
        }
    }

    private function getDespachosPendientes()
    {
        try {
            return app('Modules\Despacho\Models\Despacho')::where('estado', 'pendiente')->count();
        } catch (\Exception $e) {
            return 0;
        }
    }

    private function getEventosCalendario()
    {
        try {
            return app('Modules\Cirugias\Models\Cirugia')::with(['medico', 'institucion'])
                ->where('fecha', '>=', Carbon::now()->startOfMonth())
                ->where('fecha', '<=', Carbon::now()->endOfMonth())
                ->get()
                ->map(function ($cirugia) {
                    return [
                        'id' => $cirugia->id,
                        'title' => $cirugia->tipo_cirugia,
                        'start' => $cirugia->fecha->format('Y-m-d') . 'T' . $cirugia->hora->format('H:i:s'),
                        'end' => $cirugia->fecha->format('Y-m-d') . 'T' . $cirugia->hora->addMinutes($cirugia->duracion_estimada ?? 60)->format('H:i:s'),
                        'className' => 'estado-' . $cirugia->estado . ' prioridad-' . $cirugia->prioridad,
                        'extendedProps' => [
                            'medico' => $cirugia->medico->nombre,
                            'institucion' => $cirugia->institucion->nombre,
                            'estado' => ucfirst($cirugia->estado),
                            'prioridad' => ucfirst($cirugia->prioridad),
                            'estadoClass' => $this->getEstadoClass($cirugia->estado),
                            'prioridadClass' => $this->getPrioridadClass($cirugia->prioridad),
                        ]
                    ];
                });
        } catch (\Exception $e) {
            return collect([]);
        }
    }

    private function getEstadoClass($estado)
    {
        return [
            'pendiente' => 'primary',
            'programada' => 'info',
            'en proceso' => 'warning',
            'finalizada' => 'success',
            'cancelada' => 'danger',
        ][$estado] ?? 'secondary';
    }

    private function getPrioridadClass($prioridad)
    {
        return [
            'baja' => 'success',
            'media' => 'info',
            'alta' => 'warning',
            'urgente' => 'danger',
        ][$prioridad] ?? 'secondary';
    }

    private function getIconoActividad($tipo)
    {
        return [
            'cirugia' => 'procedures',
            'inventario' => 'box',
            'despacho' => 'truck',
            'usuario' => 'user',
            'sistema' => 'cog',
        ][$tipo] ?? 'info-circle';
    }
}
