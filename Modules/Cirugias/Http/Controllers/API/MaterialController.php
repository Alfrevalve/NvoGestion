<?php

namespace Modules\Cirugias\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Modules\Cirugias\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\MessageBag;
use Throwable;

class MaterialController extends Controller
{
    /**
     * Muestra el listado paginado de materiales.
     */
    public function index()
    {
        try {
            $materiales = Material::orderBy('nombre')
                ->withCount('cirugias')
                ->paginate(10);
            // Se envía un MessageBag vacío para compatibilidad con la vista.
            return view('cirugias::materiales.index', compact('materiales'))
                ->withErrors(new MessageBag());
        } catch (Throwable $e) {
            Log::error('Error en MaterialController@index: ' . $e->getMessage());
            return back()->with('error', 'Error al cargar los materiales.');
        }
    }

    /**
     * Muestra el formulario para crear un nuevo material.
     */
    public function create()
    {
        try {
            return view('cirugias::materiales.create')
                ->withErrors(new MessageBag());
        } catch (Throwable $e) {
            Log::error('Error en MaterialController@create: ' . $e->getMessage());
            return back()->with('error', 'Error al cargar el formulario de creación.');
        }
    }

    /**
     * Almacena un nuevo material.
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->validationRules(), $this->validationMessages());

        try {
            DB::transaction(function () use ($validated) {
                Material::create($validated);
            });

            return redirect()->route('cirugias.materiales.index')
                ->with('success', 'Material creado exitosamente.');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error('Error en MaterialController@store: ' . $e->getMessage());
            return back()->withInput()
                ->withErrors(new MessageBag())
                ->with('error', 'Error al crear el material. ' . $e->getMessage());
        }
    }

    /**
     * Muestra el formulario de edición para un material.
     */
    public function edit(Material $material)
    {
        try {
            if (!$material) {
                return redirect()->route('cirugias.materiales.index')
                    ->with('error', 'Material no encontrado.');
            }
            return view('cirugias::materiales.edit', compact('material'))
                ->withErrors(new MessageBag());
        } catch (Throwable $e) {
            Log::error('Error en MaterialController@edit: ' . $e->getMessage());
            return back()->with('error', 'Error al cargar el formulario de edición.');
        }
    }

    /**
     * Actualiza la información de un material.
     */
    public function update(Request $request, Material $material)
    {
        $validated = $request->validate($this->validationRulesForUpdate($material), $this->validationMessages());

        try {
            DB::transaction(function () use ($validated, $material) {
                $material->update($validated);
            });

            return redirect()->route('cirugias.materiales.index')
                ->with('success', 'Material actualizado exitosamente.');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error('Error en MaterialController@update: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Error al actualizar el material: ' . $e->getMessage());
        }
    }

    /**
     * Elimina un material.
     */
    public function destroy(Material $material)
    {
        try {
            DB::transaction(function () use ($material) {
                if ($material->cirugias()->exists()) {
                    throw new \Exception('No se puede eliminar el material porque tiene cirugías asociadas.');
                }
                $material->delete();
            });

            return redirect()->route('cirugias.materiales.index')
                ->with('success', 'Material eliminado exitosamente.');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error('Error en MaterialController@destroy: ' . $e->getMessage());
            return back()->with('error', 'Error al eliminar el material. ' . $e->getMessage());
        }
    }

    /**
     * Reglas de validación para store.
     *
     * @return array
     */
    protected function validationRules(): array
    {
        return [
            'nombre'           => 'required|string|max:255',
            'codigo'           => 'nullable|string|max:50|unique:materiales,codigo',
            'cantidad'         => 'required|integer|min:0',
            'cantidad_minima'  => 'nullable|integer|min:0',
            'descripcion'      => 'nullable|string',
        ];
    }

    /**
     * Reglas de validación para update.
     *
     * @param Material $material
     * @return array
     */
    protected function validationRulesForUpdate(Material $material): array
    {
        return [
            'nombre'           => 'required|string|max:255',
            'codigo'           => 'nullable|string|max:50|unique:materiales,codigo,' . $material->id,
            'cantidad'         => 'required|integer|min:0',
            'cantidad_minima'  => 'nullable|integer|min:0',
            'descripcion'      => 'nullable|string',
        ];
    }

    /**
     * Mensajes personalizados para la validación.
     *
     * @return array
     */
    protected function validationMessages(): array
    {
        return [
            'nombre.required'          => 'El nombre del material es obligatorio.',
            'nombre.max'               => 'El nombre no puede tener más de 255 caracteres.',
            'codigo.unique'            => 'El código ya está en uso.',
            'cantidad.required'        => 'La cantidad es obligatoria.',
            'cantidad.min'             => 'La cantidad no puede ser negativa.',
            'cantidad_minima.min'      => 'La cantidad mínima no puede ser negativa.',
        ];
    }
}
