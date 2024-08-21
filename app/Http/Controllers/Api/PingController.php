<?php

namespace App\Http\Controllers\Api;

use App\Abstracts\ApiController;
use Illuminate\Http\Request;

class PingController extends ApiController
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        return $this->respondOk(true);
    }
}
