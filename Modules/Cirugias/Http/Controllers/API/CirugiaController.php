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
use Modules\Cirugias\Exceptions\CirugiaNotFoundException;

class CirugiaController extends Controller
{
    public function show($id)
    {
        try {
            $cirugia = Cirugia::with(['medico', 'institucion', 'instrumentista', 'equipo'])->find($id);

            if (!$cirugia) {
                return response()->json([
                    'success' => false,
                    'error' => [
                        'message' => 'Cirugía no encontrada.',
                        'code' => 404
                    ]
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $cirugia
            ]);
        } catch (Throwable $e) {
            Log::error('Error en CirugiaController@show: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => [
                    'message' => 'Error al obtener la cirugía.',
                    'type' => get_class($e),
                    'code' => $e->getCode() ?: 500
                ]
            ], $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $cirugia = Cirugia::find($id);

            if (!$cirugia) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'error' => [
                            'message' => 'Cirugía no encontrada.',
                            'code' => 404
                        ]
                    ], 404);
                }
                return back()->with('error', 'Cirugía no encontrada.');
            }

            $cirugia->update($request->all());

            // If the request expects JSON (API)
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => $cirugia
                ]);
            }

            // If it's a normal web request, redirect with a success message
            return redirect()->route('modulo.cirugias.show', $cirugia->id)
                ->with('success', 'Cirugía actualizada correctamente');
        } catch (Throwable $e) {
            Log::error('Error en CirugiaController@update: ' . $e->getMessage());

            // If the request expects JSON
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'error' => [
                        'message' => 'Error al actualizar la cirugía.',
                        'type' => get_class($e),
                        'code' => $e->getCode() ?: 500
                    ]
                ], $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500);
            }

            // If it's a web request
            return back()->withInput()
                ->with('error', 'Error al actualizar la cirugía: ' . $e->getMessage());
        }
    }

    public function calendario()
    {
        try {
            \Log::info('Retrieving events for calendar view');
            $eventos = Cirugia::with(['medico', 'institucion'])
                ->whereIn('estado', ['pendiente', 'programada', 'en proceso', 'finalizada'])
                ->get()
                ->map(function ($cirugia) {
                    // Asegurar que fecha y hora estén formateados correctamente
                    $fecha = $cirugia->fecha instanceof \Carbon\Carbon ? $cirugia->fecha->format('Y-m-d') : $cirugia->fecha;
                    $hora = $cirugia->hora instanceof \Carbon\Carbon ? $cirugia->hora->format('H:i:s') : $cirugia->hora;

                    return [
                        'id' => $cirugia->id,
                        'title' => $cirugia->tipo_cirugia,
                        'start' => $fecha . 'T' . $hora,
                        'extendedProps' => [
                            'medico' => $cirugia->medico ? $cirugia->medico->nombre : 'Sin médico',
                            'institucion' => $cirugia->institucion ? $cirugia->institucion->nombre : 'Sin institución',
                            'estado' => $cirugia->estado,
                            'estadoClass' => $cirugia->estado == 'pendiente' ? 'primary' : ($cirugia->estado == 'programada' ? 'info' : ($cirugia->estado == 'en proceso' ? 'warning' : 'success')),
                            'prioridad' => $cirugia->prioridad,
                            'prioridadClass' => $cirugia->prioridad == 'baja' ? 'success' : ($cirugia->prioridad == 'media' ? 'info' : ($cirugia->prioridad == 'alta' ? 'warning' : 'danger')),
                        ],
                    ];
                });

            \Log::info('SQL Query executed for calendar view', ['query' => Cirugia::query()->toSql()]);
            \Log::info('Events retrieved for calendar view', ['count' => $eventos->count()]);

            return view('cirugias::calendario', compact('eventos'));
        } catch (Throwable $e) {
            \Log::error('Error en método calendario: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return back()->with('error', 'Error al cargar el calendario de cirugías: ' . $e->getMessage());
        }
    }

    /**
     * Muestra el listado filtrado y ordenado de cirugías.
     */
    public function filtered(Request $request)
    {
        try {
            Log::info('Entrada al método filtered', ['params' => $request->all()]);

            $query = Cirugia::query();

            if ($request->has('estado')) {
                $query->where('estado', $request->input('estado'));
                Log::info('Aplicando filtro de estado', ['estado' => $request->input('estado')]);
            }

            if ($request->has('sort_by') && $request->has('sort_order')) {
                $query->orderBy($request->input('sort_by'), $request->input('sort_order'));
                Log::info('Aplicando ordenamiento', [
                    'sort_by' => $request->input('sort_by'),
                    'sort_order' => $request->input('sort_order')
                ]);
            }

            // Capturar la consulta SQL
            $sqlQuery = $query->toSql();
            $bindings = $query->getBindings();
            Log::info('Consulta SQL generada', ['query' => $sqlQuery, 'bindings' => $bindings]);

            $cirugias = $query->with(['medico', 'institucion', 'instrumentista', 'equipo'])->paginate(10);

            Log::info('Resultados obtenidos', [
                'count' => $cirugias->count(),
                'total' => $cirugias->total()
            ]);

            // Usar el formato estándar de respuesta de tu API
            return response()->json([
                'success' => true,
                'data' => $cirugias
            ]);
        } catch (CirugiaNotFoundException $e) {
            Log::error('Cirugia no encontrada', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'error' => [
                    'message' => 'Cirugía no encontrada.',
                    'type' => 'CirugiaNotFoundException',
                    'code' => 404
                ]
            ], 404);
        } catch (\Exception $e) {
            Log::error('Error en filtered', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'error' => [
                    'message' => $e->getMessage(),
                    'type' => get_class($e),
                    'code' => $e->getCode() ?: 500
                ]
            ], $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500);
        }
    }

    /**
     * Muestra el formulario para editar una cirugía existente.
     */
    public function edit($id)
    {
        try {
            $cirugia = Cirugia::find($id);

            if (!$cirugia) {
                return back()->with('error', 'Cirugía no encontrada.');
            }

            $instituciones = Institucion::orderBy('nombre')->get();
            $medicos = Medico::orderBy('nombre')->get();
            $instrumentistas = Instrumentista::orderBy('nombre')->get();
            $equipos = Equipo::where('estado', 'disponible')->orderBy('nombre')->get();

            return view('cirugias::edit', compact('cirugia', 'instituciones', 'medicos', 'instrumentistas', 'equipos'));
        } catch (Throwable $e) {
            Log::error('Error en CirugiaController@edit: ' . $e->getMessage());
            return back()->with('error', 'Error al cargar el formulario de edición.');
        }
    }

    public function index()
    {
        try {
            $totalSurgeriesCurrentMonth = Cirugia::whereMonth('fecha', now()->month)->count();
            $totalSurgeriesLastMonth = Cirugia::whereMonth('fecha', now()->subMonth()->month)->count();

            $cirugias = Cirugia::with(['medico', 'institucion', 'instrumentista', 'equipo'])
                ->orderBy('fecha', 'desc')
                ->paginate(10);

            return view('cirugias::index', compact('cirugias', 'totalSurgeriesCurrentMonth', 'totalSurgeriesLastMonth'));
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

    // Implementing the store method
    public function store(Request $request)
    {
        try {
            // Validate the incoming request data
            Log::info('Datos recibidos para la creación de cirugía: ', $request->all());
            $validatedData = $request->validate([
                'fecha' => 'required|date',
                'hora' => 'required|date_format:H:i',
                'institucion_id' => 'required|exists:instituciones,id',
                'medico_id' => 'required|exists:medicos,id',
                'instrumentista_id' => 'required|exists:instrumentistas,id',
                'equipo_id' => 'required|exists:equipos,id',
                'tipo_cirugia' => 'required|string|max:255',
                'estado' => 'required|string',
                'duracion_estimada' => 'nullable|integer',
                'prioridad' => 'required|string',
                'observaciones' => 'nullable|string',
            ]);

            // Create a new Cirugia record
            $cirugia = Cirugia::create($validatedData);
            Log::info('Cirugía creada exitosamente: ', $cirugia->toArray());

            // Return a success response
            return redirect()->route('modulo.cirugias.index')->with('success', 'Cirugía creada correctamente.');
        } catch (Throwable $e) {
            Log::error('Error en CirugiaController@store: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return back()->withInput()->with('error', 'Error al crear la cirugía: ' . $e->getMessage());
        }
    }
}
