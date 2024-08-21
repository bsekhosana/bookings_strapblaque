<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PasswordRequest;
use App\Http\Requests\Admin\ProfileRequest;

class ProfileController extends Controller
{
    /**
     * Class constructor.
     */
    public function __construct()
    {
        //$this->middleware([]);
    }

    /**
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function account()
    {
        $user = self::user('admin');

        return view('admin.profile.account')->with(compact('user'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateAccount(ProfileRequest $request)
    {
        $updated = self::user('admin')->update($request->validated());

        \Alert::crud($updated, \Alert::Updated, 'profile');

        return redirect()->back();
    }

    /**
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function security()
    {
        $user = self::user('admin');

        return view('admin.profile.security')->with(compact('user'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateSecurity(PasswordRequest $request)
    {
        $updated = self::user('admin')->update($request->validated());

        \Alert::crud($updated, \Alert::Updated, 'security settings');

        return redirect()->back();
    }
}
