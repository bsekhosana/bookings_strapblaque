<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Auth;
use App\Helpers\OTP;
use App\Http\Controllers\Controller;
use App\Http\Requests\OtpRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Middleware\ThrottleRequests;

class OtpController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(ThrottleRequests::with(3, 5))->only(['submitOtp', 'resendOtp']);
    }

    /**
     * Show the OTP form.
     *
     * @return \Illuminate\Contracts\Support\Renderable|\Illuminate\Http\RedirectResponse
     */
    public function showOtpForm(Request $request)
    {
        if (! $user = Auth::user($request)) {
            abort(401, 'You are not logged in.');
        }

        return $user->hasOTP() ? view('auth.otp') : $user->dashboardRedirect();
    }

    /**
     * Resend OTP number.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resendOtp(Request $request)
    {
        if (! $user = Auth::user($request)) {
            return redirect()->route('login');
        }

        OTP::notify($user);

        \Alert::success('OTP has been sent successfully!');

        return redirect()->back();
    }

    /**
     * Submit OTP number and redirect.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submitOtp(OtpRequest $request)
    {
        $user = Auth::user($request);

        OTP::clear($user);

        return $user->dashboardRedirect();
    }
}
