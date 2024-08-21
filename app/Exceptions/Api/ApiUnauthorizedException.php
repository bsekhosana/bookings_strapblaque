<?php

namespace App\Exceptions\Api;

class ApiUnauthorizedException extends ApiException
{
    /**
     * Error status code.
     *
     * @var int
     */
    protected $code = 401;

    /**
     * Error message.
     *
     * @var string
     */
    protected $message = 'Unauthorized';
}
