<?php

namespace App\Exceptions\Api;

use Illuminate\Http\JsonResponse;
use Throwable;
use Illuminate\Validation\ValidationException;

class ApiValidationException extends ApiException
{
    /**
     * Error status code.
     *
     * @var int
     */
    protected $code = 422;

    /**
     * Error message.
     *
     * @var string
     */
    protected $message = 'Form validation failed';

    /**
     * Class constructor.
     */
    public function __construct(ValidationException $exception)
    {
        // Pass the exception to the parent constructor
        parent::__construct($exception);

        // Set the exception specifically as a ValidationException
        $this->exception = $exception;
    }

    /**
     * Create a response to return.
     */
    public function json(): JsonResponse
    {
        /** @var ValidationException $exception */
        $exception = $this->exception;

        return response()->json([
            'success' => false,
            'code'    => $this->code,
            'message' => $this->message,
            'data'    => $exception->errors(),
        ], $this->code);
    }
}
