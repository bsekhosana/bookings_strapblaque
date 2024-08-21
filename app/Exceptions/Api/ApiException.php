<?php

namespace App\Exceptions\Api;

use Illuminate\Http\JsonResponse;
use Throwable;

class ApiException extends \Exception
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
    protected $message = 'Unknown error occurred';

    /**
     * Class constructor.
     */
    public function __construct(protected Throwable $exception, protected mixed $data = null)
    {
        parent::__construct();
    }

    /**
     * Create a response to return.
     */
    public function json(): JsonResponse
    {
        if (in_array($this->code, [200, 400, 401, 403]) && strlen($this->exception->getMessage())) {
            $this->message = strlen($msg = $this->exception->getMessage()) ? $msg : $this->message;
        }

        return response()->json([
            'success' => false,
            'code'    => $this->code,
            'message' => $this->message,
            'data'    => $this->data,
        ], $this->code);
    }
}
