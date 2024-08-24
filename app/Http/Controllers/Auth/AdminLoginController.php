<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Organization;
use App\Models\OrganizationAdmin;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminLoginController extends Controller
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
    protected int $decayMinutes = 60;

    /**
     * Where to redirect users after login.
     */
    protected string $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showLoginForm()
    {
        return view('auth.admin.login');
    }

     /**
     * Show the application's login form.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showRegForm()
    {
        return view('auth.admin.register');
    }

    /**
     * The user has been authenticated.
     *
     * @return mixed
     */
    protected function authenticated(Request $request, Admin $user)
    {
        $user->sendOTP();

        if (\Hash::needsRehash($user->password)) {
            $user->password = \Hash::make($request->input('password'));
            $user->saveQuietly();
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
        return \Auth::guard('admin');
    }

    /**
     * Path to redirect to after login.
     */
    public function redirectTo(): string
    {
        return route('admin.dashboard');
    }

    public function register(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'org_name' => 'required|string|max:255',
            'org_phone' => 'required|string|max:255',
            'org_email' => 'required|string|email|max:255|unique:organizations,email',
            'org_address' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'mobile' => 'required|string|max:255',
            'admin_email' => 'required|string|email|max:255|unique:admins,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create the organization
        $organization = Organization::create([
            'name' => $validated['org_name'],
            'email' => $validated['org_email'],
            'address' => $validated['org_address'],
            'phone' => $validated['org_phone'],
            'status' => 'Active', // Default status
        ]);

        // Create the admin
        $admin = Admin::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'mobile' => $validated['mobile'],
            'email' => $validated['admin_email'],
            'password' => Hash::make($validated['password']),
            'super_admin' => false, // Ensure the admin is not a super admin
        ]);

        // Link the admin to the organization
        OrganizationAdmin::create([
            'admin_id' => $admin->id,
            'organization_id' => $organization->id,
        ]);

        // Automatically log in the newly created admin
        if (\Auth::guard('admin')->attempt(['email' => $validated['admin_email'], 'password' => $validated['password']])) {
            // Redirect to admin dashboard after successful login
            return redirect()->route('admin.dashboard')->with('success', 'Admin and Organization registered successfully.');
        }

        // In case login fails, redirect to login page
        return redirect()->route('admin.login')->withErrors(['login' => 'Registration successful, but auto-login failed. Please login manually.']);

    }
}
