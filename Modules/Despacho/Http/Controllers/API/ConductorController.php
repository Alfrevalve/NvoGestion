<?php

namespace Modules\Despacho\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Modules\Despacho\Entities\Conductor;
use Modules\Despacho\Http\Requests\ConductorRequest;
use Modules\Despacho\Http\Resources\ConductorResource;
use Modules\Despacho\Http\Resources\ConductorCollection;
use Exception;
use Carbon\Carbon;

class ConductorController extends Controller
{
    /**
     * Muestra una lista paginada de todos los conductores.
     *
     * El método utiliza paginación para manejar grandes volúmenes de datos
     * y carga anticipadamente (eager loading) las relaciones para evitar
     * el problema N+1 de consultas a la base de datos.
     *
     * @param Request $request Contiene parámetros de filtrado opcionales
     * @return ConductorCollection
     */
    public function index(Request $request)
    {
        try {
            // Comenzamos con una consulta base
            $query = Conductor::query();

            // Aplicamos filtros si existen en la solicitud
            if ($request->has('buscar')) {
                $query->where(function($q) use ($request) {
                    $busqueda = '%' . $request->buscar . '%';
                    $q->where('nombre', 'like', $busqueda)
                      ->orWhere('apellido', 'like', $busqueda)
                      ->orWhere('numero_licencia', 'like', $busqueda);
                });
            }

            if ($request->has('estado')) {
                $query->where('estado', $request->estado);
            }

            // Cargamos relaciones relevantes para evitar consultas N+1
            $query->with(['vehiculos', 'licencia']);

            // Ordenamos y paginamos los resultados
            $conductores = $query->orderBy('apellido')
                                ->orderBy('nombre')
                                ->paginate($request->input('por_pagina', 15));

            // Devolvemos la colección transformada como respuesta
            return new ConductorCollection($conductores);
        } catch (Exception $e) {
            // Registramos el error para depuración posterior
            Log::error('Error al listar conductores: ' . $e->getMessage());

            // Devolvemos un mensaje de error amigable
            return response()->json([
                'error' => 'No se pudo obtener la lista de conductores',
                'message' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Almacena un nuevo conductor en la base de datos.
     *
     * Utiliza una clase de petición dedicada para validar los datos
     * entrantes antes de crear el registro en la base de datos.
     *
     * @param ConductorRequest $request Contiene datos validados para el nuevo conductor
     * @return JsonResponse
     */
    public function store(ConductorRequest $request)
    {
        try {
            // Iniciamos una transacción para garantizar integridad de datos
            DB::beginTransaction();

            // Creamos el conductor con los datos validados
            $conductor = Conductor::create($request->validated());

            // Si hay información de licencia, la procesamos
            if ($request->has('licencia')) {
                $conductor->licencia()->create($request->licencia);
            }

            // Confirmamos la transacción
            DB::commit();

            // Devolvemos el recurso con código 201 (Created)
            return (new ConductorResource($conductor))
                ->response()
                ->setStatusCode(201);
        } catch (Exception $e) {
            // Si algo falla, revertimos la transacción
            DB::rollBack();

            Log::error('Error al crear conductor: ' . $e->getMessage());
            return response()->json([
                'error' => 'No se pudo crear el conductor',
                'message' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Muestra la información detallada de un conductor específico.
     *
     * Utiliza el sistema de resolución de modelos de Laravel para
     * inyectar automáticamente el conductor basándose en el ID de la ruta.
     *
     * @param Conductor $conductor Inyectado automáticamente por Laravel
     * @return ConductorResource
     */
    public function show(Conductor $conductor)
    {
        // Cargamos relaciones que puedan ser necesarias para el detalle
        $conductor->load([
            'vehiculos',
            'licencia',
            'despachos' => function($query) {
                // Solo los últimos despachos, ordenados por fecha
                $query->latest()->take(5);
            }
        ]);

        // Transformamos y devolvemos el modelo
        return new ConductorResource($conductor);
    }

    /**
     * Actualiza la información de un conductor existente.
     *
     * @param ConductorRequest $request Datos validados para la actualización
     * @param Conductor $conductor El conductor a actualizar
     * @return ConductorResource
     */
    public function update(ConductorRequest $request, Conductor $conductor)
    {
        try {
            DB::beginTransaction();

            // Actualizamos el conductor con los datos validados
            $conductor->update($request->validated());

            // Actualizamos información de licencia si existe
            if ($request->has('licencia') && $conductor->licencia) {
                $conductor->licencia->update($request->licencia);
            } elseif ($request->has('licencia')) {
                $conductor->licencia()->create($request->licencia);
            }

            DB::commit();

            // Devolvemos el recurso actualizado (fresh carga el modelo de la BD)
            return new ConductorResource($conductor->fresh());
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Error al actualizar conductor: ' . $e->getMessage());
            return response()->json([
                'error' => 'No se pudo actualizar el conductor',
                'message' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Elimina un conductor de la base de datos.
     *
     * Verifica dependencias antes de eliminar para mantener
     * la integridad referencial de los datos.
     *
     * @param Conductor $conductor El conductor a eliminar
     * @return JsonResponse
     */
    public function destroy(Conductor $conductor)
    {
        try {
            // Verificamos si tiene despachos activos antes de eliminar
            if ($conductor->tieneDespachosPendientes()) {
                return response()->json([
                    'error' => 'No se puede eliminar el conductor porque tiene despachos pendientes'
                ], 409); // Conflict
            }

            // Eliminamos el conductor
            $conductor->delete();

            // Código 204 indica éxito sin contenido en la respuesta
            return response()->json(null, 204);
        } catch (Exception $e) {
            Log::error('Error al eliminar conductor: ' . $e->getMessage());
            return response()->json([
                'error' => 'No se pudo eliminar el conductor',
                'message' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Devuelve conductores disponibles para asignar a un despacho.
     *
     * Método personalizado que va más allá del CRUD básico para
     * satisfacer un caso de uso específico del negocio.
     *
     * @return JsonResponse
     */
    public function disponibles()
    {
        try {
            $conductores = Conductor::where('estado', 'disponible')
                ->where('activo', true)
                ->whereHas('licencia', function ($query) {
                    // Solo conductores con licencia vigente
                    $query->where('fecha_vencimiento', '>', Carbon::now());
                })
                ->with('vehiculos') // Incluimos vehículos asignados
                ->get();

            return ConductorResource::collection($conductores);
        } catch (Exception $e) {
            Log::error('Error al listar conductores disponibles: ' . $e->getMessage());
            return response()->json([
                'error' => 'Error al obtener conductores disponibles',
                'message' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Verifica si un conductor tiene su documentación al día.
     *
     * @param Conductor $conductor
     * @return JsonResponse
     */
    public function verificarDocumentacion(Conductor $conductor)
    {
        try {
            $licenciaVigente = false;
            $diasParaVencimiento = null;

            if ($conductor->licencia) {
                $licenciaVigente = $conductor->licencia->fecha_vencimiento > Carbon::now();
                $diasParaVencimiento = Carbon::now()->diffInDays(
                    $conductor->licencia->fecha_vencimiento,
                    false
                );
            }

            return response()->json([
                'conductor_id' => $conductor->id,
                'nombre_completo' => $conductor->nombre_completo,
                'licencia_vigente' => $licenciaVigente,
                'dias_para_vencimiento' => $diasParaVencimiento,
                'documentacion_completa' => $conductor->tieneDocumentacionCompleta(),
                'documentos_pendientes' => $conductor->documentosPendientes()
            ]);
        } catch (Exception $e) {
            Log::error('Error al verificar documentación: ' . $e->getMessage());
            return response()->json([
                'error' => 'No se pudo verificar la documentación',
                'message' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
}
