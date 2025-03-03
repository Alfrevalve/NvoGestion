<?php

namespace Modules\Cirugias\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Modules\Cirugias\Models\ReporteCirugia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class ReporteCirugiaController extends Controller
{
    /**
     * Muestra el listado de reportes de cirugías.
     */
    public function index()
    {
        try {
            $reportes = ReporteCirugia::with(['cirugia', 'instrumentista', 'medico', 'institucion'])->get();
            return view('cirugias::reportes.index', compact('reportes'));
        } catch (Throwable $e) {
            Log::error('Error en ReporteCirugiaController@index: ' . $e->getMessage());
            return back()->with('error', 'Error al cargar los reportes de cirugía.');
        }
    }

    /**
     * Muestra el formulario para crear un nuevo reporte de cirugía.
     */
    public function create()
    {
        try {
            return view('cirugias::reportes.create');
        } catch (Throwable $e) {
            Log::error('Error en ReporteCirugiaController@create: ' . $e->getMessage());
            return back()->with('error', 'Error al cargar el formulario de creación del reporte.');
        }
    }

    /**
     * Almacena un nuevo reporte de cirugía.
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->validationRules(), $this->validationMessages());

        // Si se sube un archivo, lo almacenamos y actualizamos el campo
        if ($request->hasFile('archivo_hoja_consumo')) {
            $filePath = $request->file('archivo_hoja_consumo')->store('reportes', 'public');
            $validated['archivo_hoja_consumo'] = $filePath;
        }

        try {
            DB::transaction(function () use ($validated) {
                ReporteCirugia::create($validated);
            });
            return redirect()->route('cirugias.reportes.index')
                ->with('success', 'Reporte de cirugía creado exitosamente.');
        } catch (Throwable $e) {
            Log::error('Error en ReporteCirugiaController@store: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Error al crear el reporte de cirugía.');
        }
    }

    /**
     * Reglas de validación para crear un reporte.
     *
     * @return array
     */
    protected function validationRules(): array
    {
        return [
            'cirugia_id'           => 'required|exists:cirugias,id',
            'instrumentista_id'    => 'required|exists:instrumentistas,id',
            'medico_id'            => 'required|exists:medicos,id',
            'institucion_id'       => 'required|exists:instituciones,id',
            'sistema'              => 'required|string',
            'hoja_consumo'         => 'required|in:Si,No',
            'hora_programada'      => 'required|date_format:H:i',
            'hora_inicio'          => 'required|date_format:H:i',
            'hora_fin'             => 'required|date_format:H:i',
            'archivo_hoja_consumo' => 'nullable|file|mimes:jpg,jpeg,png',
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
            'cirugia_id.required'           => 'La cirugía es obligatoria.',
            'cirugia_id.exists'             => 'La cirugía seleccionada no es válida.',
            'instrumentista_id.required'    => 'El instrumentista es obligatorio.',
            'instrumentista_id.exists'      => 'El instrumentista seleccionado no es válido.',
            'medico_id.required'            => 'El médico es obligatorio.',
            'medico_id.exists'              => 'El médico seleccionado no es válido.',
            'institucion_id.required'       => 'La institución es obligatoria.',
            'institucion_id.exists'         => 'La institución seleccionada no es válida.',
            'sistema.required'              => 'El sistema es obligatorio.',
            'hoja_consumo.required'         => 'La hoja de consumo es obligatoria.',
            'hoja_consumo.in'               => 'La hoja de consumo debe ser Si o No.',
            'hora_programada.required'      => 'La hora programada es obligatoria.',
            'hora_programada.date_format'   => 'La hora programada debe tener el formato HH:MM.',
            'hora_inicio.required'          => 'La hora de inicio es obligatoria.',
            'hora_inicio.date_format'       => 'La hora de inicio debe tener el formato HH:MM.',
            'hora_fin.required'             => 'La hora de fin es obligatoria.',
            'hora_fin.date_format'          => 'La hora de fin debe tener el formato HH:MM.',
            'archivo_hoja_consumo.mimes'    => 'El archivo debe ser de tipo: jpg, jpeg o png.',
        ];
    }
}
