<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsActive
{
    /**
     * Verifica que el usuario autenticado tenga una cuenta activa.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && !Auth::user()->is_active) {
            // Cerrar sesión del usuario
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tu cuenta ha sido desactivada. Contacta al administrador.',
                    'errors' => ['account' => ['Cuenta desactivada']]
                ], 403);
            }

            return redirect()->route('login')
                ->with('error', 'Tu cuenta ha sido desactivada. Por favor, contacta al administrador del sistema.');
        }

        return $next($request);
    }
}
