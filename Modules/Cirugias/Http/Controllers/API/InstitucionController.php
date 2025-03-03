<?php

namespace Modules\Cirugias\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Modules\Cirugias\Models\Institucion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class InstitucionController extends Controller
{
    /**
     * Muestra el listado de instituciones.
     */
    public function index()
    {
        try {
            $instituciones = Institucion::orderBy('nombre')
                ->withCount('cirugias')
                ->paginate(10);
            return view('cirugias::instituciones.index', compact('instituciones'));
        } catch (Throwable $e) {
            Log::error('Error en InstitucionController@index: ' . $e->getMessage());
            return back()->with('error', 'Error al cargar las instituciones.');
        }
    }

    /**
     * Muestra el formulario para crear una nueva institución.
     */
    public function create()
    {
        try {
            return view('cirugias::instituciones.create');
        } catch (Throwable $e) {
            Log::error('Error en InstitucionController@create: ' . $e->getMessage());
            return back()->with('error', 'Error al cargar el formulario de creación.');
        }
    }

    /**
     * Almacena una nueva institución.
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->validationRules(), $this->validationMessages());

        try {
            DB::transaction(function () use ($validated) {
                Institucion::create($validated);
            });

            return redirect()
                ->route('cirugias.instituciones.index')
                ->with('success', 'Institución creada exitosamente.');
        } catch (Throwable $e) {
            Log::error('Error en InstitucionController@store: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Error al crear la institución. ' . $e->getMessage());
        }
    }

    /**
     * Muestra el formulario de edición de la institución.
     */
    public function edit(Institucion $institucion)
    {
        try {
            return view('cirugias::instituciones.edit', compact('institucion'));
        } catch (Throwable $e) {
            Log::error('Error en InstitucionController@edit: ' . $e->getMessage());
            return back()->with('error', 'Error al cargar el formulario de edición.');
        }
    }

    /**
     * Actualiza la institución especificada.
     */
    public function update(Request $request, Institucion $institucion)
    {
        $validated = $request->validate($this->validationRules(), $this->validationMessages());

        try {
            DB::transaction(function () use ($validated, $institucion) {
                $institucion->update($validated);
            });

            return redirect()
                ->route('cirugias.instituciones.index')
                ->with('success', 'Institución actualizada exitosamente.');
        } catch (Throwable $e) {
            Log::error('Error en InstitucionController@update: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Error al actualizar la institución. ' . $e->getMessage());
        }
    }

    /**
     * Elimina la institución especificada.
     */
    public function destroy(Institucion $institucion)
    {
        try {
            // Verificar si tiene cirugías asociadas
            if ($institucion->cirugias()->exists()) {
                return back()->with('error', 'No se puede eliminar la institución porque tiene cirugías asociadas.');
            }

            DB::transaction(function () use ($institucion) {
                $institucion->delete();
            });

            return redirect()
                ->route('cirugias.instituciones.index')
                ->with('success', 'Institución eliminada exitosamente.');
        } catch (Throwable $e) {
            Log::error('Error en InstitucionController@destroy: ' . $e->getMessage());
            return back()->with('error', 'Error al eliminar la institución. ' . $e->getMessage());
        }
    }

    /**
     * Reglas de validación para store y update.
     *
     * @return array
     */
    protected function validationRules(): array
    {
        return [
            'nombre'    => 'required|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'telefono'  => 'nullable|string|max:20',
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
            'nombre.required'    => 'El nombre de la institución es obligatorio.',
            'nombre.max'         => 'El nombre no puede tener más de 255 caracteres.',
            'direccion.max'      => 'La dirección no puede tener más de 255 caracteres.',
            'telefono.max'       => 'El teléfono no puede tener más de 20 caracteres.',
        ];
    }
}
