<?php

namespace Modules\Cirugias\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Modules\Cirugias\Models\Instrumentista;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class InstrumentistaController extends Controller
{
    /**
     * Muestra el listado paginado de instrumentistas.
     */
    public function index()
    {
        try {
            $instrumentistas = Instrumentista::orderBy('nombre')
                ->withCount('cirugias')
                ->paginate(10);
            return view('cirugias::instrumentistas.index', compact('instrumentistas'));
        } catch (Throwable $e) {
            Log::error('Error en InstrumentistaController@index: ' . $e->getMessage());
            return back()->with('error', 'Error al cargar los instrumentistas.');
        }
    }

    /**
     * Muestra el formulario para crear un nuevo instrumentista.
     */
    public function create()
    {
        try {
            return view('cirugias::instrumentistas.create');
        } catch (Throwable $e) {
            Log::error('Error en InstrumentistaController@create: ' . $e->getMessage());
            return back()->with('error', 'Error al cargar el formulario de creación.');
        }
    }

    /**
     * Almacena un nuevo instrumentista.
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->validationRules(), $this->validationMessages());

        try {
            Instrumentista::create($validated);
            return redirect()->route('cirugias.instrumentistas.index')
                ->with('success', 'Instrumentista registrado exitosamente.');
        } catch (Throwable $e) {
            Log::error('Error en InstrumentistaController@store: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Error al registrar el instrumentista.');
        }
    }

    /**
     * Muestra el formulario de edición de un instrumentista.
     */
    public function edit(Instrumentista $instrumentista)
    {
        try {
            $instrumentista->load(['cirugias' => function ($query) {
                $query->with(['institucion', 'medico'])
                    ->orderBy('fecha', 'desc')
                    ->take(5);
            }]);
            return view('cirugias::instrumentistas.edit', compact('instrumentista'));
        } catch (Throwable $e) {
            Log::error('Error en InstrumentistaController@edit: ' . $e->getMessage());
            return back()->with('error', 'Error al cargar el formulario de edición.');
        }
    }

    /**
     * Actualiza la información de un instrumentista.
     */
    public function update(Request $request, Instrumentista $instrumentista)
    {
        $validated = $request->validate($this->validationRules(), $this->validationMessages());

        try {
            $instrumentista->update($validated);
            return redirect()->route('cirugias.instrumentistas.index')
                ->with('success', 'Instrumentista actualizado exitosamente.');
        } catch (Throwable $e) {
            Log::error('Error en InstrumentistaController@update: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Error al actualizar el instrumentista.');
        }
    }

    /**
     * Elimina un instrumentista.
     */
    public function destroy(Instrumentista $instrumentista)
    {
        try {
            if ($instrumentista->cirugias()->exists()) {
                return redirect()->route('cirugias.instrumentistas.index')
                    ->with('error', 'No se puede eliminar el instrumentista porque tiene cirugías asociadas.');
            }
            $instrumentista->delete();
            return redirect()->route('cirugias.instrumentistas.index')
                ->with('success', 'Instrumentista eliminado exitosamente.');
        } catch (Throwable $e) {
            Log::error('Error en InstrumentistaController@destroy: ' . $e->getMessage());
            return redirect()->route('cirugias.instrumentistas.index')
                ->with('error', 'Ocurrió un error al intentar eliminar el instrumentista.');
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
            'nombre'         => 'required|max:255',
            'telefono'       => 'nullable|max:20',
            'disponibilidad' => 'nullable|in:mañana,tarde,noche,24h',
            'observaciones'  => 'nullable|max:1000',
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
            'nombre.required'   => 'El nombre del instrumentista es obligatorio',
            'nombre.max'        => 'El nombre no puede tener más de 255 caracteres',
            'telefono.max'      => 'El teléfono no puede tener más de 20 caracteres',
            'disponibilidad.in' => 'La disponibilidad seleccionada no es válida',
            'observaciones.max' => 'Las observaciones no pueden tener más de 1000 caracteres',
        ];
    }
}

