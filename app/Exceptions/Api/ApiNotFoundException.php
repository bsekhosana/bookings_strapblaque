<?php

namespace App\Exceptions\Api;

class ApiNotFoundException extends ApiException
{
    /**
     * Error status code.
     *
     * @var int
     */
    protected $code = 404;

    /**
     * Error message.
     *
     * @var string
     */
    protected $message = 'Not found';
}
