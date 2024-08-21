<?php

namespace App\Exceptions\Api;

class ApiMethodNotAllowedException extends ApiException
{
    /**
     * Error status code.
     *
     * @var int
     */
    protected $code = 405;

    /**
     * Error message.
     *
     * @var string
     */
    protected $message = 'Request method not allowed';
}
