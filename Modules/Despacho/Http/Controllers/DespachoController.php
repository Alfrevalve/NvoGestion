<?php

namespace Modules\Despacho\Http\Controllers;

use App\Http\Controllers\Controller; // Importar la clase Controller correctamente


use Illuminate\Http\Request;
use Modules\Despacho\Models\Despacho;

class DespachoController extends Controller

{
    public function index()
    {
        // Display a list of dispatches
        return view('despacho.index');
    }

    public function create()
    {
        // Show form to create a new dispatch
        return view('despacho.create');
    }

    public function store(Request $request)
    {
        // Store a new dispatch
        $validated = $request->validate([
            'pedido_id' => 'required|integer|exists:pedidos,id',
            'estado' => 'required|string|in:pendiente,en_proceso,despachado,entregado,cancelado',
            'fecha_despacho' => 'required|date',
            'destinatario' => 'required|string|max:255',
            'direccion' => 'nullable|string|max:500',
            'observaciones' => 'nullable|string|max:1000',
        ]);

        Despacho::create($validated);
        return redirect()->route('despacho.index')->with('success', 'Despacho creado correctamente');
    }

    public function edit(Despacho $despacho)
    {
        // Show form to edit a dispatch
        return view('despacho.edit', compact('despacho'));
    }

    public function update(Request $request, Despacho $despacho)
    {
        // Update a dispatch
        $validated = $request->validate([
            'pedido_id' => 'required|integer|exists:pedidos,id',
            'estado' => 'required|string|in:pendiente,en_proceso,despachado,entregado,cancelado',
            'fecha_despacho' => 'required|date',
            'destinatario' => 'required|string|max:255',
            'direccion' => 'nullable|string|max:500',
            'observaciones' => 'nullable|string|max:1000',
        ]);

        $despacho->update($validated);
        return redirect()->route('despacho.index')->with('success', 'Despacho actualizado correctamente');
    }

    public function destroy(Despacho $despacho)
    {
        // Delete a dispatch
        $despacho->delete();
        return redirect()->route('despacho.index')->with('success', 'Despacho eliminado correctamente');
    }

    public function show(Despacho $despacho)
    {
        // Show details of a dispatch
        return view('despacho.show', compact('despacho'));
    }
}
