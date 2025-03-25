<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ModuleAccessMiddleware
{
    /**
     * Verifica que el usuario tenga acceso al módulo solicitado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $module  Nombre del módulo (administracion, almacen, despacho, etc.)
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $module): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Verificar acceso de superadmin (acceso a todos los módulos)
        if ($user->hasRole('super-admin')) {
            return $next($request);
        }

        // Mapeo de módulos a permisos requeridos
        $modulePermissions = [
            'administracion' => 'acceso-modulo-administracion',
            'almacen' => 'acceso-modulo-almacen',
            'despacho' => 'acceso-modulo-despacho',
            // Añadir otros módulos aquí
        ];

        // Obtener el permiso necesario para el módulo
        $requiredPermission = $modulePermissions[$module] ?? null;

        if (!$requiredPermission) {
            abort(500, 'Configuración de módulo inválida');
        }

        // Verificar si el usuario tiene el permiso requerido
        if (!$user->hasPermissionTo($requiredPermission)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No tienes acceso a este módulo',
                    'errors' => ['permissions' => ['Acceso denegado al módulo ' . $module]]
                ], 403);
            }

            // Redirigir a la página principal con mensaje de error
            return redirect()->route('dashboard')
                ->with('error', 'No tienes acceso al módulo de ' . ucfirst($module));
        }

        return $next($request);
    }
}
