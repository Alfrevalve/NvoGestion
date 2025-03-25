<?php

namespace Modules\Almacen\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Almacen\Models\Articulo;

class AlmacenController extends Controller
{
    public function index()
    {
        $articulos = Articulo::all();
        return view('almacen.index', compact('articulos'));
    }

    public function create()
    {
        return view('almacen.create');
    }

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'nombre' => 'required|string|max:255',
            'cantidad' => 'required|integer',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric',
        ]);

        // Create a new Articulo
        Articulo::create($request->all());

        return redirect()->route('modulo.almacen.index')->with('success', 'Artículo registrado con éxito.');
    }

    public function edit($id)
    {
        $articulo = Articulo::findOrFail($id);
        return view('almacen.edit', compact('articulo'));
    }

    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'nombre' => 'required|string|max:255',
            'cantidad' => 'required|integer',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric',
        ]);

        // Update the Articulo
        $articulo = Articulo::findOrFail($id);
        $articulo->update($request->all());

        return redirect()->route('modulo.almacen.index')->with('success', 'Artículo actualizado con éxito.');
    }
}
