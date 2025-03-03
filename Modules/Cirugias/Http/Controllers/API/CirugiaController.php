<?php

namespace Modules\Cirugias\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Modules\Cirugias\Models\Cirugia;
use Modules\Cirugias\Models\Institucion;
use Modules\Cirugias\Models\Medico;
use Modules\Cirugias\Models\Instrumentista;
use Modules\Cirugias\Models\Equipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class CirugiaController extends Controller
{
    /**
     * Muestra el listado paginado de cirugías.
     */
    public function index()
    {
        try {
            $cirugias = Cirugia::with(['medico', 'institucion', 'instrumentista', 'equipo'])
                ->orderBy('fecha', 'desc')
                ->paginate(10);

            return view('cirugias::index', compact('cirugias'));
        } catch (Throwable $e) {
            Log::error('Error en CirugiaController@index: ' . $e->getMessage());
            return back()->with('error', 'Error al cargar las cirugías.');
        }
    }

    /**
     * Muestra el formulario para crear una nueva cirugía.
     */
    public function create()
    {
        try {
            $instituciones = Institucion::orderBy('nombre')->get();
            $medicos = Medico::orderBy('nombre')->get();
            $instrumentistas = Instrumentista::orderBy('nombre')->get();
            $equipos = Equipo::where('estado', 'disponible')->orderBy('nombre')->get();

            return view('cirugias::create', compact('instituciones', 'medicos', 'instrumentistas', 'equipos'));
        } catch (Throwable $e) {
            Log::error('Error en CirugiaController@create: ' . $e->getMessage());
            return back()->with('error', 'Error al cargar el formulario de creación.');
        }
    }

    /**
     * Almacena una nueva cirugía.
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->rules(), $this->messages());

        try {
            DB::transaction(function () use ($validated) {
                Cirugia::create($validated);
            });

            return redirect()->route('modulo.cirugias.index')
                ->with('success', 'Cirugía creada exitosamente.');
        } catch (Throwable $e) {
            Log::error('Error en CirugiaController@store: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Error al crear la cirugía.');
        }
    }

    /**
     * Muestra la información de una cirugía específica.
     */
    public function show(Cirugia $cirugia)
    {
        try {
            $cirugia->load(['medico', 'institucion', 'instrumentista', 'equipo', 'materiales']);
            return view('cirugias::show', compact('cirugia'));
        } catch (Throwable $e) {
            Log::error('Error en CirugiaController@show: ' . $e->getMessage());
            return back()->with('error', 'Error al cargar la cirugía.');
        }
    }

    /**
     * Muestra el formulario de edición de una cirugía.
     */
    public function edit(Cirugia $cirugia)
    {
        try {
            $instituciones = Institucion::orderBy('nombre')->get();
            $medicos = Medico::orderBy('nombre')->get();
            $instrumentistas = Instrumentista::orderBy('nombre')->get();
            // Se muestran los equipos disponibles y el equipo asignado a la cirugía, aunque no esté disponible
            $equipos = Equipo::where('estado', 'disponible')
                ->orWhere('id', $cirugia->equipo_id)
                ->orderBy('nombre')
                ->get();

            return view('cirugias::edit', compact('cirugia', 'instituciones', 'medicos', 'instrumentistas', 'equipos'));
        } catch (Throwable $e) {
            Log::error('Error en CirugiaController@edit: ' . $e->getMessage());
            return back()->with('error', 'Error al cargar el formulario de edición.');
        }
    }

    /**
     * Actualiza la información de una cirugía.
     */
    public function update(Request $request, Cirugia $cirugia)
    {
        $validated = $request->validate($this->rules(), $this->messages());

        try {
            DB::transaction(function () use ($validated, $cirugia) {
                $cirugia->update($validated);
            });

            return redirect()->route('modulo.cirugias.show', $cirugia)
                ->with('success', 'Cirugía actualizada exitosamente.');
        } catch (Throwable $e) {
            Log::error('Error en CirugiaController@update: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Error al actualizar la cirugía.');
        }
    }

    /**
     * Elimina una cirugía.
     */
    public function destroy(Cirugia $cirugia)
    {
        try {
            $cirugia->delete();
            return redirect()->route('modulo.cirugias.index')
                ->with('success', 'Cirugía eliminada exitosamente.');
        } catch (Throwable $e) {
            Log::error('Error en CirugiaController@destroy: ' . $e->getMessage());
            return back()->with('error', 'Error al eliminar la cirugía.');
        }
    }

    /**
     * Reglas de validación comunes para store y update.
     *
     * @return array
     */
    protected function rules(): array
    {
        return [
            'fecha'             => 'required|date',
            'hora'              => 'required',
            'tipo_cirugia'      => 'required|string|max:255',
            'institucion_id'    => 'required|exists:instituciones,id',
            'medico_id'         => 'required|exists:medicos,id',
            'instrumentista_id' => 'required|exists:instrumentistas,id',
            'equipo_id'         => 'required|exists:equipos,id',
            'estado'            => 'required|in:pendiente,programada,en proceso,finalizada',
            'prioridad'         => 'required|in:baja,media,alta,urgente',
            'duracion_estimada' => 'nullable|integer|min:1',
            'observaciones'     => 'nullable|string',
        ];
    }

    /**
     * Mensajes personalizados para la validación.
     *
     * @return array
     */
    protected function messages(): array
    {
        return [
            'fecha.required'             => 'La fecha es obligatoria.',
            'fecha.date'                 => 'La fecha debe tener un formato válido.',
            'hora.required'              => 'La hora es obligatoria.',
            'tipo_cirugia.required'      => 'El tipo de cirugía es obligatorio.',
            'tipo_cirugia.max'           => 'El tipo de cirugía no puede tener más de 255 caracteres.',
            'institucion_id.required'    => 'La institución es obligatoria.',
            'institucion_id.exists'      => 'La institución seleccionada no es válida.',
            'medico_id.required'         => 'El médico es obligatorio.',
            'medico_id.exists'           => 'El médico seleccionado no es válido.',
            'instrumentista_id.required' => 'El instrumentista es obligatorio.',
            'instrumentista_id.exists'   => 'El instrumentista seleccionado no es válido.',
            'equipo_id.required'         => 'El equipo es obligatorio.',
            'equipo_id.exists'           => 'El equipo seleccionado no es válido.',
            'estado.required'            => 'El estado es obligatorio.',
            'estado.in'                => 'El estado debe ser: pendiente, programada, en proceso o finalizada.',
            'prioridad.required'         => 'La prioridad es obligatoria.',
            'prioridad.in'             => 'La prioridad debe ser: baja, media, alta o urgente.',
            'duracion_estimada.integer'  => 'La duración estimada debe ser un número entero.',
            'duracion_estimada.min'      => 'La duración estimada debe ser al menos 1 minuto.',
        ];
    }
}
