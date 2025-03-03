<?php

namespace Modules\Almacen\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AlmacenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('almacen::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('almacen::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación de datos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|max:50|unique:materiales,codigo',
            'cantidad' => 'required|integer|min:0',
            'cantidad_minima' => 'nullable|integer|min:0',
            'descripcion' => 'nullable|string',
            'ubicacion' => 'nullable|string|max:100',
            'proveedor' => 'nullable|string|max:100',
        ]);

        // Aquí iría la lógica para guardar en la base de datos
        // Por ahora solo redireccionamos con un mensaje de éxito
        
        return redirect()->route('almacen.index')
            ->with('success', 'Material creado exitosamente.');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('almacen::show', ['id' => $id]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('almacen::edit', ['id' => $id]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validación de datos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|max:50|unique:materiales,codigo,'.$id,
            'cantidad' => 'required|integer|min:0',
            'cantidad_minima' => 'nullable|integer|min:0',
            'descripcion' => 'nullable|string',
            'ubicacion' => 'nullable|string|max:100',
            'proveedor' => 'nullable|string|max:100',
        ]);

        // Aquí iría la lógica para actualizar en la base de datos
        // Por ahora solo redireccionamos con un mensaje de éxito
        
        return redirect()->route('almacen.index')
            ->with('success', 'Material actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Aquí iría la lógica para eliminar de la base de datos
        // Por ahora solo redireccionamos con un mensaje de éxito
        
        return redirect()->route('almacen.index')
            ->with('success', 'Material eliminado exitosamente.');
    }
}