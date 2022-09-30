<?php

namespace Ibis117\CrudActions;


use Ibis117\CrudActions\Commands\CreateActionCommand;
use Ibis117\CrudActions\Commands\RouteActionCommand;
use Ibis117\CrudActions\Commands\CrudActionCommand;
use Ibis117\CrudActions\Commands\DeleteActionCommand;
use Ibis117\CrudActions\Commands\ListActionCommand;
use Ibis117\CrudActions\Commands\ShowActionCommand;
use Ibis117\CrudActions\Commands\UpdateActionCommand;
use Illuminate\Support\ServiceProvider;

class CrudActionsServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'ibis117');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'ibis117');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/crud-actions.php', 'crud-actions');

        // Register the service the package provides.
        $this->app->singleton('crud-actions', function ($app) {
            return new CrudActions;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['crud-actions'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__ . '/../config/crud-actions.php' => config_path('crud-actions.php'),
        ], 'crud-actions.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/ibis117'),
        ], 'crud-actions.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/ibis117'),
        ], 'crud-actions.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/ibis117'),
        ], 'crud-actions.views');*/

        // Registering package commands.
        $this->commands([
            CrudActionCommand::class,
            ListActionCommand::class,
            CreateActionCommand::class,
            UpdateActionCommand::class,
            ShowActionCommand::class,
            DeleteActionCommand::class,
            RouteActionCommand::class
        ]);
    }
}
