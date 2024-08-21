<?php

namespace Emotality\CRUD;

use Illuminate\Support\ServiceProvider;

class CrudServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                \Emotality\CRUD\Commands\Crud::class,
                \Emotality\CRUD\Commands\CrudController::class,
                \Emotality\CRUD\Commands\CrudObserver::class,
                \Emotality\CRUD\Commands\CrudPolicy::class,
                \Emotality\CRUD\Commands\CrudRequests::class,
                \Emotality\CRUD\Commands\CrudViews::class,
            ]);
        }
    }
}
