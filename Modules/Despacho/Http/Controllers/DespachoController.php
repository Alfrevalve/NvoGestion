<?php

namespace Modules\Despacho\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Despacho\Models\Despacho;

class DespachoController extends Controller
{
    public function index()
    {
        $despachos = Despacho::all();
        return view('despacho.index', compact('despachos'));
    }

    public function create()
    {
        return view('despacho.create');
    }

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'articulo_id' => 'required|integer',
            'cantidad' => 'required|integer',
            'destino' => 'required|string|max:255',
            'fecha_despacho' => 'required|date',
        ]);

        // Create a new Despacho
        Despacho::create($request->all());

        return redirect()->route('modulo.despacho.index')->with('success', 'Despacho registrado con éxito.');
    }

    public function edit($id)
    {
        $despacho = Despacho::findOrFail($id);
        return view('despacho.edit', compact('despacho'));
    }

    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'articulo_id' => 'required|integer',
            'cantidad' => 'required|integer',
            'destino' => 'required|string|max:255',
            'fecha_despacho' => 'required|date',
        ]);

        // Update the Despacho
        $despacho = Despacho::findOrFail($id);
        $despacho->update($request->all());

        return redirect()->route('modulo.despacho.index')->with('success', 'Despacho actualizado con éxito.');
    }
}
