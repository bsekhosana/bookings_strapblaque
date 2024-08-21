<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Laravel\Nova\Menu\Menu;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Nova::userMenu(function (Request $request, Menu $menu) {
            if ($request->user('admin')?->isSuperAdmin()) {
                $menu->append(
                    MenuItem::externalLink('Queue System', url(config('horizon.path')))->openInNewTab()
                );
            }

            return $menu;
        });

        Nova::footer(function ($request) {
            return \Blade::render('<p class="text-center"><a class="link-default" target="_blank" href="https://nova.laravel.com/releases">Laravel Nova</a> · v{!! $version !!}</p>', [
                'version' => Nova::version(),
            ]);
        });
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
            ->withAuthenticationRoutes()
            //->withPasswordResetRoutes()
            ->register();
    }

    /**
     * Register the Nova gate.
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        \Gate::define('viewNova', function ($user) {
            return $user->isAdmin();
        });
    }

    /**
     * Get the dashboards that should be listed in the Nova sidebar.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [
            new \App\Nova\Dashboards\Main,
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
