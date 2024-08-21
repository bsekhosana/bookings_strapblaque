<?php

namespace App\Http\Middleware;

use Closure;

class LastSeen
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next, string $driver = 'session')
    {
        if ($user = ($request->user() ?? \App\Helpers\Auth::user($request, $driver))) {
            \DB::table($user->getTable())->where('id', $user->id)->update(['last_seen_at' => now()]);
        }

        return $next($request);
    }
}
