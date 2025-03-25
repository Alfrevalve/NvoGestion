<?php

namespace Modules\Cirugias\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Cirugias\Exceptions\CirugiaExceptionHandler;
use Illuminate\Contracts\Debug\ExceptionHandler;

class CirugiasServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Register the custom exception handler using singleton
        $this->app->singleton(ExceptionHandler::class, CirugiaExceptionHandler::class);
    }

    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'cirugias');
        // Bootstrapping code can go here
    }
}
