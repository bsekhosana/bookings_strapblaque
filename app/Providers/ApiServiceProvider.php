<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ApiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(\App\Services\ExampleAPI::class, function ($app) {
            return new \App\Services\ApiClient($app['config']['services']['example_api']);
        });

        //$this->app->singleton(\App\Services\AnotherAPI::class, function ($app) {
        //    return new \App\Services\ApiClient($app['config']['services']['another_api']);
        //});
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
