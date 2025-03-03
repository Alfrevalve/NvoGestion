<?php

namespace Modules\Cirugias\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Contracts\View\Factory as ViewFactory;

class CirugiasServiceProvider extends ServiceProvider
{
    /**
     * Nombre del módulo.
     *
     * @var string
     */
    protected string $moduleName = 'Cirugias';

    /**
     * Nombre del módulo en minúsculas.
     *
     * @var string
     */
    protected string $moduleNameLower = 'cirugias';

    /**
     * Registra los recursos y migraciones del módulo.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));
    }

    /**
     * Registra los proveedores de rutas del módulo.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Publica y fusiona la configuración del módulo.
     *
     * @return void
     */
    protected function registerConfig(): void
    {
        $configSource = module_path($this->moduleName, 'Config/config.php');
        $configDestination = config_path($this->moduleNameLower . '.php');

        $this->publishes([
            $configSource => $configDestination,
        ], 'config');

        $this->mergeConfigFrom($configSource, $this->moduleNameLower);
    }

    /**
     * Registra y publica las vistas del módulo.
     *
     * @return void
     */
    public function registerViews(): void
    {
        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);
        $sourcePath = module_path($this->moduleName, 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath,
        ], [$this->moduleNameLower . '-module-views', 'views']);

        $this->loadViewsFrom(
            array_merge($this->getPublishableViewPaths(), [$sourcePath]),
            $this->moduleNameLower
        );
    }

    /**
     * Registra las traducciones del módulo.
     *
     * @return void
     */
    public function registerTranslations(): void
    {
        $langPath = resource_path('lang/modules/' . $this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
        } else {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'Resources/lang'), $this->moduleNameLower);
        }
    }

    /**
     * Obtiene las rutas publicables de las vistas configuradas en el proyecto.
     *
     * @return array
     */
    private function getPublishableViewPaths(): array
    {
        $paths = [];
        /** @var ConfigRepository $config */
        $config = $this->app['config'];
        foreach ($config->get('view.paths') as $path) {
            if (is_dir($path . '/modules/' . $this->moduleNameLower)) {
                $paths[] = $path . '/modules/' . $this->moduleNameLower;
            }
        }
        return $paths;
    }
}
