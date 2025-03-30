<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DespachoController extends Controller
{
    public function index()
    {
        // Lógica para mostrar la lista de despachos
        \Log::info('Accediendo a la ruta despacho.index'); // Debugging information
        return view('despacho.index'); // Asegúrate de que esta vista exista
    }

    public function create()
    {
        // Lógica para mostrar el formulario de creación de despacho
        return view('despacho.create'); // Asegúrate de que esta vista exista
    }

    public function store(Request $request)
    {
        // Lógica para almacenar un nuevo despacho
        // Validar y guardar los datos del despacho
    }
}
