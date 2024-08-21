<?php

namespace App\Exceptions\Api;

class ApiMaintenanceException extends ApiException
{
    /**
     * Error status code.
     *
     * @var int
     */
    protected $code = 503;

    /**
     * Error message.
     *
     * @var string
     */
    protected $message = 'Maintenance mode';
}
