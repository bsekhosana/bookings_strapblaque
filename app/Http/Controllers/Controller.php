<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Current logged-in user.
     *
     * @return \App\Models\User|\App\Models\Admin|null
     */
    protected static function user(?string $guard = null)
    {
        return auth($guard)->user() ?? null;
    }
}
