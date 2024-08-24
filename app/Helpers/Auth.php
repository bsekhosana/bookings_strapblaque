<?php

namespace App\Helpers;

use App\Models\Organization;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;

class Auth
{
    /**
     * Session key to store/retrieve guards.
     */
    protected static string $session_key = 'login_auth_guard';

    /**
     * Get logged in user from request.
     */
    public static function user(Request $request, string $driver = 'session'): ?User
    {
        if (static::guard($driver) && $user = $request->user(static::guard($driver))) {
            return $user;
        }

        return null;
    }

    /**
     * Get logged in user organization.
     */
    public static function userOrganization(Request $request, string $driver = 'session'): ?Organization
    {
        if (static::guard($driver) && $user = $request->user(static::guard($driver))) {
            return $user;
        }

        return null;
    }

    /**
     * Get the guard for current user.
     */
    public static function guard(string $driver = 'session'): ?string
    {
        if (! \Session::has(self::$session_key)) {
            foreach (self::guards($driver) as $guard) {
                if (\Auth::guard($guard)->check()) {
                    self::setGuard($guard);

                    return $guard;
                }
            }
        }

        return \Session::get(self::$session_key);
    }

    /**
     * Set the guard for current user.
     */
    public static function setGuard(?string $guard): void
    {
        if ($guard) {
            \Session::put(self::$session_key, $guard);
        } else {
            \Session::forget(self::$session_key);
        }
    }

    /**
     * Get all guards of driver.
     *
     * @return string[]
     */
    public static function guards(string $driver = 'session'): array
    {
        return \Cache::remember(sprintf('auth_guards:%s', $driver), now()->addHours(2), function () use ($driver): array {
            $guards = [];

            foreach (\Config::get('auth.guards') as $guard => $options) {
                if ($options['driver'] == strtolower($driver)) {
                    $guards[] = $guard;
                }
            }

            return $guards;
        });
    }

    /**
     * Logout the current user.
     */
    public static function logout(Request $request): void
    {
        if ($guard = self::guard()) {
            \Auth::guard($guard)->logout();
        }

        $request->session()->invalidate();

        $request->session()->regenerateToken();
    }
}
