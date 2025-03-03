<?php

namespace Modules\Cirugias\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Modules\Cirugias\Models\Cirugia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class KanbanController extends Controller
{
    public function index()
    {
        try {
            // Obtener errores de la sesión (si existen)
            $errors = session('errors', new \Illuminate\Support\MessageBag());

            // Categorizar cirugías por estado
            $cirugias = [
                'pendiente' => Cirugia::where('estado', 'pendiente')
                    ->with(['institucion', 'medico', 'instrumentista'])
                    ->orderBy('fecha')
                    ->orderBy('hora')
                    ->get(),

                'programada' => Cirugia::where('estado', 'programada')
                    ->with(['institucion', 'medico', 'instrumentista'])
                    ->orderBy('fecha')
                    ->orderBy('hora')
                    ->get(),

                'en proceso' => Cirugia::where('estado', 'en proceso')
                    ->with(['institucion', 'medico', 'instrumentista'])
                    ->orderBy('fecha')
                    ->orderBy('hora')
                    ->get(),

                'finalizada' => Cirugia::where('estado', 'finalizada')
                    ->with(['institucion', 'medico', 'instrumentista'])
                    ->orderBy('fecha', 'desc')
                    ->orderBy('hora', 'desc')
                    ->take(10) // Últimas 10 cirugías finalizadas
                    ->get(),
            ];

            // Estadísticas generales
            $stats = [
                'total'         => Cirugia::count(),
                'pendientes'    => Cirugia::where('estado', 'pendiente')->count(),
                'programadas'   => Cirugia::where('estado', 'programada')->count(),
                'en_proceso'    => Cirugia::where('estado', 'en proceso')->count(),
                'finalizadas'   => Cirugia::where('estado', 'finalizada')->count(),
                'hoy'           => Cirugia::whereDate('fecha', today())->count(),
                'semana'        => Cirugia::whereBetween('fecha', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            ];

            // Generar alertas según condiciones
            $alertas = [];

            $cirugiasAtrasadas = Cirugia::whereIn('estado', ['pendiente', 'programada'])
                ->where('fecha', '<', today())
                ->count();
            if ($cirugiasAtrasadas > 0) {
                $alertas[] = [
                    'tipo'    => 'danger',
                    'mensaje' => "Hay {$cirugiasAtrasadas} cirugías atrasadas que requieren atención."
                ];
            }

            $cirugiasHoy = Cirugia::whereDate('fecha', today())
                ->whereIn('estado', ['pendiente', 'programada'])
                ->count();
            if ($cirugiasHoy > 0) {
                $alertas[] = [
                    'tipo'    => 'info',
                    'mensaje' => "Hay {$cirugiasHoy} cirugías programadas para hoy."
                ];
            }

            $cirugiasEnProceso = Cirugia::where('estado', 'en proceso')->count();
            if ($cirugiasEnProceso > 0) {
                $alertas[] = [
                    'tipo'    => 'warning',
                    'mensaje' => "Hay {$cirugiasEnProceso} cirugías en proceso actualmente."
                ];
            }

            // Cirugías del mes actual y del mes anterior
            $totalSurgeriesCurrentMonth = Cirugia::whereMonth('fecha', now()->month)
                ->whereYear('fecha', now()->year)
                ->count();
            $totalSurgeriesLastMonth = Cirugia::whereMonth('fecha', now()->subMonth()->month)
                ->whereYear('fecha', now()->year)
                ->count();

            // Lista general de cirugías
            $surgeries = Cirugia::with(['institucion', 'medico', 'instrumentista'])
                ->orderBy('fecha')
                ->orderBy('hora')
                ->get();

            return view('cirugias::kanban_new', compact(
                'cirugias',
                'stats',
                'alertas',
                'errors',
                'surgeries',
                'totalSurgeriesCurrentMonth',
                'totalSurgeriesLastMonth'
            ));
        } catch (Throwable $e) {
            Log::error('Error en KanbanController@index: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las cirugías: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateEstado(Request $request, Cirugia $cirugia)
    {
        $validated = $request->validate([
            'estado' => 'required|in:pendiente,programada,en proceso,finalizada'
        ]);

        try {
            $estadoAnterior = $cirugia->estado;
            $cirugia->estado = $validated['estado'];

            // Actualizar el estado del equipo según corresponda
            if ($validated['estado'] === 'en proceso') {
                if ($cirugia->equipo) {
                    $cirugia->equipo->update(['estado' => 'en uso']);
                }
            } elseif ($estadoAnterior === 'en proceso' && $validated['estado'] !== 'en proceso') {
                if ($cirugia->equipo) {
                    $cirugia->equipo->update(['estado' => 'disponible']);
                }
            }

            $cirugia->save();

            return response()->json([
                'success' => true,
                'message' => 'Estado actualizado exitosamente'
            ]);
        } catch (Throwable $e) {
            Log::error('Error en KanbanController@updateEstado: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el estado: ' . $e->getMessage()
            ], 500);
        }
    }
}
