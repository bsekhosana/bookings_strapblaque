<?php

namespace App\Providers;

use Laravel\Horizon\HorizonApplicationServiceProvider;

class HorizonServiceProvider extends HorizonApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        parent::boot();

        // Horizon::routeSmsNotificationsTo('15556667777');
        // Horizon::routeMailNotificationsTo('example@example.com');
        // Horizon::routeSlackNotificationsTo('slack-webhook-url', '#channel');
    }

    /**
     * Register the Horizon gate.
     * This gate determines who can access Horizon in non-local environments.
     */
    protected function gate(): void
    {
        \Gate::define('viewHorizon', function ($user) {
            /** @var \App\Models\Admin $user */
            return $user->isSuperAdmin();
        });
    }
}
