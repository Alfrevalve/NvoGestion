<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class BypassMaintenanceMode extends PreventRequestsDuringMaintenance
{
    /**
     * The URIs that should be reachable while maintenance mode is enabled.
     *
     * @var array<int, string>
     */
    protected $except = [
        'login',
        'register',
        'forgot-password',
        'reset-password/*',
        // Add any other routes that should be accessible during maintenance
    ];

    /**
     * Permite que ciertos usuarios accedan durante el modo mantenimiento.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Si la aplicación no está en mantenimiento, proceder normalmente
        if (!$this->app->isDownForMaintenance()) {
            return $next($request);
        }

        // Verificar si hay un token de bypass en la cookie o URL
        $bypassToken = $request->cookie('maintenance_bypass') ?: $request->query('bypass_token');
        if ($bypassToken && $this->isValidBypassToken($bypassToken)) {
            return $next($request);
        }

        // Permitir a administradores y usuarios técnicos acceder durante mantenimiento
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->hasRole(['super-admin', 'admin', 'technical']) ||
                $user->hasPermissionTo('bypass-maintenance-mode')) {
                return $next($request);
            }
        }

        // Permitir acceso a rutas específicas (como la de login)
        if ($this->inExceptArray($request)) {
            return $next($request);
        }

        // Si no hay criterios de bypass, utilizar el comportamiento predeterminado
        return parent::handle($request, $next);
    }

    /**
     * Determina si un token de bypass es válido comparándolo con el token configurado.
     *
     * @param string $token
     * @return bool
     */
    protected function isValidBypassToken(string $token): bool
    {
        $validToken = config('app.maintenance_bypass_token');

        if (empty($validToken)) {
            return false;
        }

        return hash_equals($validToken, $token);
    }
}
