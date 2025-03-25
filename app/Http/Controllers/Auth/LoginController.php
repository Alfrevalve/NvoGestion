<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Muestra el formulario de login.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Procesa el intento de login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([ // Valida las credenciales
            'email' => ['required', 'email'], // El email es requerido y debe ser válido
            'password' => ['required'], // La contraseña es requerida
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard')); // Redirige a la página de destino
        }

        return back()->withErrors([ // Devuelve errores si las credenciales son incorrectas
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.', // Mensaje de error
        ])->withInput($request->only('email', 'remember')); // Mantiene el email y la opción de recordar
    }

    /**
     * Cierra la sesión del usuario.
     */
    public function logout(Request $request)
    {
        Auth::logout(); // Cierra la sesión

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login'); // Redirige a la página de inicio de sesión
    }
}
