<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     * These middleware are run during every request to your application.
     *
     * @var array<int, class-string|string>
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class,
        // \App\Http\Middleware\SecurityHeadersMiddleware::class, // Commenting out for testing

        \App\Http\Middleware\TrustProxies::class,
        \Illuminate\Http\Middleware\HandleCors::class,
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \App\Http\Middleware\SecurityHeadersMiddleware::class, // Implementa cabeceras de seguridad HTTP
    ];

    /**
     * The application's route middleware groups.
     * Agrupación de middleware para diferentes contextos de aplicación.
     *
     * @var array<string, array<int, class-string|string>>
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\Http\Middleware\LogUserActivity::class, // Registra actividad de usuarios
            \App\Http\Middleware\LocaleMiddleware::class, // Gestión de idiomas de la aplicación
        ],

        'api' => [
            // Removed Sanctum middleware as it's not installed
            \Illuminate\Routing\Middleware\ThrottleRequests::class.':api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\Http\Middleware\ApiResponseFormat::class, // Estandariza el formato de respuestas API
        ],

        // Grupo específico para rutas administrativas
        'admin' => [
            'web', // Incluye todo el grupo web
            'auth', // Requiere autenticación
            'verified', // Requiere email verificado
            'role:admin|super-admin', // Requiere rol de administrador
            'active.user', // Verifica que el usuario esté activo
            \App\Http\Middleware\AdminActivityLog::class, // Registro detallado de actividades administrativas
        ],

        // Grupo para módulo de administración
        'modulo-admin' => [
            'web',
            'auth',
            'verified',
            'module.access:administracion',
            'audit', // Auditoría detallada para operaciones administrativas
        ],

        // Grupo para módulo de almacén
        'modulo-almacen' => [
            'web',
            'auth',
            'module.access:almacen',
        ],

        // Grupo para módulo de despacho
        'modulo-despacho' => [
            'web',
            'auth',
            'module.access:despacho',
        ],
    ];

    /**
     * The application's middleware aliases.
     * Aliases que pueden ser asignados a rutas y controladores.
     *
     * @var array<string, class-string|string>
     */
    protected $middlewareAliases = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'precognitive' => \Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class, // Para URLs firmadas
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'role' => \Spatie\Permission\Middlewares\RoleMiddleware::class,
        'permission' => \Spatie\Permission\Middlewares\PermissionMiddleware::class,
        'role_or_permission' => \Spatie\Permission\Middlewares\RoleOrPermissionMiddleware::class,

        // Middleware adicionales personalizados
        'module.access' => \App\Http\Middleware\ModuleAccessMiddleware::class, // Control de acceso a módulos
        'active.user' => \App\Http\Middleware\EnsureUserIsActive::class, // Verifica usuario activo
        'cache' => \App\Http\Middleware\CacheResponseMiddleware::class, // Caché de respuestas
        'audit' => \App\Http\Middleware\AuditLogMiddleware::class, // Auditoría detallada
        'maintenance.bypass' => \App\Http\Middleware\BypassMaintenanceMode::class, // Bypass modo mantenimiento
        'last.seen' => \App\Http\Middleware\UpdateLastSeen::class, // Actualiza última vez visto
        'check.permissions' => \App\Http\Middleware\CheckPermissionsMiddleware::class, // Verificación dinámica de permisos
    ];

    /**
     * The priority-sorted list of middleware.
     * Forces non-global middleware to always be in the given order.
     *
     * @var string[]
     */
    protected $middlewarePriority = [
        \Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests::class,
        \Illuminate\Cookie\Middleware\EncryptCookies::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \Illuminate\Contracts\Auth\Middleware\AuthenticatesRequests::class,
        \Illuminate\Routing\Middleware\ThrottleRequests::class,
        \Illuminate\Routing\Middleware\ThrottleRequestsWithRedis::class,
        \Illuminate\Contracts\Session\Middleware\AuthenticatesSessions::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
        \Illuminate\Auth\Middleware\Authorize::class,
        \App\Http\Middleware\SecurityHeadersMiddleware::class, // Alta prioridad para cabeceras de seguridad
        \App\Http\Middleware\EnsureUserIsActive::class, // Verificar usuario activo temprano
        \App\Http\Middleware\CheckPermissionsMiddleware::class, // Verificar permisos antes de procesar
    ];
}
