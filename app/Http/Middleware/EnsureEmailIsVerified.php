<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponder;
use Closure;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class EnsureEmailIsVerified
{
    use ApiResponder;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null  $redirectToRoute
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|null
     */
    public function handle($request, Closure $next, $redirectToRoute = null)
    {
        $user = $request->user();

        if (! $user || ($user instanceof MustVerifyEmail && ! $user->hasVerifiedEmail())) {
            if ($request->expectsJson()) {
                return $this->respondForbidden('Your email address is not verified.');
            }

            if ($user instanceof \App\Models\Admin) {
                return \Redirect::guest(\URL::route($redirectToRoute ?: 'verification.notice'));
            }

            if (! in_array(\Route::currentRouteName(), ['user.settings.profile.show', 'user.settings.profile.update'])) {
                \Alert::warning('Please verify your email before continuing!');

                return \Redirect::guest(\URL::route($redirectToRoute ?: 'user.settings.profile.show'));
            }
        }

        return $next($request);
    }
}
