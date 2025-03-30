<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Cirugia;

class CirugiasController extends Controller
{
    public function index()
    {
        // Obtener todas las cirugías
        $cirugias = Cirugia::orderBy('fecha', 'desc')->get();
        
        // Pasar las cirugías a la vista
        return view('modulo.cirugias.index', compact('cirugias'));
    }

    public function calendario()
    {
        // Obtener las cirugías desde la base de datos
        $eventos = Cirugia::all()->map(function($cirugia) {
            // Crear una fecha y hora de inicio combinando fecha y hora
            $fecha_hora_inicio = $cirugia->fecha . ' ' . $cirugia->hora;
            // Calcular fecha y hora de fin (usando duración estimada o por defecto 60 minutos)
            $duracion = $cirugia->duracion_estimada ?? 60;
            $fecha_hora_fin = date('Y-m-d H:i:s', strtotime($fecha_hora_inicio . ' + ' . $duracion . ' minutes'));
            
            return [
                'title' => $cirugia->tipo_cirugia . ' - ' . $cirugia->medico->nombre,
                'start' => $fecha_hora_inicio,
                'end' => $fecha_hora_fin,
                'color' => $this->getColorByEstado($cirugia->estado),
            ];
        });

        // Pasar los eventos a la vista
        return view('modulo.cirugias.calendario', compact('eventos'));
    }
    /**
     * Obtiene un color según el estado de la cirugía
     */
    private function getColorByEstado($estado)
    {
        switch ($estado) {
            case 'pendiente':
                return '#ffc107'; // Amarillo
            case 'programada':
                return '#17a2b8'; // Azul
            case 'en proceso':
                return '#007bff'; // Azul primario
            case 'finalizada':
                return '#28a745'; // Verde
            case 'cancelada':
                return '#dc3545'; // Rojo
            default:
                return '#6c757d'; // Gris
        }
    }
}
