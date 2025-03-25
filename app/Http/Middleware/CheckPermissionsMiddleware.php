<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class CheckPermissionsMiddleware
{
    /**
     * Maneja verificación dinámica de permisos basada en rutas y acciones.
     * Determina automáticamente los permisos necesarios según la ruta actual.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Siempre permitir acceso a super-admin
        if ($user->hasRole('super-admin')) {
            return $next($request);
        }

        // Obtener la ruta actual y determinar módulo, entidad y acción
        $routeName = Route::currentRouteName();

        if (!$routeName) {
            // Si la ruta no tiene nombre, permitir acceso (responsabilidad de otros middleware)
            return $next($request);
        }

        // Extraer módulo y acción de la ruta
        // Ejemplos: modulo.admin.users.index, modulo.almacen.proveedores.edit
        $routeParts = explode('.', $routeName);

        if (count($routeParts) < 3) {
            // Si la ruta no sigue el formato esperado, continuar
            return $next($request);
        }

        // Para rutas como 'modulo.admin.users.index'
        $module = $routeParts[1] ?? null; // 'admin'
        $entity = $routeParts[2] ?? null; // 'users'
        $action = $routeParts[3] ?? null; // 'index'

        if (!$module || !$entity || !$action) {
            return $next($request);
        }

        // Mapeo de acciones a verbos de permisos
        $actionToPermission = [
            'index' => 'listar',
            'show' => 'ver',
            'create' => 'crear',
            'store' => 'crear',
            'edit' => 'editar',
            'update' => 'editar',
            'destroy' => 'eliminar',
            'download' => 'descargar',
            'restore' => 'restaurar',
            'activate' => 'activar',
            'deactivate' => 'desactivar',
        ];

        // Convertir acción a verbo de permiso
        $permissionVerb = $actionToPermission[$action] ?? $action;

        // Construir el nombre del permiso (ej: listar-usuarios, editar-backups)
        $permissionName = $permissionVerb . '-' . $this->singularize($entity);

        // Verificar si el usuario tiene el permiso requerido
        if (!$user->hasPermissionTo($permissionName)) {
            // Verificar si es una solicitud AJAX/API
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No tienes permiso para realizar esta acción',
                    'errors' => ['permissions' => ['No tienes el permiso: ' . $permissionName]]
                ], 403);
            }

            // Redireccionar con mensaje de error para solicitudes web
            return redirect()->route('dashboard')
                ->with('error', 'No tienes permiso para ' . $permissionVerb . ' ' . $this->friendlyName($entity));
        }

        return $next($request);
    }

    /**
     * Convierte un nombre de entidad en plural a su forma singular
     *
     * @param string $word
     * @return string
     */
    private function singularize(string $word): string
    {
        // Reglas básicas de singularización en español
        $irregulars = [
            'roles' => 'rol',
            'permissions' => 'permiso',
            'users' => 'usuario',
            'backups' => 'backup',
            'configuraciones' => 'configuracion',
            'logs' => 'log',
            'proveedores' => 'proveedor',
            'categorias' => 'categoria',
            'movimientos' => 'movimiento',
            'conductores' => 'conductor',
            'despachos' => 'despacho',
            'entregas' => 'entrega',
            'rutas' => 'ruta',
            'vehiculos' => 'vehiculo',
            'zonas' => 'zona',
            'cirugias' => 'cirugia',
            'medicos' => 'medico',
            'instrumentistas' => 'instrumentista',
            'instituciones' => 'institucion',
            'equipos' => 'equipo',
            'materiales' => 'material',
        ];

        // Verificar si hay una conversión específica para esta palabra
        if (isset($irregulars[$word])) {
            return $irregulars[$word];
        }

        // Reglas generales de singularización en español
        if (substr($word, -1) === 's') {
            return substr($word, 0, -1);
        }

        // Si no se puede aplicar reglas, devolver la palabra original
        return $word;
    }

    /**
     * Convierte nombre técnico de entidad a un nombre amigable para mensajes
     *
     * @param string $entity
     * @return string
     */
    private function friendlyName(string $entity): string
    {
        $names = [
            'users' => 'usuarios',
            'roles' => 'roles',
            'permissions' => 'permisos',
            'backups' => 'copias de seguridad',
            'configuraciones' => 'configuraciones del sistema',
            'logs' => 'registros del sistema',
            'proveedores' => 'proveedores',
            'categorias' => 'categorías',
            'movimientos' => 'movimientos de inventario',
            'conductores' => 'conductores',
            'despachos' => 'despachos',
            'entregas' => 'entregas',
            'rutas' => 'rutas',
            'vehiculos' => 'vehículos',
            'zonas' => 'zonas',
            'cirugias' => 'cirugías',
            'medicos' => 'médicos',
            'instrumentistas' => 'instrumentistas',
            'instituciones' => 'instituciones',
            'equipos' => 'equipos',
            'materiales' => 'materiales',
        ];

        return $names[$entity] ?? $entity;
    }
}
