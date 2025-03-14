<?php

namespace Modules\Cirugias\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

/**
 * Route Service Provider para el módulo Cirugias.
 *
 * Este proveedor de rutas carga las rutas web y API definidas en el módulo.
 */
class RouteServiceProvider extends ServiceProvider
{
    /**
     * El namespace para los controladores del módulo.
     *
     * @var string
     */
    protected $moduleNamespace = 'Modules\Cirugias\Http\Controllers';

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        parent::boot();
    }

    /**
     * Define las rutas del módulo.
     *
     * @return void
     */
    public function map(): void
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
    }

    /**
     * Define las rutas web para el módulo Cirugias.
     *
     * Estas rutas utilizan el middleware "web" y se cargan desde:
     * module_path('Cirugias', '/Routes/web.php')
     *
     * @return void
     */
    protected function mapWebRoutes(): void
    {
        Route::middleware('web')
            ->group(module_path('Cirugias', '/Routes/web.php'));
    }

    /**
     * Define las rutas API para el módulo Cirugias.
     *
     * Estas rutas utilizan el middleware "api", se prefixean con "api" y se cargan desde:
     * module_path('Cirugias', '/Routes/api.php')
     *
     * @return void
     */
    protected function mapApiRoutes(): void
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->moduleNamespace)
            ->group(module_path('Cirugias', '/Routes/api.php'));
    }
}
