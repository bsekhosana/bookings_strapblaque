<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

class LogoutController
{
    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request, string $redirect_to = '/')
    {
        \App\Helpers\Auth::logout($request);

        return redirect()->to($redirect_to);
    }
}
