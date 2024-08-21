<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/user';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        \RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
        //Route::pattern('model', '^[a-zA-Z0-9]{16}$');
    }

    /**
     * Define the routes for the application.
     */
    public function map(): void
    {
        $this->mapAuthRoutes();

        $this->mapUserRoutes();

        $this->mapAdminRoutes();

        $this->mapApiRoutes();

        $this->mapGuestRoutes();

        $this->mapEmailRoutes();
    }

    /**
     * Define the "guest" routes for the application.
     * These routes all receive session state, CSRF protection, etc.
     */
    protected function mapGuestRoutes(): void
    {
        Route::middleware(['web'])
            ->name('guest.')
            ->group(base_path('routes/guest.php'));
    }

    /**
     * Define the "auth" routes for the application.
     */
    protected function mapAuthRoutes(): void
    {
        Route::middleware(['web'])
            ->group(base_path('routes/auth.php'));
    }

    /**
     * Define the "user" routes for the application.
     * These routes all receive session state, CSRF protection, etc.
     */
    protected function mapUserRoutes(): void
    {
        Route::prefix('user')
            ->middleware(['web', 'auth:user', 'verified'])
            ->name('user.')
            ->group(base_path('routes/user.php'));
    }

    /**
     * Define the "admin" routes for the application.
     * These routes all receive session state, CSRF protection, etc.
     */
    protected function mapAdminRoutes(): void
    {
        Route::prefix('admin')
            ->middleware(['web', 'auth:admin', 'otp', 'last_seen'])
            ->name('admin.')
            ->group(base_path('routes/admin.php'));
    }

    /**
     * Define the "email" routes for the application.
     */
    protected function mapEmailRoutes(): void
    {
        Route::prefix('email')
            ->middleware(['web', 'signed'])
            ->name('emails.')
            ->group(base_path('routes/emails.php'));
    }

    /**
     * Define the "api" routes for the application.
     * These routes are typically stateless.
     */
    protected function mapApiRoutes(): void
    {
        Route::prefix('api')
            ->middleware(['api', 'cache.headers:etag'])
            ->name('api.')
            ->group(base_path('routes/api.php'));
    }
}
