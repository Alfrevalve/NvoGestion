<?php

namespace Modules\Cirugias\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected array $middleware = [
        // \Modules\Cirugias\Http\Middleware\TrustHosts::class,  // Descomentar si es necesario
        \Modules\Cirugias\Http\Middleware\TrustProxies::class,
        \Illuminate\Http\Middleware\HandleCors::class,
        \Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \Modules\Cirugias\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected array $middlewareGroups = [
        'web' => [
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
        'api' => [
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * Estos middleware se asignan a rutas individuales o grupos de rutas.
     *
     * @var array
     */
    protected array $routeMiddleware = [
        'auth'         => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic'   => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'cache.headers'=> \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can'          => \Illuminate\Auth\Middleware\Authorize::class,
        'guest'        => \Modules\Cirugias\Http\Middleware\RedirectIfAuthenticated::class,
        'signed'       => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle'     => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified'     => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
    ];
}
