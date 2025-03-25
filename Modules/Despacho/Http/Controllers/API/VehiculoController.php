<?php

namespace Modules\Despacho\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Modules\Despacho\Entities\Vehiculo;
use Modules\Despacho\Http\Requests\VehiculoRequest;
use Modules\Despacho\Http\Resources\VehiculoResource;
use Modules\Despacho\Http\Resources\VehiculoCollection;
use Exception;

class VehiculoController extends Controller
{
    /**
     * Muestra una lista de todos los vehículos.
     *
     * @return VehiculoCollection
     */
    public function index()
    {
        try {
            $vehiculos = Vehiculo::with(['conductor', 'tipo'])
                ->orderBy('placa')
                ->paginate(15);

            return new VehiculoCollection($vehiculos);
        } catch (Exception $e) {
            Log::error('Error al listar vehículos: ' . $e->getMessage());
            return response()->json(['error' => 'Error al obtener la lista de vehículos'], 500);
        }
    }

    /**
     * Almacena un nuevo vehículo en la base de datos.
     *
     * @param VehiculoRequest $request
     * @return JsonResponse
     */
    public function store(VehiculoRequest $request)
    {
        try {
            // Los datos ya están validados gracias a VehiculoRequest
            $vehiculo = Vehiculo::create($request->validated());

            return (new VehiculoResource($vehiculo))
                ->response()
                ->setStatusCode(201);
        } catch (Exception $e) {
            Log::error('Error al crear vehículo: ' . $e->getMessage());
            return response()->json(['error' => 'No se pudo crear el vehículo'], 500);
        }
    }

    /**
     * Muestra la información de un vehículo específico.
     *
     * @param Vehiculo $vehiculo
     * @return VehiculoResource
     */
    public function show(Vehiculo $vehiculo)
    {
        // Cargamos relaciones que puedan ser necesarias
        $vehiculo->load(['conductor', 'tipo', 'mantenimientos']);

        return new VehiculoResource($vehiculo);
    }

    /**
     * Actualiza un vehículo existente.
     *
     * @param VehiculoRequest $request
     * @param Vehiculo $vehiculo
     * @return VehiculoResource
     */
    public function update(VehiculoRequest $request, Vehiculo $vehiculo)
    {
        try {
            $vehiculo->update($request->validated());

            return new VehiculoResource($vehiculo->fresh());
        } catch (Exception $e) {
            Log::error('Error al actualizar vehículo: ' . $e->getMessage());
            return response()->json(['error' => 'No se pudo actualizar el vehículo'], 500);
        }
    }

    /**
     * Elimina un vehículo de la base de datos.
     *
     * @param Vehiculo $vehiculo
     * @return JsonResponse
     */
    public function destroy(Vehiculo $vehiculo)
    {
        try {
            // Podríamos verificar si hay registros dependientes antes de eliminar
            if ($vehiculo->tieneDespachosPendientes()) {
                return response()->json([
                    'error' => 'No se puede eliminar el vehículo porque tiene despachos pendientes'
                ], 409); // Conflict
            }

            $vehiculo->delete();

            return response()->json(null, 204); // No Content
        } catch (Exception $e) {
            Log::error('Error al eliminar vehículo: ' . $e->getMessage());
            return response()->json(['error' => 'No se pudo eliminar el vehículo'], 500);
        }
    }

    /**
     * Devuelve vehículos disponibles para asignar a un despacho.
     *
     * @return JsonResponse
     */
    public function disponibles()
    {
        try {
            $vehiculos = Vehiculo::where('estado', 'disponible')
                ->where('activo', true)
                ->get();

            return VehiculoResource::collection($vehiculos);
        } catch (Exception $e) {
            Log::error('Error al listar vehículos disponibles: ' . $e->getMessage());
            return response()->json(['error' => 'Error al obtener vehículos disponibles'], 500);
        }
    }
}
