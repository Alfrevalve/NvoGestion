<?php

namespace Modules\Despacho\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Modules\Despacho\Entities\Entrega;
use Modules\Despacho\Http\Requests\EntregaRequest;
use Modules\Despacho\Http\Resources\EntregaResource;
use Modules\Despacho\Http\Resources\EntregaCollection;
use Carbon\Carbon;
use Exception;

class EntregaController extends Controller
{
    /**
     * Muestra una lista paginada de entregas con opciones de filtrado.
     *
     * Este método proporciona una API flexible para consultar entregas
     * con capacidades de búsqueda, filtrado por estado, fecha, y más.
     *
     * @param Request $request Contiene parámetros de consulta para filtrado
     * @return EntregaCollection Una colección paginada de recursos de entrega
     */
    public function index(Request $request)
    {
        try {
            // Comenzamos con una consulta base que podemos ir modificando
            $query = Entrega::query();

            // Aplicamos filtros de búsqueda si existen en la solicitud
            if ($request->has('buscar')) {
                $busqueda = '%' . $request->buscar . '%';
                $query->where(function($q) use ($busqueda) {
                    $q->where('codigo_seguimiento', 'like', $busqueda)
                      ->orWhereHas('cliente', function($clienteQuery) use ($busqueda) {
                          $clienteQuery->where('nombre', 'like', $busqueda)
                                      ->orWhere('email', 'like', $busqueda);
                      });
                });
            }

            // Filtrado por estado de entrega
            if ($request->has('estado')) {
                $query->where('estado', $request->estado);
            }

            // Filtrado por rango de fechas
            if ($request->has('fecha_desde')) {
                $query->where('fecha_programada', '>=', $request->fecha_desde);
            }

            if ($request->has('fecha_hasta')) {
                $query->where('fecha_programada', '<=', $request->fecha_hasta);
            }

            // Filtrado por zona
            if ($request->has('zona_id')) {
                $query->where('zona_id', $request->zona_id);
            }

            // Filtrado por conductor
            if ($request->has('conductor_id')) {
                $query->where('conductor_id', $request->conductor_id);
            }

            // Cargamos relaciones para evitar problemas N+1
            $query->with(['cliente', 'conductor', 'vehiculo', 'zona']);

            // Ordenamos los resultados (con parámetros personalizables)
            $query->orderBy(
                $request->input('ordenar_por', 'fecha_programada'),
                $request->input('direccion', 'desc')
            );

            // Paginamos los resultados
            $entregas = $query->paginate($request->input('por_pagina', 15));

            // Devolvemos la colección transformada con metadata de paginación
            return new EntregaCollection($entregas);
        } catch (Exception $e) {
            // Registramos el error para depuración posterior
            Log::error('Error al listar entregas: ' . $e->getMessage());

            // Devolvemos un mensaje de error amigable
            return response()->json([
                'error' => 'No se pudo obtener la lista de entregas',
                'message' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Almacena una nueva entrega en la base de datos.
     *
     * @param EntregaRequest $request Datos validados para la nueva entrega
     * @return JsonResponse
     */
    public function store(EntregaRequest $request)
    {
        try {
            // Iniciamos una transacción para asegurar integridad de datos
            DB::beginTransaction();

            // Generamos un código de seguimiento único si no se proporcionó
            $datos = $request->validated();
            if (!isset($datos['codigo_seguimiento'])) {
                $datos['codigo_seguimiento'] = $this->generarCodigoSeguimiento();
            }

            // Creamos la entrega con los datos validados
            $entrega = Entrega::create($datos);

            // Si hay items para la entrega, los procesamos
            if ($request->has('items')) {
                foreach ($request->items as $item) {
                    $entrega->items()->create($item);
                }
            }

            // Si corresponde, asignamos automáticamente un conductor según disponibilidad y zona
            if ($request->input('asignar_conductor', false)) {
                $this->asignarConductor($entrega);
            }

            // Confirmamos la transacción
            DB::commit();

            // Notificamos a los interesados sobre la nueva entrega
            // event(new EntregaCreada($entrega));

            // Devolvemos la entrega creada con código 201 (Created)
            return (new EntregaResource($entrega))
                ->response()
                ->setStatusCode(201);
        } catch (Exception $e) {
            // Si algo falla, revertimos la transacción
            DB::rollBack();

            Log::error('Error al crear entrega: ' . $e->getMessage());

            return response()->json([
                'error' => 'No se pudo crear la entrega',
                'message' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Muestra información detallada de una entrega específica.
     *
     * @param Entrega $entrega Inyectado automáticamente por Laravel Route Model Binding
     * @return EntregaResource
     */
    public function show(Entrega $entrega)
    {
        // Cargamos todas las relaciones necesarias para mostrar los detalles completos
        $entrega->load(['cliente', 'conductor', 'vehiculo', 'zona', 'items', 'historial']);

        // Verificamos si hay acceso a la API de rastreo en tiempo real
        if ($entrega->conductor && $entrega->estado === 'en_progreso') {
            try {
                // Simulado: en un sistema real, esto consultaría la ubicación actual
                $entrega->setAttribute('ubicacion_actual', [
                    'latitud' => -34.603722,
                    'longitud' => -58.381592,
                    'ultima_actualizacion' => now()->format('Y-m-d H:i:s')
                ]);
            } catch (Exception $e) {
                Log::warning('No se pudo obtener ubicación en tiempo real: ' . $e->getMessage());
            }
        }

        // Transformamos y devolvemos la entrega
        return new EntregaResource($entrega);
    }

    /**
     * Actualiza una entrega existente.
     *
     * @param EntregaRequest $request Datos validados para la actualización
     * @param Entrega $entrega La entrega a actualizar
     * @return EntregaResource
     */
    public function update(EntregaRequest $request, Entrega $entrega)
    {
        try {
            DB::beginTransaction();

            // Verificamos si se está cambiando el estado de la entrega
            $cambioEstado = isset($request->estado) && $request->estado !== $entrega->estado;
            $estadoAnterior = $entrega->estado;

            // Actualizamos la entrega con los datos validados
            $entrega->update($request->validated());

            // Si hay cambio de estado, registramos en el historial
            if ($cambioEstado) {
                $entrega->historial()->create([
                    'estado_anterior' => $estadoAnterior,
                    'estado_nuevo' => $entrega->estado,
                    'comentario' => $request->input('comentario_estado', 'Cambio de estado'),
                    'usuario_id' => auth()->id()
                ]);

                // Si el estado cambió a "entregado", registramos fecha de entrega
                if ($entrega->estado === 'entregado' && !$entrega->fecha_entrega) {
                    $entrega->fecha_entrega = now();
                    $entrega->save();
                }
            }

            DB::commit();

            // Devolvemos la entrega actualizada
            return new EntregaResource($entrega->fresh());
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Error al actualizar entrega: ' . $e->getMessage());

            return response()->json([
                'error' => 'No se pudo actualizar la entrega',
                'message' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Elimina una entrega de la base de datos.
     *
     * @param Entrega $entrega La entrega a eliminar
     * @return JsonResponse
     */
    public function destroy(Entrega $entrega)
    {
        try {
            // Verificamos si la entrega está en un estado que permite eliminación
            if (in_array($entrega->estado, ['entregado', 'en_progreso'])) {
                return response()->json([
                    'error' => 'No se puede eliminar una entrega que ya está en progreso o completada'
                ], 409); // Conflict
            }

            // Si hay conductor asignado, lo liberamos
            if ($entrega->conductor_id) {
                // Aquí podríamos tener lógica para liberar al conductor
            }

            // Eliminamos la entrega
            $entrega->delete();

            // 204 indica éxito sin contenido para devolver
            return response()->json(null, 204);
        } catch (Exception $e) {
            Log::error('Error al eliminar entrega: ' . $e->getMessage());

            return response()->json([
                'error' => 'No se pudo eliminar la entrega',
                'message' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Marca una entrega como completada/entregada.
     *
     * @param Request $request
     * @param Entrega $entrega
     * @return JsonResponse
     */
    public function marcarEntregada(Request $request, Entrega $entrega)
    {
        // Validamos datos específicos para este endpoint
        $request->validate([
            'firma_cliente' => 'sometimes|string',
            'foto_entrega' => 'sometimes|string', // En un caso real sería un archivo
            'comentario' => 'nullable|string|max:500',
        ]);

        try {
            DB::beginTransaction();

            // Guardamos el estado anterior
            $estadoAnterior = $entrega->estado;

            // Actualizamos la entrega
            $entrega->update([
                'estado' => 'entregado',
                'fecha_entrega' => now(),
                'firma_cliente' => $request->input('firma_cliente'),
                'foto_entrega' => $request->input('foto_entrega'),
                'comentario_entrega' => $request->input('comentario'),
            ]);

            // Registramos en el historial
            $entrega->historial()->create([
                'estado_anterior' => $estadoAnterior,
                'estado_nuevo' => 'entregado',
                'comentario' => $request->input('comentario', 'Entrega completada'),
                'usuario_id' => auth()->id()
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Entrega completada exitosamente',
                'entrega' => new EntregaResource($entrega->fresh())
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Error al marcar entrega como completada: ' . $e->getMessage());

            return response()->json([
                'error' => 'No se pudo completar la entrega',
                'message' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Genera un informe de rendimiento de las entregas.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function informe(Request $request)
    {
        // Validamos las fechas de entrada
        $request->validate([
            'fecha_desde' => 'required|date',
            'fecha_hasta' => 'required|date|after_or_equal:fecha_desde',
        ]);

        try {
            // Definimos el período del informe
            $fechaDesde = Carbon::parse($request->fecha_desde);
            $fechaHasta = Carbon::parse($request->fecha_hasta);

            // Estadísticas generales
            $estadisticas = [
                'total_entregas' => Entrega::whereBetween('fecha_programada', [$fechaDesde, $fechaHasta])->count(),
                'entregas_completadas' => Entrega::where('estado', 'entregado')->whereBetween('fecha_programada', [$fechaDesde, $fechaHasta])->count(),
                'entregas_fallidas' => Entrega::where('estado', 'fallido')->whereBetween('fecha_programada', [$fechaDesde, $fechaHasta])->count(),
                'entregas_pendientes' => Entrega::whereIn('estado', ['pendiente', 'programado'])->whereBetween('fecha_programada', [$fechaDesde, $fechaHasta])->count(),
                'tiempo_promedio_entrega' => DB::table('entregas')
                    ->whereBetween('fecha_programada', [$fechaDesde, $fechaHasta])
                    ->whereNotNull('fecha_entrega')
                    ->select(DB::raw('AVG(TIMESTAMPDIFF(MINUTE, fecha_programada, fecha_entrega)) as promedio'))
                    ->first()->promedio ?? 0,
            ];

            // Entregas por día
            $entregasPorDia = DB::table('entregas')
                ->whereBetween('fecha_programada', [$fechaDesde, $fechaHasta])
                ->select(DB::raw('DATE(fecha_programada) as fecha, COUNT(*) as total,
                                 SUM(CASE WHEN estado = "entregado" THEN 1 ELSE 0 END) as completadas'))
                ->groupBy('fecha')
                ->get();

            // Rendimiento por conductor
            $rendimientoPorConductor = DB::table('entregas')
                ->join('conductores', 'entregas.conductor_id', '=', 'conductores.id')
                ->whereBetween('entregas.fecha_programada', [$fechaDesde, $fechaHasta])
                ->select(
                    'conductores.id',
                    'conductores.nombre',
                    DB::raw('COUNT(*) as total_asignadas'),
                    DB::raw('SUM(CASE WHEN entregas.estado = "entregado" THEN 1 ELSE 0 END) as completadas'),
                    DB::raw('AVG(CASE WHEN entregas.estado = "entregado" AND entregas.fecha_entrega IS NOT NULL
                              THEN TIMESTAMPDIFF(MINUTE, entregas.fecha_programada, entregas.fecha_entrega)
                              ELSE NULL END) as tiempo_promedio')
                )
                ->groupBy('conductores.id', 'conductores.nombre')
                ->get();

            return response()->json([
                'periodo' => [
                    'desde' => $fechaDesde->format('Y-m-d'),
                    'hasta' => $fechaHasta->format('Y-m-d'),
                ],
                'estadisticas' => $estadisticas,
                'entregas_por_dia' => $entregasPorDia,
                'rendimiento_por_conductor' => $rendimientoPorConductor
            ]);
        } catch (Exception $e) {
            Log::error('Error al generar informe de entregas: ' . $e->getMessage());

            return response()->json([
                'error' => 'No se pudo generar el informe',
                'message' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Genera un código de seguimiento único.
     *
     * @return string
     */
    protected function generarCodigoSeguimiento()
    {
        $prefijo = 'ENT-';
        $timestamp = now()->format('Ymd');
        $aleatorio = strtoupper(substr(md5(uniqid()), 0, 6));

        return $prefijo . $timestamp . '-' . $aleatorio;
    }

    /**
     * Asigna automáticamente un conductor a una entrega.
     *
     * @param Entrega $entrega
     * @return bool
     */
    protected function asignarConductor(Entrega $entrega)
    {
        // Ejemplo de lógica para asignar conductor
        // En un sistema real, esto podría usar algoritmos de optimización de rutas

        // Buscamos conductores disponibles para la zona de la entrega
        $conductorDisponible = DB::table('conductores')
            ->where('estado', 'disponible')
            ->where('zona_id', $entrega->zona_id)
            ->orderBy('carga_trabajo', 'asc') // Asignar al menos ocupado
            ->first();

        if ($conductorDisponible) {
            $entrega->update([
                'conductor_id' => $conductorDisponible->id,
                'estado' => 'asignado'
            ]);

            // Actualizamos la carga de trabajo del conductor
            DB::table('conductores')
                ->where('id', $conductorDisponible->id)
                ->increment('carga_trabajo');

            return true;
        }

        return false;
    }
}
