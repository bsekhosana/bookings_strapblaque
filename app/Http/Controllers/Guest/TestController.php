<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;

class TestController extends Controller
{
    /**
     * Testing playground.
     *
     * @return mixed|void
     * @throws \ReflectionException
     */
    public function playground()
    {
        if (! \App::isLocal()) {
            abort(404);
        }

        return 'Hello world!';
    }

    /**
     * Email template.
     *
     * @return mixed|void
     * @throws \ReflectionException
     */
    public function testMail()
    {
        if (! \App::isLocal()) {
            abort(404);
        }

        return (new \App\Mail\TestMail)->render();
    }

    /**
     * OTP form.
     *
     * @return mixed|void
     * @throws \ReflectionException
     */
    public function otpForm()
    {
        if (! \App::isLocal()) {
            abort(404);
        }

        return view('auth.otp');
    }
}
