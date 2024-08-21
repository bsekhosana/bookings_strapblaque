<?php

namespace App\Http\Responses;

use Illuminate\Http\Request;
use Spatie\Honeypot\SpamResponder\SpamResponder;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SpamResponse implements SpamResponder
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function respond(Request $request, \Closure $next)
    {
        throw new HttpException(403, 'Instant submissions are considered as spam! Please wait a few seconds before submitting forms.');
    }
}
