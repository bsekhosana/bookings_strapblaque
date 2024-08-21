<?php

namespace App\Exceptions\Api;

class ApiBadRequestException extends ApiException
{
    /**
     * Error status code.
     *
     * @var int
     */
    protected $code = 400;

    /**
     * Error message.
     *
     * @var string
     */
    protected $message = 'Bad request';
}
