<?php

namespace Modules\Administracion\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Administracion\Models\User;

class AdministracionController extends Controller
{
    public function index()
    {
        $usuarios = User::all();
        return view('administracion.index', compact('usuarios'));
    }

    public function create()
    {
        return view('administracion.create');
    }

public function store(Request $request)
{
    // Validate the request
    \Log::info('Store method called with request:', $request->all());
    $request->validate([
        'nombre' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8',
        'rol' => 'required|string',
    ]);


        // Create a new User
        User::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'rol' => $request->rol,
        ]);

        return redirect()->route('modulo.administracion.index')->with('success', 'Usuario registrado con éxito.');
    }

    public function edit($id)
    {
        $usuario = User::findOrFail($id);
        return view('administracion.edit', compact('usuario'));
    }

public function update(Request $request, $id)
{
    // Validate the request
    \Log::info('Update method called for user ID ' . $id . ' with request:', $request->all());
    $request->validate([
        'nombre' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $id,
        'rol' => 'required|string',
    ]);


        // Update the User
        $usuario = User::findOrFail($id);
        $usuario->update($request->only('nombre', 'email', 'rol'));

        return redirect()->route('modulo.administracion.index')->with('success', 'Usuario actualizado con éxito.');
    }
}
