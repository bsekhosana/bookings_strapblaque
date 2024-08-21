<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponder
{
    /**
     * JSON response for 200 - OK.
     */
    public function respondOk(mixed $data = null, string $message = 'OK'): JsonResponse
    {
        return $this->apiResponse(
            data: $data,
            message: $message
        );
    }

    /**
     * JSON response for 201 - Created.
     */
    public function respondCreated(mixed $data = null, string $message = 'Created'): JsonResponse
    {
        return $this->apiResponse(
            data: $data,
            code: 201,
            message: $message
        );
    }

    /**
     * JSON response for 202 - Accepted.
     */
    public function respondAccepted(mixed $data = null, string $message = 'Accepted'): JsonResponse
    {
        return $this->apiResponse(
            data: $data,
            code: 202,
            message: $message
        );
    }

    /**
     * JSON response for 204 - No Content.
     */
    public function respondNoContent(): JsonResponse
    {
        return $this->apiResponse(
            code: 204
        );
    }

    /**
     * JSON response for 301 - Moved Permanently.
     */
    public function respondMovedPermanently(string $location, string $message = 'Moved permanently'): JsonResponse
    {
        return $this->apiResponse(
            data: compact('location'),
            code: 301,
            message: $message
        );
    }

    /**
     * JSON response for 302 - Moved Temporarily.
     */
    public function respondMovedTemporarily(string $location, string $message = 'Moved temporarily'): JsonResponse
    {
        return $this->apiResponse(
            data: compact('location'),
            code: 302,
            message: $message
        );
    }

    /**
     * JSON response for 304 - Not Modified.
     */
    public function respondNotModified(string $message = 'Not Modified'): JsonResponse
    {
        return $this->apiResponse(
            code: 304,
            message: $message
        );
    }

    /**
     * JSON response for 400 - Bad Request.
     */
    public function respondBadRequest(string $message = 'Bad request'): JsonResponse
    {
        return $this->apiResponse(
            code: 400,
            message: $message
        );
    }

    /**
     * JSON response for 400 - Bad Request.
     * Clone of `respondBadRequest`.
     */
    public function respondError(string $message = 'Bad request'): JsonResponse
    {
        return $this->apiResponse(
            code: 400,
            message: $message
        );
    }

    /**
     * JSON response for 401 - Unauthorized.
     */
    public function respondUnauthorized(string $message = 'Unauthorized'): JsonResponse
    {
        return $this->apiResponse(
            code: 401,
            message: $message
        );
    }

    /**
     * JSON response for 403 - Forbidden.
     */
    public function respondForbidden(string $message = 'Forbidden'): JsonResponse
    {
        return $this->apiResponse(
            code: 403,
            message: $message
        );
    }

    /**
     * JSON response for 404 - Not Found.
     */
    public function respondNotFound(string $message = 'Not found'): JsonResponse
    {
        return $this->apiResponse(
            code: 404,
            message: $message
        );
    }

    /**
     * JSON response for 422 - Unprocessable Entity.
     */
    public function respondValidationFailed(array $errors, string $message = 'Validation failed'): JsonResponse
    {
        return $this->apiResponse(
            data: $errors,
            code: 422,
            message: $message
        );
    }

    /**
     * JSON response for 500 - Internal Server Error.
     */
    public function respondServerError(string $message = 'Unknown error occurred'): JsonResponse
    {
        return $this->apiResponse(
            code: 500,
            message: $message
        );
    }

    /**
     * Return a JSON response.
     */
    public function apiResponse(mixed $data = null, int $code = 200, ?string $message = null, array $headers = []): JsonResponse
    {
        return new JsonResponse([
            'success' => $code < 400,
            'code'    => $code,
            'message' => $message ?? ($code < 400 ? 'OK' : 'Bad request'),
            'data'    => $data,
        ], $code, $headers);
    }
}
