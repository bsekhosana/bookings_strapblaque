<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Bookings Strapblaque API Documentation",
 *     description="This is the API documentation for the application.",
 *     @OA\Contact(
 *         email="info@strapblaque.com"
 *     ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 */
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
