<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema; // Import Schema facade
use Illuminate\Support\Facades\Validator; // Import Validator facade
use Illuminate\Pagination\Paginator; // Import Paginator facade

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register any application services here
        // Example: $this->app->bind(Interface::class, Implementation::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Set a default string length for database schema
        Schema::defaultStringLength(191); // Ensure Schema is imported

        // Register a custom validation rule
        Validator::extend('custom_rule', function ($attribute, $value, $parameters, $validator) {
            // Custom validation logic
        });

        // Configure pagination
        Paginator::useBootstrap(); // Ensure Paginator is imported

        // Set up error reporting
        if ($this->app->environment('production')) {
            // Custom error reporting for production
        }
    }
}
