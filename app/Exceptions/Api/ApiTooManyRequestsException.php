<?php

namespace App\Exceptions\Api;

class ApiTooManyRequestsException extends ApiException
{
    /**
     * Error status code.
     *
     * @var int
     */
    protected $code = 429;

    /**
     * Error message.
     *
     * @var string
     */
    protected $message = 'Too many requests';
}
