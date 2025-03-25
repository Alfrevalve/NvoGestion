<?php

namespace Modules\Despacho\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Modules\Despacho\Entities\Zona;
use Modules\Despacho\Http\Requests\ZonaRequest;
use Modules\Despacho\Http\Resources\ZonaResource;
use Modules\Despacho\Http\Resources\ZonaCollection;
use Exception;

class ZonaController extends Controller
{
    /**
     * Muestra una lista paginada de todas las zonas.
     *
     * Este método implementa filtrado, búsqueda y paginación para proporcionar
     * una experiencia de API flexible y eficiente.
     *
     * @param Request $request Contiene parámetros de consulta para filtrado
     * @return ZonaCollection Una colección paginada de recursos de zona
     */
    public function index(Request $request)
    {
        try {
            // Iniciamos con una consulta base que podemos ir modificando
            $query = Zona::query();

            // Implementamos búsqueda por nombre o código si se especifica
            if ($request->has('buscar')) {
                $busqueda = '%' . $request->buscar . '%';
                $query->where(function($q) use ($busqueda) {
                    $q->where('nombre', 'like', $busqueda)
                      ->orWhere('codigo', 'like', $busqueda)
                      ->orWhere('descripcion', 'like', $busqueda);
                });
            }

            // Permitimos filtrar por estado (activo/inactivo)
            if ($request->has('estado')) {
                $query->where('estado', $request->estado);
            }

            // Permitimos filtrar por ciudad o región si existe
            if ($request->has('ciudad_id')) {
                $query->where('ciudad_id', $request->ciudad_id);
            }

            // Cargamos las relaciones que necesitamos para evitar consultas N+1
            $query->with(['ciudad', 'despachos']);

            // Ordenamos los resultados
            $query->orderBy($request->input('ordenar_por', 'nombre'),
                          $request->input('direccion', 'asc'));

            // Paginamos los resultados - esto permite trabajar con grandes volúmenes de datos
            $zonas = $query->paginate($request->input('por_pagina', 15));

            // Devolvemos la colección transformada
            return new ZonaCollection($zonas);
        } catch (Exception $e) {
            // Registramos el error para diagnóstico
            Log::error('Error al listar zonas: ' . $e->getMessage());

            // Proporcionamos un mensaje de error amigable
            return response()->json([
                'error' => 'No se pudo obtener la lista de zonas',
                'message' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Almacena una nueva zona en la base de datos.
     *
     * @param ZonaRequest $request Datos validados para la nueva zona
     * @return JsonResponse
     */
    public function store(ZonaRequest $request)
    {
        try {
            // Iniciamos una transacción para asegurar integridad de datos
            DB::beginTransaction();

            // Creamos la zona con los datos validados
            $zona = Zona::create($request->validated());

            // Si se proporcionan coordenadas del polígono, las procesamos
            if ($request->has('coordenadas')) {
                $zona->actualizarCoordenadas($request->coordenadas);
            }

            // Confirmamos la transacción
            DB::commit();

            // Limpiamos cualquier caché relacionada con zonas
            Cache::tags(['zonas'])->flush();

            // Devolvemos la zona creada con código de estado 201 (Created)
            return (new ZonaResource($zona))
                ->response()
                ->setStatusCode(201);
        } catch (Exception $e) {
            // Si algo falla, revertimos la transacción
            DB::rollBack();

            Log::error('Error al crear zona: ' . $e->getMessage());

            return response()->json([
                'error' => 'No se pudo crear la zona',
                'message' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Muestra información detallada de una zona específica.
     *
     * @param Zona $zona Inyectado automáticamente por Laravel Route Model Binding
     * @return ZonaResource
     */
    public function show(Zona $zona)
    {
        // Cargamos relaciones necesarias para la vista detallada
        $zona->load(['ciudad', 'despachos' => function($query) {
            // Solo los últimos despachos, para no sobrecargar la respuesta
            $query->latest()->take(10);
        }]);

        // Posiblemente cargamos datos de rendimiento o estadísticas
        $zona->setAttribute('estadisticas', $this->obtenerEstadisticas($zona));

        // Transformamos y devolvemos la zona
        return new ZonaResource($zona);
    }

    /**
     * Actualiza una zona existente.
     *
     * @param ZonaRequest $request Datos validados para la actualización
     * @param Zona $zona La zona a actualizar
     * @return ZonaResource
     */
    public function update(ZonaRequest $request, Zona $zona)
    {
        try {
            DB::beginTransaction();

            // Actualizamos la zona con los datos validados
            $zona->update($request->validated());

            // Actualizamos coordenadas si se proporcionan
            if ($request->has('coordenadas')) {
                $zona->actualizarCoordenadas($request->coordenadas);
            }

            DB::commit();

            // Limpiamos caché relacionada con esta zona
            Cache::tags(['zonas'])->flush();

            // Devolvemos la zona actualizada
            return new ZonaResource($zona->fresh());
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Error al actualizar zona: ' . $e->getMessage());

            return response()->json([
                'error' => 'No se pudo actualizar la zona',
                'message' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Elimina una zona de la base de datos.
     *
     * @param Zona $zona La zona a eliminar
     * @return JsonResponse
     */
    public function destroy(Zona $zona)
    {
        try {
            // Verificamos si hay despachos asignados a esta zona
            if ($zona->despachos()->exists()) {
                return response()->json([
                    'error' => 'No se puede eliminar la zona porque tiene despachos asociados'
                ], 409); // Conflict
            }

            // Eliminamos la zona
            $zona->delete();

            // Limpiamos caché
            Cache::tags(['zonas'])->flush();

            // 204 indica éxito sin contenido para devolver
            return response()->json(null, 204);
        } catch (Exception $e) {
            Log::error('Error al eliminar zona: ' . $e->getMessage());

            return response()->json([
                'error' => 'No se pudo eliminar la zona',
                'message' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Encuentra la zona que contiene unas coordenadas específicas.
     *
     * Este método especializado permite determinar en qué zona se encuentra
     * un punto dado, útil para asignación automática de despachos.
     *
     * @param Request $request Contiene las coordenadas a verificar
     * @return JsonResponse
     */
    public function encontrarPorCoordenadas(Request $request)
    {
        // Validamos las coordenadas de entrada
        $request->validate([
            'latitud' => 'required|numeric|between:-90,90',
            'longitud' => 'required|numeric|between:-180,180',
        ]);

        try {
            // Buscamos zonas activas
            $zonas = Zona::where('estado', 'activo')->get();

            // Verificamos cada zona para ver si contiene el punto
            foreach ($zonas as $zona) {
                if ($zona->contienePunto($request->latitud, $request->longitud)) {
                    return new ZonaResource($zona);
                }
            }

            // Si no encontramos ninguna zona que contenga el punto
            return response()->json([
                'message' => 'No se encontró ninguna zona que contenga las coordenadas especificadas'
            ], 404);
        } catch (Exception $e) {
            Log::error('Error al buscar zona por coordenadas: ' . $e->getMessage());

            return response()->json([
                'error' => 'No se pudo realizar la búsqueda por coordenadas',
                'message' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Muestra estadísticas de despachos por zona.
     *
     * Este método proporciona métricas operativas para análisis de rendimiento.
     *
     * @param Request $request Parámetros para filtrar las estadísticas
     * @return JsonResponse
     */
    public function estadisticas(Request $request)
    {
        try {
            // Definimos el período de las estadísticas
            $fechaInicio = $request->input('fecha_inicio', now()->subMonth());
            $fechaFin = $request->input('fecha_fin', now());

            // Consultamos las estadísticas (ejemplo básico)
            $estadisticas = DB::table('despachos')
                ->join('zonas', 'despachos.zona_id', '=', 'zonas.id')
                ->whereBetween('despachos.fecha_despacho', [$fechaInicio, $fechaFin])
                ->select('zonas.nombre', 'zonas.id',
                    DB::raw('COUNT(*) as total_despachos'),
                    DB::raw('AVG(tiempo_entrega) as tiempo_promedio_minutos'),
                    DB::raw('SUM(CASE WHEN estado = "entregado" THEN 1 ELSE 0 END) as entregas_exitosas'),
                    DB::raw('SUM(CASE WHEN estado = "fallido" THEN 1 ELSE 0 END) as entregas_fallidas')
                )
                ->groupBy('zonas.id', 'zonas.nombre')
                ->get();

            return response()->json([
                'periodo' => [
                    'inicio' => $fechaInicio,
                    'fin' => $fechaFin
                ],
                'estadisticas' => $estadisticas
            ]);
        } catch (Exception $e) {
            Log::error('Error al generar estadísticas de zonas: ' . $e->getMessage());

            return response()->json([
                'error' => 'No se pudieron generar las estadísticas',
                'message' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Método auxiliar para obtener estadísticas de una zona específica.
     *
     * @param Zona $zona
     * @return array
     */
    protected function obtenerEstadisticas(Zona $zona)
    {
        // Consulta de estadísticas básicas para una zona específica
        $stats = DB::table('despachos')
            ->where('zona_id', $zona->id)
            ->select(
                DB::raw('COUNT(*) as total_despachos'),
                DB::raw('AVG(tiempo_entrega) as tiempo_promedio_minutos'),
                DB::raw('COUNT(DISTINCT conductor_id) as conductores_asignados')
            )
            ->first();

        return (array) $stats;
    }
}
