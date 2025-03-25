<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisterController extends Controller
{
    /**
     * Muestra el formulario de registro.
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Procesa el formulario de registro.
     */
    public function register(Request $request)
    {
        $request->validate([ // Valida los datos del formulario
            'name' => ['required', 'string', 'max:255'], // El nombre es requerido y debe ser una cadena
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'], // El email es requerido, debe ser único y válido
            'password' => ['required', 'confirmed', Rules\Password::defaults()], // La contraseña es requerida y debe ser confirmada
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Asignar rol básico de usuario.
        $user->assignRole('usuario');

        event(new Registered($user)); // Dispara el evento de registro.

        Auth::login($user); // Autentica al usuario.

        return redirect()->route('dashboard'); // Redirige a la página de destino.
    }
}
