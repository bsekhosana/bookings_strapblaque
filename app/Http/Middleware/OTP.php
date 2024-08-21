<?php

namespace App\Http\Middleware;

use Closure;

class OTP
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! $user = $request->user()) {
            return redirect()->route('guest.homepage');
        }

        if ($user->hasOTP()) {
            return redirect()->route('otp');
        }

        return $next($request);
    }
}
