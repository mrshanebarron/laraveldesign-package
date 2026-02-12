<?php

namespace MrShaneBarron\LaravelDesign;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use MrShaneBarron\LaravelDesign\Console\InstallCommand;
use MrShaneBarron\LaravelDesign\Livewire\PageBuilder;

class LaravelDesignServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/laraveldesign.php',
            'laraveldesign'
        );
    }

    public function boot(): void
    {
        // Load migrations
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        // Load views
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'laraveldesign');

        // Load routes
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        // Register Livewire components
        if (class_exists(Livewire::class)) {
            Livewire::component('laraveldesign::page-builder', PageBuilder::class);
        }

        if ($this->app->runningInConsole()) {
            // Register commands
            $this->commands([
                InstallCommand::class,
            ]);

            // Publish config
            $this->publishes([
                __DIR__ . '/../config/laraveldesign.php' => config_path('laraveldesign.php'),
            ], 'laraveldesign-config');

            // Publish migrations
            $this->publishes([
                __DIR__ . '/../database/migrations' => database_path('migrations'),
            ], 'laraveldesign-migrations');

            // Publish views
            $this->publishes([
                __DIR__ . '/../resources/views' => resource_path('views/vendor/laraveldesign'),
            ], 'laraveldesign-views');

            // Publish assets
            $this->publishes([
                __DIR__ . '/../resources/assets' => public_path('vendor/laraveldesign'),
            ], 'laraveldesign-assets');
        }
    }
}
