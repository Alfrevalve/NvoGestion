<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Cirugia;

class CirugiasController extends Controller
{
    public function index()
    {
        // Your logic for displaying cirugias
        return view('modulo.cirugias.index');
    }

    public function calendario()
    {
        // Obtener las cirugías desde la base de datos
        $eventos = Cirugia::all()->map(function($cirugia) {
            return [
                'title' => $cirugia->nombre, // Asegúrate de que 'nombre' sea el campo correcto
                'start' => $cirugia->fecha_inicio ? $cirugia->fecha_inicio->format('Y-m-d H:i:s') : null, // Asegúrate de que 'fecha_inicio' sea el campo correcto
                'end' => $cirugia->fecha_fin ? $cirugia->fecha_fin->format('Y-m-d H:i:s') : null, // Asegúrate de que 'fecha_fin' sea el campo correcto
            ];
        });

        // Pasar los eventos a la vista
        return view('modulo.cirugias.calendario', compact('eventos'));
    }
}
