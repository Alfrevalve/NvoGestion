<?php

namespace Modules\Cirugias;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Modules\Cirugias\Console\Commands\GenerateReportCommand;
use Modules\Cirugias\Providers\EventServiceProvider;
use Modules\Cirugias\Providers\RouteServiceProvider;
use Modules\Cirugias\View\Components\CirugiaCard;
use Modules\Cirugias\View\Components\ProgramacionCalendar;

/**
 * Clase principal del módulo de Cirugías
 *
 * Este módulo permite gestionar el proceso completo de cirugías en un entorno médico,
 * incluyendo programación, seguimiento, control de insumos y generación de reportes.
 */
class Module extends ServiceProvider implements DeferrableProvider
{
    /**
     * Nombre del módulo
     *
     * @var string
     */
    protected $moduleName = 'Cirugias';

    /**
     * Nombre del módulo en minúsculas
     *
     * @var string
     */
    protected $moduleNameLower = 'cirugias';

    /**
     * El directorio raíz del módulo
     *
     * @var string
     */
    protected $moduleRoot;

    /**
     * Constructor del servicio
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        parent::__construct($app);
        $this->moduleRoot = base_path('Modules/' . $this->moduleName);
    }

    /**
     * Registra los servicios del módulo en la aplicación Laravel
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(EventServiceProvider::class);

        // Registro del archivo de configuración
        $this->mergeConfigFrom(
            $this->moduleRoot . '/Config/config.php', $this->moduleNameLower
        );

        // Registrar bindings personalizados al contenedor
        $this->app->bind(
            'Modules\Cirugias\Contracts\RealTimeTrackingInterface',
            'Modules\Cirugias\Services\RealTimeTrackingService'
        );
        $this->registerBindings();
    }

    /**
     * Inicia los servicios del módulo
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerViews();
        $this->registerFactories();
        $this->registerCommands();
        $this->registerMigrations();
        $this->registerBladeComponents();
        $this->registerPolicies();
        $this->loadMigrationsFrom($this->moduleRoot . '/Database/Migrations');

        // Publicar los recursos del módulo cuando se ejecuta vendor:publish
        $this->publishes([
            $this->moduleRoot . '/Config/config.php' => config_path($this->moduleNameLower . '.php'),
        ], $this->moduleNameLower . '-config');

        $this->publishes([
            $this->moduleRoot . '/Resources/assets' => public_path('modules/' . $this->moduleNameLower),
        ], $this->moduleNameLower . '-assets');

        $this->publishes([
            $this->moduleRoot . '/Database/Seeders' => database_path('seeders/modules/' . $this->moduleNameLower),
        ], $this->moduleNameLower . '-seeders');
    }

    /**
     * Registra las vistas del módulo
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);

        $sourcePath = $this->moduleRoot . '/Resources/views';

        // Carga vistas desde el directorio publicado si estamos en producción
        if ($this->app->environment('production') && is_dir($viewPath)) {
            $this->loadViewsFrom($viewPath, $this->moduleNameLower);
        }

        // Carga vistas desde el directorio del módulo en otros entornos
        $this->loadViewsFrom($sourcePath, $this->moduleNameLower);

        // Permite publicar las vistas para personalización
        $this->publishes([
            $sourcePath => $viewPath
        ], $this->moduleNameLower . '-views');
    }

    /**
     * Registra las traducciones del módulo
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/' . $this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
        } else {
            $this->loadTranslationsFrom($this->moduleRoot . '/Resources/lang', $this->moduleNameLower);
        }

        // Permite publicar los archivos de traducción
        $this->publishes([
            $this->moduleRoot . '/Resources/lang' => $langPath,
        ], $this->moduleNameLower . '-translations');
    }

    /**
     * Registra las factories para pruebas del módulo
     *
     * @return void
     */
    public function registerFactories()
    {
        if ($this->app->environment('testing') || $this->app->environment('local')) {
            $this->app->make(Factory::class)->load($this->moduleRoot . '/Database/factories');
        }
    }

    /**
     * Registra los comandos artisan proporcionados por el módulo
     *
     * @return void
     */
    public function registerCommands()
    {
        $this->commands([
            GenerateReportCommand::class,
            // Añadir aquí otros comandos
        ]);
    }

    /**
     * Registra las migraciones del módulo
     *
     * @return void
     */
    public function registerMigrations()
    {
        // Registrar un publicador para migraciones
        $this->publishes([
            $this->moduleRoot . '/Database/Migrations' => database_path('migrations/modules/' . $this->moduleNameLower),
        ], $this->moduleNameLower . '-migrations');
    }

    /**
     * Registra los componentes Blade del módulo
     *
     * @return void
     */
    public function registerBladeComponents()
    {
        Blade::componentNamespace('Modules\\Cirugias\\View\\Components', $this->moduleNameLower);

        // Registrar componentes específicos con alias personalizados
        Blade::component('cirugia-card', CirugiaCard::class);
        Blade::component('programacion-calendar', ProgramacionCalendar::class);
    }

    /**
     * Registra las políticas de autorización del módulo
     *
     * @return void
     */
    public function registerPolicies()
    {
        // Registrar automáticamente las políticas en el directorio Policies
        $policyPath = $this->moduleRoot . '/Policies';
        if (is_dir($policyPath)) {
            foreach (glob($policyPath . '/*.php') as $policyFile) {
                $policyClass = 'Modules\\' . $this->moduleName . '\\Policies\\' . basename($policyFile, '.php');
                $modelClass = 'Modules\\' . $this->moduleName . '\\Models\\' . Str::replaceLast('Policy', '', basename($policyFile, '.php'));

                if (class_exists($policyClass) && class_exists($modelClass)) {
                    $this->app->make('Illuminate\Contracts\Auth\Access\Gate')
                        ->policy($modelClass, $policyClass);
                }
            }
        }
    }

    /**
     * Registra bindings personalizados en el contenedor IoC
     *
     * @return void
     */
    protected function registerBindings()
    {
        // Registro de interfaces con sus implementaciones
        $this->app->bind(
            'Modules\Cirugias\Contracts\CirugiaRepositoryInterface',
            'Modules\Cirugias\Repositories\CirugiaRepository'
        );

        $this->app->bind(
            'Modules\Cirugias\Contracts\ProgramacionServiceInterface',
            'Modules\Cirugias\Services\ProgramacionService'
        );

        // Singleton para servicios que deben mantenerse a lo largo de la solicitud
        $this->app->singleton('cirugia.manager', function ($app) {
            return new \Modules\Cirugias\Services\CirugiaManager();
        });
    }

    /**
     * Proporciona los servicios del proveedor.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'cirugia.manager',
            GenerateReportCommand::class
        ];
    }
}
