<?php

namespace App\Exceptions\Api;

class ApiServerErrorException extends ApiException
{
    /**
     * Error status code.
     *
     * @var int
     */
    protected $code = 500;

    /**
     * Error message.
     *
     * @var string
     */
    protected $message = 'Internal server error';
}
