<?php

namespace Modules\Cirugias\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Modules\Cirugias\Models\Medico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class MedicoController extends Controller
{
    /**
     * Muestra el listado paginado de médicos.
     */
    public function index()
    {
        try {
            $medicos = Medico::orderBy('nombre')->paginate(10);
            return view('cirugias::medicos.index', compact('medicos'));
        } catch (Throwable $e) {
            Log::error('Error en MedicoController@index: ' . $e->getMessage());
            return back()->with('error', 'Error al cargar los médicos.');
        }
    }

    /**
     * Muestra el formulario para crear un nuevo médico.
     */
    public function create()
    {
        try {
            return view('cirugias::medicos.create');
        } catch (Throwable $e) {
            Log::error('Error en MedicoController@create: ' . $e->getMessage());
            return back()->with('error', 'Error al cargar el formulario de creación.');
        }
    }

    /**
     * Almacena un nuevo médico.
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->validationRules(), $this->validationMessages());

        try {
            DB::transaction(function () use ($validated) {
                Medico::create($validated);
            });

            return redirect()->route('cirugias.medicos.index')
                ->with('success', 'Médico registrado exitosamente.');
        } catch (Throwable $e) {
            Log::error('Error en MedicoController@store: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Error al registrar el médico.');
        }
    }

    /**
     * Muestra el formulario de edición de un médico.
     */
    public function edit(Medico $medico)
    {
        try {
            return view('cirugias::medicos.edit', compact('medico'));
        } catch (Throwable $e) {
            Log::error('Error en MedicoController@edit: ' . $e->getMessage());
            return back()->with('error', 'Error al cargar el formulario de edición.');
        }
    }

    /**
     * Actualiza la información del médico.
     */
    public function update(Request $request, Medico $medico)
    {
        $validated = $request->validate($this->validationRules(), $this->validationMessages());

        try {
            DB::transaction(function () use ($validated, $medico) {
                $medico->update($validated);
            });

            return redirect()->route('cirugias.medicos.index')
                ->with('success', 'Médico actualizado exitosamente.');
        } catch (Throwable $e) {
            Log::error('Error en MedicoController@update: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Error al actualizar el médico.');
        }
    }

    /**
     * Elimina un médico.
     */
    public function destroy(Medico $medico)
    {
        try {
            $medico->delete();
            return redirect()->route('cirugias.medicos.index')
                ->with('success', 'Médico eliminado exitosamente.');
        } catch (Throwable $e) {
            Log::error('Error en MedicoController@destroy: ' . $e->getMessage());
            return redirect()->route('cirugias.medicos.index')
                ->with('error', 'No se puede eliminar el médico porque tiene cirugías asociadas.');
        }
    }

    /**
     * Reglas de validación comunes para store y update.
     *
     * @return array
     */
    protected function validationRules(): array
    {
        return [
            'nombre'       => 'required|string|max:255',
            'especialidad' => 'required|string|max:255',
            'telefono'     => 'nullable|string|max:20',
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
            'nombre.required'       => 'El nombre del médico es obligatorio.',
            'especialidad.required' => 'La especialidad es obligatoria.',
            'nombre.max'            => 'El nombre no puede tener más de 255 caracteres.',
            'especialidad.max'      => 'La especialidad no puede tener más de 255 caracteres.',
            'telefono.max'          => 'El teléfono no puede tener más de 20 caracteres.',
        ];
    }
}
