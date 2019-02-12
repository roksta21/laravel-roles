<?php

namespace Roksta\Permit;

use Illuminate\Support\ServiceProvider;
use Roksta\Permit\Commands\PermissionsCommands;

class PermissionsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

        /*
        * Import routes
        */
        $this->loadRoutesFrom(__DIR__.'/../routes/routes.php');

        /*
        * Register console commands
        */
        if ($this->app->runningInConsole()) {
            /*
            * Copy files
            */
            $this->publishes([
                // Config File
                __DIR__.'/../config/permissions.php' => config_path('permissions.php'),
                // Views
                __DIR__.'/../views' => resource_path('views/vendor/roksta')
            ]);

            /*
            * Run migrations
            */
            $this->loadMigrationsFrom(__DIR__.'/../migrations');

            /*
            * Register Commands
            */
            $this->commands([
                PermissionsCommands::class,
            ]);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // $this->app->bind();
        
    }
}