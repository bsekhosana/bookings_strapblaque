<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\PasswordRequest;
use App\Http\Requests\User\ProfileRequest;

class ProfileController extends Controller
{
    /**
     * Redirect to a certain settings page.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirect()
    {
        return redirect()->route('user.settings.profile.show');
    }

    /**
     * Show user profile.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show()
    {
        $user = self::user('user');

        return view('user.settings.profile')->with(compact('user'));
    }

    /**
     * Update user details.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileRequest $request)
    {
        $updated = self::user('user')->update($request->validated());

        \Alert::crud($updated, \Alert::Updated, 'profile');

        return redirect()->route('user.settings.profile.show');
    }

    /**
     * Update user password.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function password(PasswordRequest $request)
    {
        $updated = self::user('user')->update($request->validated());

        \Alert::crud($updated, \Alert::Updated, 'password');

        return redirect()->route('user.settings.profile.show');
    }
}
