<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if (! $request->expectsJson()) {
            $uri = $request->getRequestUri();

            if (strpos($uri, \Config::get('nova.path', '/nova')) === 0 && \Route::has('nova.login')) {
                return route('nova.login');
            } elseif (strpos($uri, '/admin') === 0 && \Route::has('admin.login')) {
                return route('admin.login');
            }

            return \Route::has('login') ? route('login') : url('/');
        }

        return null;
    }
}
