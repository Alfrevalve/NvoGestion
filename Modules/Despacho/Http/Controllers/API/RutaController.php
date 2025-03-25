<?php

namespace Modules\Despacho\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Modules\Despacho\Models\Ruta;
use Modules\Despacho\Http\Resources\RutaResource;
use Modules\Despacho\Http\Requests\RutaRequest;
use Exception;

/**
 * @group Gestión de Rutas
 *
 * API para administrar las rutas de despacho
 */
class RutaController extends Controller
{
    /**
     * Muestra un listado de todas las rutas.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $rutas = Ruta::all();
            return response()->json([
                'success' => true,
                'data' => RutaResource::collection($rutas),
                'message' => 'Rutas obtenidas correctamente'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las rutas',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Almacena una nueva ruta en la base de datos.
     *
     * @param \Modules\Despacho\Http\Requests\RutaRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(RutaRequest $request)
    {
        try {
            // El RutaRequest ya se encarga de la validación

            $ruta = Ruta::create($request->validated());

            return response()->json([
                'success' => true,
                'data' => new RutaResource($ruta),
                'message' => 'Ruta creada exitosamente'
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear la ruta',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Muestra una ruta específica.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $ruta = Ruta::findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => new RutaResource($ruta),
                'message' => 'Ruta obtenida correctamente'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ruta no encontrada',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Actualiza una ruta específica.
     *
     * @param \Modules\Despacho\Http\Requests\RutaRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(RutaRequest $request, $id)
    {
        try {
            $ruta = Ruta::findOrFail($id);
            $ruta->update($request->validated());

            return response()->json([
                'success' => true,
                'data' => new RutaResource($ruta),
                'message' => 'Ruta actualizada correctamente'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la ruta',
                'error' => $e->getMessage()
            ], $e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException ? 404 : 500);
        }
    }

    /**
     * Elimina una ruta específica.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $ruta = Ruta::findOrFail($id);
            $ruta->delete();

            return response()->json([
                'success' => true,
                'message' => 'Ruta eliminada correctamente'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la ruta',
                'error' => $e->getMessage()
            ], $e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException ? 404 : 500);
        }
    }
}
