<?php

namespace Modules\Cirugias\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Modules\Cirugias\Models\Equipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class EquipoController extends Controller
{
    /**
     * Muestra el listado de equipos, estadísticas y alertas.
     */
    public function index()
    {
        try {
            $equipos = Equipo::withCount('cirugias')
                ->orderBy('nombre')
                ->paginate(10);

            $stats = [
                'total'         => Equipo::count(),
                'disponibles'   => Equipo::where('estado', 'disponible')->count(),
                'en_uso'        => Equipo::where('estado', 'en uso')->count(),
                'mantenimiento' => Equipo::where('estado', 'mantenimiento')->count(),
                'fuera_servicio'=> Equipo::where('estado', 'fuera de servicio')->count(),
            ];

            $alertas = [];

            $equiposMantenimiento = Equipo::where('estado', 'mantenimiento')->count();
            if ($equiposMantenimiento > 0) {
                $alertas[] = [
                    'tipo'    => 'warning',
                    'mensaje' => "Hay {$equiposMantenimiento} equipo(s) en mantenimiento."
                ];
            }

            $equiposFueraServicio = Equipo::where('estado', 'fuera de servicio')->count();
            if ($equiposFueraServicio > 0) {
                $alertas[] = [
                    'tipo'    => 'danger',
                    'mensaje' => "Hay {$equiposFueraServicio} equipo(s) fuera de servicio."
                ];
            }

            $equiposMantenimientoProximo = Equipo::whereNotNull('fecha_mantenimiento')
                ->whereDate('fecha_mantenimiento', '<=', now()->addDays(7))
                ->whereDate('fecha_mantenimiento', '>=', now())
                ->count();
            if ($equiposMantenimientoProximo > 0) {
                $alertas[] = [
                    'tipo'    => 'info',
                    'mensaje' => "{$equiposMantenimientoProximo} equipo(s) requieren mantenimiento en los próximos 7 días."
                ];
            }

            return view('cirugias::equipos.index', compact('equipos', 'stats', 'alertas'));
        } catch (Throwable $e) {
            Log::error('Error en EquipoController@index: ' . $e->getMessage());
            return back()->with('error', 'Error al cargar los equipos.');
        }
    }

    /**
     * Muestra el formulario para crear un nuevo equipo.
     */
    public function create()
    {
        try {
            $estadoOptions = Equipo::getEstadoOptions();
            return view('cirugias::equipos.create', compact('estadoOptions'));
        } catch (Throwable $e) {
            Log::error('Error en EquipoController@create: ' . $e->getMessage());
            return back()->with('error', 'Error al cargar el formulario de creación.');
        }
    }

    /**
     * Almacena un nuevo equipo.
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->validationRules(), $this->validationMessages());

        try {
            DB::transaction(function () use ($validated) {
                Equipo::create($validated);
            });

            return redirect()->route('cirugias.equipos.index')
                ->with('success', 'Equipo creado exitosamente.');
        } catch (Throwable $e) {
            Log::error('Error en EquipoController@store: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Error al crear el equipo: ' . $e->getMessage());
        }
    }

    /**
     * Muestra el formulario de edición para un equipo.
     */
    public function edit(Equipo $equipo)
    {
        try {
            $estadoOptions = Equipo::getEstadoOptions();
            $equipo->load(['cirugias' => function ($query) {
                $query->with(['institucion', 'medico'])
                    ->orderBy('fecha', 'desc')
                    ->take(5);
            }]);

            return view('cirugias::equipos.edit', compact('equipo', 'estadoOptions'));
        } catch (Throwable $e) {
            Log::error('Error en EquipoController@edit: ' . $e->getMessage());
            return back()->with('error', 'Error al cargar el formulario de edición.');
        }
    }

    /**
     * Actualiza la información de un equipo.
     */
    public function update(Request $request, Equipo $equipo)
    {
        $validated = $request->validate($this->validationRules(), $this->validationMessages());

        try {
            // Evitar cambiar el estado si hay cirugías activas y el equipo está en uso
            if ($equipo->estado === 'en uso' && $validated['estado'] !== 'en uso') {
                $cirugiasActivas = $equipo->cirugias()
                    ->whereIn('estado', ['programada', 'en proceso'])
                    ->exists();

                if ($cirugiasActivas) {
                    return back()->withInput()
                        ->with('error', 'No se puede cambiar el estado del equipo porque tiene cirugías activas.');
                }
            }

            DB::transaction(function () use ($validated, $equipo) {
                $equipo->update($validated);
            });

            return redirect()->route('cirugias.equipos.index')
                ->with('success', 'Equipo actualizado exitosamente.');
        } catch (Throwable $e) {
            Log::error('Error en EquipoController@update: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Error al actualizar el equipo: ' . $e->getMessage());
        }
    }

    /**
     * Elimina un equipo.
     */
    public function destroy(Equipo $equipo)
    {
        try {
            if ($equipo->cirugias()->exists()) {
                return back()->with('error', 'No se puede eliminar el equipo porque tiene cirugías asociadas.');
            }

            if ($equipo->estado === 'en uso') {
                return back()->with('error', 'No se puede eliminar el equipo porque está en uso.');
            }

            DB::transaction(function () use ($equipo) {
                $equipo->delete();
            });

            return redirect()->route('cirugias.equipos.index')
                ->with('success', 'Equipo eliminado exitosamente.');
        } catch (Throwable $e) {
            Log::error('Error en EquipoController@destroy: ' . $e->getMessage());
            return back()->with('error', 'Error al eliminar el equipo: ' . $e->getMessage());
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
            'nombre'             => 'required|string|max:255',
            'descripcion'        => 'nullable|string',
            'numero_serie'       => 'nullable|string|max:50',
            'fecha_adquisicion'  => 'nullable|date',
            'fecha_mantenimiento'=> 'nullable|date|after_or_equal:fecha_adquisicion',
            'estado'             => 'required|in:disponible,en uso,mantenimiento,fuera de servicio',
            'notas'              => 'nullable|string',
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
            'nombre.required'              => 'El nombre del equipo es obligatorio.',
            'nombre.max'                   => 'El nombre no puede tener más de 255 caracteres.',
            'fecha_mantenimiento.after_or_equal' => 'La fecha de mantenimiento debe ser posterior o igual a la fecha de adquisición.',
            'estado.required'              => 'El estado es obligatorio.',
            'estado.in'                    => 'El estado seleccionado no es válido.',
        ];
    }
}
