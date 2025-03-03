<?php

namespace Modules\Cirugias;

use Illuminate\Support\ServiceProvider;
use Modules\Cirugias\Providers\RouteServiceProvider;

class Module extends ServiceProvider
{
    protected $moduleName = 'Cirugias';
    protected $moduleNameLower = 'cirugias';

    public function boot()
    {
        $this->registerViews();
        $this->loadMigrationsFrom(base_path('Modules/Cirugias/Database/Migrations'));
    }

    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }

    public function registerViews()
    {
        $sourcePath = base_path('Modules/Cirugias/Resources/views');
        $this->loadViewsFrom($sourcePath, 'cirugias');
    }

    public function provides()
    {
        return [];
    }
}
