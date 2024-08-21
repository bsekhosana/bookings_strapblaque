<?php

namespace App\Exceptions\Api;

class ApiForbiddenException extends ApiException
{
    /**
     * Error status code.
     *
     * @var int
     */
    protected $code = 403;

    /**
     * Error message.
     *
     * @var string
     */
    protected $message = 'Forbidden';
}
