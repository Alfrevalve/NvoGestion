<?php

namespace Modules\Despacho\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Modules\Despacho\Entities\Despacho;
use Modules\Despacho\Entities\Entrega;
use Modules\Despacho\Entities\Conductor;
use Modules\Despacho\Entities\Vehiculo;
use Modules\Despacho\Entities\Zona;
use Modules\Despacho\Http\Requests\DespachoRequest;
use Modules\Despacho\Http\Resources\DespachoResource;
use Modules\Despacho\Http\Resources\DespachoCollection;
use Carbon\Carbon;
use Exception;

class DespachoController extends Controller
{
    /**
     * Muestra una lista paginada de todos los despachos con opciones de filtrado.
     *
     * Este método construye dinámicamente la consulta de despachos basada en
     * los filtros proporcionados por el usuario, permitiendo búsquedas flexibles
     * y visualización paginada de resultados.
     *
     * @param Request $request Contiene parámetros de filtrado y paginación
     * @return DespachoCollection
     */
    public function index(Request $request)
    {
        try {
            // Iniciamos con una consulta básica que iremos refinando según los filtros
            $query = Despacho::query();

            // Implementamos búsqueda por código o descripción
            if ($request->has('buscar')) {
                $busqueda = '%' . $request->buscar . '%';
                $query->where(function($q) use ($busqueda) {
                    $q->where('codigo', 'like', $busqueda)
                      ->orWhere('descripcion', 'like', $busqueda);
                });
            }

            // Filtrado por estado del despacho (pendiente, en_progreso, completado, cancelado)
            if ($request->has('estado')) {
                $query->where('estado', $request->estado);
            }

            // Filtrado por fecha de despacho (rango de fechas)
            if ($request->has('fecha_desde')) {
                $query->where('fecha_despacho', '>=', $request->fecha_desde);
            }

            if ($request->has('fecha_hasta')) {
                $query->where('fecha_despacho', '<=', $request->fecha_hasta);
            }

            // Filtrado por zona
            if ($request->has('zona_id')) {
                $query->where('zona_id', $request->zona_id);
            }

            // Filtrado por conductor
            if ($request->has('conductor_id')) {
                $query->where('conductor_id', $request->conductor_id);
            }

            // Filtrado por vehículo
            if ($request->has('vehiculo_id')) {
                $query->where('vehiculo_id', $request->vehiculo_id);
            }

            // Cargamos relaciones importantes para evitar el problema N+1
            // Esto mejora significativamente el rendimiento al evitar múltiples consultas a la BD
            $query->with(['conductor', 'vehiculo', 'zona', 'entregas']);

            // Ordenamos los resultados (con parámetros que pueden ser personalizados)
            $query->orderBy(
                $request->input('ordenar_por', 'fecha_despacho'),
                $request->input('direccion', 'desc')
            );

            // Paginamos los resultados para manejar grandes volúmenes de datos eficientemente
            $despachos = $query->paginate($request->input('por_pagina', 15));

            // Transformamos y devolvemos la colección con metadata de paginación
            return new DespachoCollection($despachos);
        } catch (Exception $e) {
            // Registramos el error para diagnóstico posterior
            Log::error('Error al listar despachos: ' . $e->getMessage());

            // Proporcionamos un mensaje de error amigable para el usuario
            return response()->json([
                'error' => 'No se pudo obtener la lista de despachos',
                'message' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Almacena un nuevo despacho en la base de datos.
     *
     * Este método maneja la creación de un nuevo despacho, incluyendo la asignación
     * de entregas, conductor y vehículo. Utiliza transacciones para garantizar
     * la integridad de los datos.
     *
     * @param DespachoRequest $request Datos validados para el nuevo despacho
     * @return JsonResponse
     */
    public function store(DespachoRequest $request)
    {
        try {
            // Iniciamos una transacción para garantizar integridad de datos
            // Esto asegura que o todas las operaciones se completan o ninguna
            DB::beginTransaction();

            // Generamos un código único si no se proporcionó
            $datos = $request->validated();
            if (!isset($datos['codigo'])) {
                $datos['codigo'] = $this->generarCodigoDespacho();
            }

            // Si la fecha de despacho no se especificó, usamos la fecha actual
            if (!isset($datos['fecha_despacho'])) {
                $datos['fecha_despacho'] = now();
            }

            // Creamos el despacho con los datos validados
            $despacho = Despacho::create($datos);

            // Si se proporcionaron IDs de entregas, las asociamos al despacho
            if ($request->has('entrega_ids')) {
                // Actualizamos el estado de las entregas seleccionadas
                Entrega::whereIn('id', $request->entrega_ids)
                    ->update([
                        'despacho_id' => $despacho->id,
                        'estado' => 'asignado'
                    ]);

                // Actualizamos el contador de entregas en el despacho
                $despacho->total_entregas = count($request->entrega_ids);
                $despacho->save();
            }

            // Si se solicitó optimización de ruta, calculamos el orden óptimo de entregas
            if ($request->input('optimizar_ruta', false)) {
                $this->optimizarRutaDespacho($despacho);
            }

            // Confirmamos la transacción si todo salió bien
            DB::commit();

            // Podríamos enviar notificaciones aquí
            // event(new DespachoCreado($despacho));

            // Devolvemos el recurso creado con código 201 (Created)
            return (new DespachoResource($despacho))
                ->response()
                ->setStatusCode(201);
        } catch (Exception $e) {
            // Si algo falla, revertimos la transacción para mantener la integridad
            DB::rollBack();

            Log::error('Error al crear despacho: ' . $e->getMessage());

            return response()->json([
                'error' => 'No se pudo crear el despacho',
                'message' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Muestra información detallada de un despacho específico.
     *
     * Este método carga todas las relaciones relevantes para mostrar
     * una vista completa del despacho, incluyendo entregas, conductor,
     * vehículo y estadísticas.
     *
     * @param Despacho $despacho Inyectado automáticamente por Laravel Route Model Binding
     * @return DespachoResource
     */
    public function show(Despacho $despacho)
    {
        // Cargamos todas las relaciones necesarias para mostrar los detalles completos
        // Eager loading evita el problema N+1 de consultas a la base de datos
        $despacho->load([
            'conductor',
            'vehiculo',
            'zona',
            'entregas' => function($query) {
                $query->orderBy('orden_entrega'); // Ordenamos por el orden de entrega
            }
        ]);

        // Calculamos métricas adicionales que pueden ser útiles para la visualización
        $despacho->setAttribute('estadisticas', [
            'entregas_completadas' => $despacho->entregas->where('estado', 'entregado')->count(),
            'entregas_pendientes' => $despacho->entregas->whereIn('estado', ['asignado', 'en_progreso'])->count(),
            'entregas_fallidas' => $despacho->entregas->where('estado', 'fallido')->count(),
            'progreso_porcentaje' => $despacho->total_entregas > 0
                ? round(($despacho->entregas->where('estado', 'entregado')->count() / $despacho->total_entregas) * 100, 2)
                : 0,
        ]);

        // Si el despacho está en progreso, podríamos cargar datos de ubicación actual
        if ($despacho->estado === 'en_progreso' && $despacho->conductor) {
            try {
                // En un sistema real, esto consultaría la ubicación actual del conductor
                // desde algún servicio de geolocalización
                $despacho->setAttribute('ubicacion_actual', [
                    'latitud' => -34.603722, // Valores de ejemplo
                    'longitud' => -58.381592,
                    'ultima_actualizacion' => now()->format('Y-m-d H:i:s')
                ]);
            } catch (Exception $e) {
                Log::warning('No se pudo obtener ubicación en tiempo real: ' . $e->getMessage());
            }
        }

        // Transformamos y devolvemos el recurso
        return new DespachoResource($despacho);
    }

    /**
     * Actualiza un despacho existente.
     *
     * Este método maneja la actualización de un despacho, incluyendo
     * cambios de estado, reasignaciones y modificaciones de entregas.
     *
     * @param DespachoRequest $request Datos validados para la actualización
     * @param Despacho $despacho El despacho a actualizar
     * @return DespachoResource
     */
    public function update(DespachoRequest $request, Despacho $despacho)
    {
        try {
            DB::beginTransaction();

            // Verificamos si se está cambiando el estado del despacho
            $cambioEstado = isset($request->estado) && $request->estado !== $despacho->estado;
            $estadoAnterior = $despacho->estado;

            // Actualizamos el despacho con los datos validados
            $despacho->update($request->validated());

            // Si hay cambio de estado, podemos realizar acciones adicionales
            if ($cambioEstado) {
                // Registramos el cambio de estado en el historial
                $despacho->historial()->create([
                    'estado_anterior' => $estadoAnterior,
                    'estado_nuevo' => $despacho->estado,
                    'comentario' => $request->input('comentario_estado', 'Cambio de estado'),
                    'usuario_id' => auth()->id()
                ]);

                // Si el despacho se marca como "en_progreso", actualizamos la hora de inicio
                if ($despacho->estado === 'en_progreso' && !$despacho->hora_inicio) {
                    $despacho->hora_inicio = now();
                    $despacho->save();

                    // También actualizamos el estado de las entregas
                    $despacho->entregas()->update(['estado' => 'en_progreso']);
                }

                // Si el despacho se marca como "completado", actualizamos la hora de finalización
                if ($despacho->estado === 'completado' && !$despacho->hora_fin) {
                    $despacho->hora_fin = now();
                    $despacho->save();

                    // Actualizamos disponibilidad del conductor y vehículo
                    if ($despacho->conductor) {
                        $despacho->conductor->update(['estado' => 'disponible']);
                    }

                    if ($despacho->vehiculo) {
                        $despacho->vehiculo->update(['estado' => 'disponible']);
                    }
                }
            }

            // Si se modificaron las entregas asignadas
            if ($request->has('entrega_ids')) {
                // Primero, liberamos las entregas que ya no están en el despacho
                Entrega::where('despacho_id', $despacho->id)
                    ->whereNotIn('id', $request->entrega_ids)
                    ->update([
                        'despacho_id' => null,
                        'estado' => 'pendiente',
                        'orden_entrega' => null
                    ]);

                // Luego, asignamos las nuevas entregas
                Entrega::whereIn('id', $request->entrega_ids)
                    ->whereNull('despacho_id')
                    ->update([
                        'despacho_id' => $despacho->id,
                        'estado' => $despacho->estado === 'en_progreso' ? 'en_progreso' : 'asignado'
                    ]);

                // Actualizamos el contador de entregas
                $despacho->total_entregas = Entrega::where('despacho_id', $despacho->id)->count();
                $despacho->save();

                // Reoptimizamos la ruta si se solicita
                if ($request->input('optimizar_ruta', false)) {
                    $this->optimizarRutaDespacho($despacho);
                }
            }

            // Si se cambia el conductor
            if ($request->has('conductor_id') && $request->conductor_id != $despacho->conductor_id) {
                // Liberamos al conductor anterior si existe
                if ($despacho->conductor) {
                    $despacho->conductor->update(['estado' => 'disponible']);
                }

                // Actualizamos el estado del nuevo conductor
                Conductor::find($request->conductor_id)
                    ->update(['estado' => 'en_despacho']);
            }

            DB::commit();

            // Devolvemos el recurso actualizado
            return new DespachoResource($despacho->fresh());
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Error al actualizar despacho: ' . $e->getMessage());

            return response()->json([
                'error' => 'No se pudo actualizar el despacho',
                'message' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Elimina un despacho de la base de datos.
     *
     * Este método verifica que el despacho pueda ser eliminado y
     * libera todos los recursos asociados (entregas, conductor, vehículo).
     *
     * @param Despacho $despacho El despacho a eliminar
     * @return JsonResponse
     */
    public function destroy(Despacho $despacho)
    {
        try {
            // Verificamos si el despacho está en un estado que permite eliminación
            if (in_array($despacho->estado, ['en_progreso', 'completado'])) {
                return response()->json([
                    'error' => 'No se puede eliminar un despacho que ya está en progreso o completado'
                ], 409); // Conflict
            }

            DB::beginTransaction();

            // Liberamos todas las entregas asignadas a este despacho
            Entrega::where('despacho_id', $despacho->id)
                ->update([
                    'despacho_id' => null,
                    'estado' => 'pendiente',
                    'orden_entrega' => null
                ]);

            // Liberamos al conductor si existe
            if ($despacho->conductor) {
                $despacho->conductor->update(['estado' => 'disponible']);
            }

            // Liberamos al vehículo si existe
            if ($despacho->vehiculo) {
                $despacho->vehiculo->update(['estado' => 'disponible']);
            }

            // Eliminamos el despacho
            $despacho->delete();

            DB::commit();

            // 204 indica éxito sin contenido para devolver
            return response()->json(null, 204);
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Error al eliminar despacho: ' . $e->getMessage());

            return response()->json([
                'error' => 'No se pudo eliminar el despacho',
                'message' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Inicia un despacho, cambiando su estado a "en_progreso".
     *
     * Este endpoint especializado representa la acción específica de iniciar
     * un despacho, que en el dominio del negocio es una operación diferente
     * de una simple actualización de estado.
     *
     * @param Request $request
     * @param Despacho $despacho
     * @return JsonResponse
     */
    public function iniciar(Request $request, Despacho $despacho)
    {
        try {
            // Validamos que el despacho esté en un estado que permita iniciarlo
            if ($despacho->estado !== 'pendiente') {
                return response()->json([
                    'error' => 'Solo se pueden iniciar despachos pendientes'
                ], 400);
            }

            // Validamos que tenga conductor y vehículo asignados
            if (!$despacho->conductor_id || !$despacho->vehiculo_id) {
                return response()->json([
                    'error' => 'El despacho debe tener conductor y vehículo asignados para iniciarse'
                ], 400);
            }

            // Validamos que tenga entregas asignadas
            if ($despacho->entregas->isEmpty()) {
                return response()->json([
                    'error' => 'El despacho debe tener al menos una entrega asignada'
                ], 400);
            }

            DB::beginTransaction();

            // Actualizamos el despacho
            $despacho->update([
                'estado' => 'en_progreso',
                'hora_inicio' => now(),
                'comentario' => $request->input('comentario', 'Despacho iniciado')
            ]);

            // Registramos en el historial
            $despacho->historial()->create([
                'estado_anterior' => 'pendiente',
                'estado_nuevo' => 'en_progreso',
                'comentario' => $request->input('comentario', 'Despacho iniciado'),
                'usuario_id' => auth()->id()
            ]);

            // Actualizamos el estado de las entregas
            $despacho->entregas()->update(['estado' => 'en_progreso']);

            // Actualizamos estados del conductor y vehículo
            if ($despacho->conductor) {
                $despacho->conductor->update(['estado' => 'en_despacho']);
            }

            if ($despacho->vehiculo) {
                $despacho->vehiculo->update(['estado' => 'en_uso']);
            }

            DB::commit();

            return response()->json([
                'message' => 'Despacho iniciado correctamente',
                'despacho' => new DespachoResource($despacho->fresh())
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Error al iniciar despacho: ' . $e->getMessage());

            return response()->json([
                'error' => 'No se pudo iniciar el despacho',
                'message' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Finaliza un despacho, marcándolo como "completado".
     *
     * Este método maneja la lógica específica de finalizar un despacho,
     * incluyendo la actualización de estados y la liberación de recursos.
     *
     * @param Request $request
     * @param Despacho $despacho
     * @return JsonResponse
     */
    public function finalizar(Request $request, Despacho $despacho)
    {
        $request->validate([
            'comentario' => 'nullable|string|max:500',
            'kilometraje_final' => 'sometimes|numeric|min:0',
        ]);

        try {
            // Validamos que el despacho esté en progreso
            if ($despacho->estado !== 'en_progreso') {
                return response()->json([
                    'error' => 'Solo se pueden finalizar despachos en progreso'
                ], 400);
            }

            DB::beginTransaction();

            // Actualizamos el despacho
            $despacho->update([
                'estado' => 'completado',
                'hora_fin' => now(),
                'kilometraje_final' => $request->input('kilometraje_final'),
                'comentario' => $request->input('comentario', 'Despacho finalizado')
            ]);

            // Registramos en el historial
            $despacho->historial()->create([
                'estado_anterior' => 'en_progreso',
                'estado_nuevo' => 'completado',
                'comentario' => $request->input('comentario', 'Despacho finalizado'),
                'usuario_id' => auth()->id()
            ]);

            // Actualizamos las entregas pendientes como fallidas
            $despacho->entregas()
                ->whereIn('estado', ['asignado', 'en_progreso'])
                ->update([
                    'estado' => 'fallido',
                    'comentario' => 'Entrega no realizada al finalizar despacho'
                ]);

            // Liberamos al conductor y al vehículo
            if ($despacho->conductor) {
                $despacho->conductor->update(['estado' => 'disponible']);
            }

            if ($despacho->vehiculo) {
                $despacho->vehiculo->update(['estado' => 'disponible']);
            }

            // Calculamos estadísticas de rendimiento
            $tiempoTotal = $despacho->hora_inicio->diffInMinutes($despacho->hora_fin);
            $entregas = $despacho->entregas;
            $entregasCompletadas = $entregas->where('estado', 'entregado')->count();
            $entregasFallidas = $entregas->where('estado', 'fallido')->count();

            $estadisticas = [
                'tiempo_total_minutos' => $tiempoTotal,
                'entregas_completadas' => $entregasCompletadas,
                'entregas_fallidas' => $entregasFallidas,
                'tasa_exito' => $entregas->count() > 0
                    ? round(($entregasCompletadas / $entregas->count()) * 100, 2)
                    : 0,
                'tiempo_promedio_por_entrega' => $entregasCompletadas > 0
                    ? round($tiempoTotal / $entregasCompletadas, 2)
                    : 0
            ];

            // Guardamos las estadísticas para informes posteriores
            $despacho->estadisticas_rendimiento = json_encode($estadisticas);
            $despacho->save();

            DB::commit();

            return response()->json([
                'message' => 'Despacho finalizado correctamente',
                'despacho' => new DespachoResource($despacho->fresh()),
                'estadisticas' => $estadisticas
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Error al finalizar despacho: ' . $e->getMessage());

            return response()->json([
                'error' => 'No se pudo finalizar el despacho',
                'message' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Genera un informe de rendimiento de los despachos.
     *
     * Este método proporciona estadísticas detalladas sobre los despachos
     * en un período de tiempo específico, útil para análisis operativo.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function informe(Request $request)
    {
        // Validamos los parámetros de entrada
        $request->validate([
            'fecha_desde' => 'required|date',
            'fecha_hasta' => 'required|date|after_or_equal:fecha_desde',
            'zona_id' => 'nullable|exists:zonas,id',
            'conductor_id' => 'nullable|exists:conductores,id',
        ]);

        try {
            // Definimos el período del informe
            $fechaDesde = Carbon::parse($request->fecha_desde);
            $fechaHasta = Carbon::parse($request->fecha_hasta);

            // Construimos la consulta base
            $query = Despacho::whereBetween('fecha_despacho', [$fechaDesde, $fechaHasta]);

            // Aplicamos filtros adicionales si existen
            if ($request->has('zona_id')) {
                $query->where('zona_id', $request->zona_id);
            }

            if ($request->has('conductor_id')) {
                $query->where('conductor_id', $request->conductor_id);
            }

            // Estadísticas generales
            $totalDespachos = $query->count();
            $despachosCompletados = (clone $query)->where('estado', 'completado')->count();
            $despachosEnProgreso = (clone $query)->where('estado', 'en_progreso')->count();
            $despachosCancelados = (clone $query)->where('estado', 'cancelado')->count();

            // Tiempo promedio de despacho
            $tiempoPromedio = DB::table('despachos')
                ->whereBetween('fecha_despacho', [$fechaDesde, $fechaHasta])
                ->whereNotNull('hora_inicio')
                ->whereNotNull('hora_fin')
                ->select(DB::raw('AVG(TIMESTAMPDIFF(MINUTE, hora_inicio, hora_fin)) as promedio'))
                ->first()->promedio ?? 0;

            // Estadísticas de entregas
            $entregasConsulta = DB::table('entregas')
                ->join('despachos', 'entregas.despacho_id', '=', 'despachos.id')
                ->whereBetween('despachos.fecha_despacho', [$fechaDesde, $fechaHasta]);

            if ($request->has('zona_id')) {
                $entregasConsulta->where('despachos.zona_id', $request->zona_id);
            }

            if ($request->has('conductor_id')) {
                $entregasConsulta->where('despachos.conductor_id', $request->conductor_id);
            }

            $totalEntregas = $entregasConsulta->count();
            $entregasCompletadas = (clone $entregasConsulta)->where('entregas.estado', 'entregado')->count();
            $entregasFallidas = (clone $entregasConsulta)->where('entregas.estado', 'fallido')->count();

            // Rendimiento por conductor
            $rendimientoPorConductor = DB::table('despachos')
                ->join('conductores', 'despachos.conductor_id', '=', 'conductores.id')
                ->whereBetween('despachos.fecha_despacho', [$fechaDesde, $fechaHasta])
                ->where('despachos.estado', 'completado')
                ->select(
                    'conductores.id',
                    'conductores.nombre',
                    DB::raw('COUNT(DISTINCT despachos.id) as total_despachos'),
                    DB::raw('SUM(despachos.total_entregas) as total_entregas_asignadas'),
                    DB::raw('AVG(TIMESTAMPDIFF(MINUTE, despachos.hora_inicio, despachos.hora_fin)) as tiempo_promedio_minutos')
                )
                ->groupBy('conductores.id', 'conductores.nombre')
                ->get();

            // Rendimiento por zona
            $rendimientoPorZona = DB::table('despachos')
                ->join('zonas', 'despachos.zona_id', '=', 'zonas.id')
                ->whereBetween('despachos.fecha_despacho', [$fechaDesde, $fechaHasta])
                ->where('despachos.estado', 'completado')
                ->select(
                    'zonas.id',
                    'zonas.nombre',
                    DB::raw('COUNT(DISTINCT despachos.id) as total_despachos'),
                    DB::raw('SUM(despachos.total_entregas) as total_entregas')
                )
                ->groupBy('zonas.id', 'zonas.nombre')
                ->get();

            // Despachos por día
            $despachosPorDia = DB::table('despachos')
                ->whereBetween('fecha_despacho', [$fechaDesde, $fechaHasta])
                ->select(
                    DB::raw('DATE(fecha_despacho) as fecha'),
                    DB::raw('COUNT(*) as total_despachos'),
                    DB::raw('SUM(total_entregas) as total_entregas')
                )
                ->groupBy('fecha')
                ->orderBy('fecha')
                ->get();

            // Componemos el informe completo
            $informe = [
                'periodo' => [
                    'desde' => $fechaDesde->format('Y-m-d'),
                    'hasta' => $fechaHasta->format('Y-m-d'),
                ],
                'estadisticas_generales' => [
                    'total_despachos' => $totalDespachos,
                    'despachos_completados' => $despachosCompletados,
                    'despachos_en_progreso' => $despachosEnProgreso,
                    'despachos_cancelados' => $despachosCancelados,
                    'tiempo_promedio_minutos' => round($tiempoPromedio, 2),
                    'tasa_completado' => $totalDespachos > 0
                        ? round(($despachosCompletados / $totalDespachos) * 100, 2)
                        : 0,
                ],
                'estadisticas_entregas' => [
                    'total_entregas' => $totalEntregas,
                    'entregas_completadas' => $entregasCompletadas,
                    'entregas_fallidas' => $entregasFallidas,
                    'tasa_exito' => $totalEntregas > 0
                        ? round(($entregasCompletadas / $totalEntregas) * 100, 2)
                        : 0,
                ],
                'rendimiento_por_conductor' => $rendimientoPorConductor,
                'rendimiento_por_zona' => $rendimientoPorZona,
                'despachos_por_dia' => $despachosPorDia,
            ];

            return response()->json($informe);
        } catch (Exception $e) {
            Log::error('Error al generar informe de despachos: ' . $e->getMessage());

            return response()->json([
                'error' => 'No se pudo generar el informe',
                'message' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Genera un código único para un nuevo despacho.
     *
     * Este método encapsula la lógica de generación de códigos,
     * facilitando su modificación o extensión en el futuro.
     *
     * @return string
     */
    protected function generarCodigoDespacho()
    {
        $prefijo = 'DSP-';
        $fecha = now()->format('Ymd');
        $aleatorio = strtoupper(substr(md5(uniqid()), 0, 6));

        return $prefijo . $fecha . '-' . $aleatorio;
    }

    /**
     * Optimiza la ruta de un despacho ordenando las entregas de manera eficiente.
     *
     * Este método implementa un algoritmo simple para ordenar las entregas
     * de forma que minimice la distancia total recorrida. En un sistema real,
     * se utilizaría un algoritmo más sofisticado como el del viajante.
     *
     * @param Despacho $despacho
     * @return bool
     */
    protected function optimizarRutaDespacho(Despacho $despacho)
    {
        // Cargamos las entregas del despacho
        $entregas = $despacho->entregas()->with('cliente')->get();

        if ($entregas->isEmpty()) {
            return false;
        }

        // En un sistema real, aquí implementaríamos un algoritmo de optimización
        // como el del Problema del Viajante (TSP) o utilizaríamos un servicio
        // externo de optimización de rutas como Google Maps Directions API.

        // Por simplicidad, implementamos un enfoque básico:
        // Empezamos desde la ubicación del almacén (origen)
        $puntoActual = [
            'latitud' => config('despacho.almacen_latitud', -34.603722),
            'longitud' => config('despacho.almacen_longitud', -58.381592)
        ];

        $rutaOptimizada = [];
        $entregasPendientes = $entregas->toArray();

        // Mientras queden entregas por asignar
        while (count($entregasPendientes) > 0) {
            // Encontramos la entrega más cercana al punto actual
            $indiceMinimo = 0;
            $distanciaMinima = PHP_FLOAT_MAX;

            foreach ($entregasPendientes as $indice => $entrega) {
                // Calculamos la distancia (en un sistema real usaríamos fórmulas
                // geoespaciales como la distancia de Haversine)
                $latitudEntrega = $entrega['cliente']['latitud'] ?? 0;
                $longitudEntrega = $entrega['cliente']['longitud'] ?? 0;

                $distancia = sqrt(
                    pow($puntoActual['latitud'] - $latitudEntrega, 2) +
                    pow($puntoActual['longitud'] - $longitudEntrega, 2)
                );

                if ($distancia < $distanciaMinima) {
                    $distanciaMinima = $distancia;
                    $indiceMinimo = $indice;
                }
            }

            // Añadimos la entrega más cercana a la ruta
            $entregaSeleccionada = $entregasPendientes[$indiceMinimo];
            $rutaOptimizada[] = $entregaSeleccionada;

            // Actualizamos el punto actual
            $puntoActual = [
                'latitud' => $entregaSeleccionada['cliente']['latitud'] ?? 0,
                'longitud' => $entregaSeleccionada['cliente']['longitud'] ?? 0
            ];

            // Eliminamos la entrega seleccionada de las pendientes
            unset($entregasPendientes[$indiceMinimo]);
            $entregasPendientes = array_values($entregasPendientes); // Reindexamos
        }

        // Actualizamos el orden de las entregas en la base de datos
        foreach ($rutaOptimizada as $indice => $entrega) {
            Entrega::where('id', $entrega['id'])
                ->update(['orden_entrega' => $indice + 1]);
        }

        return true;
    }
}
