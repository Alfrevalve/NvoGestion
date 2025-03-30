<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Cirugias\Models\ReporteCirugia; // Import the ReporteCirugia model from the correct namespace
use Carbon\Carbon; // Ensure Carbon is imported for date handling

class ReporteCirugiaController extends Controller
{
    public function index()
    {
        // Display a list of reports
        return view('cirugias.reports.index');
    }

    public function show($id)
    {
        // Display a specific report based on the ID
        $report = ReporteCirugia::findOrFail($id);
        return view('cirugias.reports.show', compact('report'));
    }

    public function generate(Request $request)
    {
        // Generate a report based on user input
        $validated = $request->validate([
            'fecha_inicio' => 'required|string', // Change to string for initial cleaning
            'fecha_fin' => 'required|string',     // Change to string for initial cleaning
            'tipo_cirugia' => 'nullable|string',
        'estado' => 'nullable|string',
        'prioridad' => 'nullable|string',
        ]);

        // Clean the input dates before parsing with Carbon
        $validated['fecha_inicio'] = trim($validated['fecha_inicio']);
        $validated['fecha_fin'] = trim($validated['fecha_fin']);

        // Logic to generate the report based on the validated input
        $reports = ReporteCirugia::whereBetween('fecha', [
            Carbon::parse($validated['fecha_inicio']),
            Carbon::parse($validated['fecha_fin'])
        ]);

        if (!empty($validated['estado'])) {
            $reports->where('estado', $validated['estado']);
        }

        if (!empty($validated['prioridad'])) {
            $reports->where('prioridad', $validated['prioridad']);
        }

        if (!empty($validated['tipo_cirugia'])) {
            $reports->where('tipo_cirugia', $validated['tipo_cirugia']);
        }

        if (!empty($validated['tipo_cirugia'])) {
            $reports->where('tipo_cirugia', $validated['tipo_cirugia']);
        }

        $reports = $reports->get();

        return view('cirugias.reports.generated', compact('reports'));
    }
}
