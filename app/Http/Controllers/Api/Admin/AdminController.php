<?php

namespace App\Http\Controllers\Api\Admin;

use App\Abstracts\ApiController;
use Illuminate\Http\Request;

class AdminController extends ApiController
{
    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->middleware(['auth:admin_api']);
    }

    /**
     * Switch UI between dark & light.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function theme(Request $request)
    {
        $theme = $request->input('theme');

        if ($theme && ($user = $request->user('admin_api'))) {
            $theme = strtolower($theme);

            if (in_array($theme, ['auto', 'light', 'dark'])) {
                $user->forceFill(compact('theme'))->save();
            }
        }

        return $this->respondNoContent();
    }
}
