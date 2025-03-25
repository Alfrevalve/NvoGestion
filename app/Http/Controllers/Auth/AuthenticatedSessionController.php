<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Muestra la vista de inicio de sesión.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Maneja una solicitud de autenticación entrante.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate(); // Autentica al usuario

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME); // Redirige a la página de inicio
    }

    /**
     * Destruye una sesión autenticada.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout(); // Cierra la sesión del usuario

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/'); // Redirige a la página principal
    }
}
