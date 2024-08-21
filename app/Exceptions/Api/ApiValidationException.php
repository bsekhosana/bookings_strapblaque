<?php

namespace App\Exceptions\Api;

use Illuminate\Http\JsonResponse;

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
     * The exception that was thrown.
     *
     * @var \Illuminate\Validation\ValidationException
     */
    protected $exception;

    /**
     * Create a response to return.
     */
    public function json(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'code'    => $this->code,
            'message' => $this->message,
            'data'    => method_exists($this->exception, 'errors')
                ? $this->exception->errors()
                : $this->exception->getMessage(),
        ], $this->code);
    }
}
