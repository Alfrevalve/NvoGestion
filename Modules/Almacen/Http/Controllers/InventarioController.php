<?php

namespace Modules\Almacen\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Almacen\Models\Inventario;
use App\Http\Controllers\Controller;

class InventarioController extends Controller
{
    public function index()
    {
        $inventarios = Inventario::orderBy('nombre')->paginate(10);
        return view('almacen.index', compact('inventarios'));
    }

    public function create()
    {
        return view('almacen.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'cantidad' => 'required|integer|min:0',
            'estado' => 'required|string|in:disponible,agotado,reservado',
            'ubicacion' => 'nullable|string|max:255',
            'tipo' => 'nullable|string|max:100',
        ]);

        Inventario::create($validated);
        return redirect()->route('almacen.index')->with('success', 'Ítem de inventario creado correctamente');
    }

    public function edit(Inventario $inventario)
    {
        return view('almacen.edit', compact('inventario'));
    }

    public function update(Request $request, Inventario $inventario)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'cantidad' => 'required|integer|min:0',
            'estado' => 'required|string|in:disponible,agotado,reservado',
            'ubicacion' => 'nullable|string|max:255',
            'tipo' => 'nullable|string|max:100',
        ]);

        $inventario->update($validated);
        return redirect()->route('almacen.index')->with('success', 'Ítem de inventario actualizado correctamente');
    }

    public function destroy(Inventario $inventario)
    {
        $inventario->delete();
        return redirect()->route('almacen.index')->with('success', 'Ítem de inventario eliminado correctamente');
    }

    public function show(Inventario $inventario)
    {
        return view('almacen.show', compact('inventario'));
    }
}
