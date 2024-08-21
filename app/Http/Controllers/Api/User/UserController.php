<?php

namespace App\Http\Controllers\Api\User;

use App\Abstracts\ApiController;
use Illuminate\Http\Request;

class UserController extends ApiController
{
    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->middleware(['auth:user_api']);
    }

    /**
     * Switch UI between dark & light.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function theme(Request $request)
    {
        $theme = $request->input('theme');

        if ($theme && ($user = $request->user('user_api'))) {
            $theme = strtolower($theme);

            if (in_array($theme, ['auto', 'light', 'dark'])) {
                $user->forceFill(compact('theme'))->save();
            }
        }

        return $this->respondNoContent();
    }
}
