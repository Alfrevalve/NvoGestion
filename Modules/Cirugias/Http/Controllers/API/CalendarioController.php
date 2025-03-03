<?php

namespace Modules\Cirugias\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Modules\Cirugias\Models\Cirugia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class CalendarioController extends Controller
{
    /**
     * Retorna todas las cirugías en formato JSON.
     */
    public function index()
    {
        try {
            $cirugias = Cirugia::with(['medico', 'institucion'])
                ->orderBy('fecha')
                ->get();
                
            // Obtener las próximas cirugías para el panel lateral
            $proximasCirugias = Cirugia::with(['medico', 'institucion'])
                ->where('fecha', '>=', now())
                ->orderBy('fecha')
                ->orderBy('hora')
                ->take(5)
                ->get();
                
            // Preparar los eventos para el calendario
            $eventos = $cirugias->map(function ($cirugia) {
                // Clonar la hora para evitar modificar el atributo original
                $horaInicio = $cirugia->hora;
                $horaFin = (clone $horaInicio)->addMinutes($cirugia->duracion_estimada ?? 60);
                
                return [
                    'id'        => $cirugia->id,
                    'title'     => $cirugia->tipo_cirugia,
                    'start'     => $cirugia->fecha->format('Y-m-d') . 'T' . $horaInicio->format('H:i:s'),
                    'end'       => $cirugia->fecha->format('Y-m-d') . 'T' . $horaFin->format('H:i:s'),
                    'className' => 'estado-' . $cirugia->estado . ' prioridad-' . $cirugia->prioridad,
                    'extendedProps' => [
                        'id'             => $cirugia->id,
                        'medico'         => $cirugia->medico->nombre ?? 'Sin médico',
                        'institucion'    => $cirugia->institucion->nombre ?? 'Sin institución',
                        'estado'         => ucfirst($cirugia->estado),
                        'estadoClass'    => $this->getEstadoClass($cirugia->estado),
                        'prioridad'      => ucfirst($cirugia->prioridad),
                        'prioridadClass' => $this->getPrioridadClass($cirugia->prioridad),
                    ],
                ];
            });
                
            return view('cirugias::calendario', compact('cirugias', 'proximasCirugias', 'eventos'));
        } catch (Throwable $e) {
            Log::error('Error en CalendarioController@index: ' . $e->getMessage());
            return back()->with('error', 'Error al cargar el calendario de cirugías.');
        }
    }

    /**
     * Retorna los eventos de cirugías del mes actual para el calendario.
     */
    public function eventos()
    {
        try {
            $cirugias = Cirugia::with(['medico', 'institucion'])
                ->where('fecha', '>=', now()->startOfMonth())
                ->where('fecha', '<=', now()->endOfMonth())
                ->get();

            $eventos = $cirugias->map(function ($cirugia) {
                // Clonar la hora para evitar modificar el atributo original
                $horaInicio = $cirugia->hora;
                $horaFin = (clone $horaInicio)->addMinutes($cirugia->duracion_estimada ?? 60);

                return [
                    'id'        => $cirugia->id,
                    'title'     => $cirugia->tipo_cirugia,
                    'start'     => $cirugia->fecha->format('Y-m-d') . 'T' . $horaInicio->format('H:i:s'),
                    'end'       => $cirugia->fecha->format('Y-m-d') . 'T' . $horaFin->format('H:i:s'),
                    'className' => 'estado-' . $cirugia->estado . ' prioridad-' . $cirugia->prioridad,
                ];
            });

            return response()->json($eventos);
        } catch (Throwable $e) {
            Log::error('Error en CalendarioController@eventos: ' . $e->getMessage());
            return response()->json(['error' => 'Error al cargar los eventos del calendario.'], 500);
        }
    }

    /**
     * Obtiene la clase CSS para el estado de la cirugía
     */
    private function getEstadoClass($estado)
    {
        switch(strtolower($estado)) {
            case 'pendiente': return 'primary';
            case 'programada': return 'info';
            case 'en proceso': return 'warning';
            case 'finalizada': return 'success';
            default: return 'secondary';
        }
    }
    
    /**
     * Obtiene la clase CSS para la prioridad de la cirugía
     */
    private function getPrioridadClass($prioridad)
    {
        switch(strtolower($prioridad)) {
            case 'baja': return 'success';
            case 'media': return 'info';
            case 'alta': return 'warning';
            case 'urgente': return 'danger';
            default: return 'secondary';
        }
    }
}
