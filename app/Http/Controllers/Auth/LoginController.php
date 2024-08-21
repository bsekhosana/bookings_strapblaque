<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers, ThrottlesLogins;

    /**
     * Maximum login attempts before lockout.
     */
    protected int $maxAttempts = 4;

    /**
     * Lockout duration in minutes.
     */
    protected int $decayMinutes = 5;

    /**
     * Where to redirect users after login.
     */
    protected string $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:user')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        if ($redirect_url = request()->query('redirect_url')) {
            session()->flash('redirect_url', $redirect_url);
        }

        return view('auth.login');
    }

    /**
     * The user has been authenticated.
     *
     * @return mixed|void
     */
    protected function authenticated(Request $request, User $user)
    {
        if (\Hash::needsRehash($user->password)) {
            $user->update(['password' => \Hash::make($request->get('password'))]);
        }

        if ($redirect_url = session()->get('redirect_url')) {
            return redirect()->away($redirect_url);
        }
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'email';
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return \Auth::guard('user');
    }
}
