<?php

namespace App\Exceptions\Api;

use Illuminate\Http\JsonResponse;
use Throwable;

class ExceptionHandler
{
    public static function handle(Throwable $exception): JsonResponse
    {
        // Get an ApiException
        if ($exception instanceof \App\Exceptions\Api\ApiException) {
            return $exception->json();
        }

        // Get an ApiException with same status code
        if (method_exists($exception, 'getStatusCode') && self::hasExceptionForCode($exception->getStatusCode())) {
            return self::getExceptionForCode($exception, $exception->getStatusCode());
        } elseif (method_exists($exception, 'getCode') && self::hasExceptionForCode($exception->getCode())) {
            return self::getExceptionForCode($exception, $exception->getCode());
        }

        if ($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
            return self::getExceptionForCode($exception, 404);
        } elseif ($exception instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
            return self::getExceptionForCode($exception, 404);
        } elseif ($exception instanceof \Illuminate\Auth\AuthenticationException) {
            return self::getExceptionForCode($exception, 401);
        } elseif ($exception instanceof \Illuminate\Auth\Access\AuthorizationException) {
            return self::getExceptionForCode($exception, 401);
        } elseif ($exception instanceof \Illuminate\Validation\ValidationException) {
            return self::getExceptionForCode($exception, 422);
        } elseif ($exception instanceof \Symfony\Component\HttpKernel\Exception\HttpException) {
            return self::getExceptionForCode($exception, $exception->getStatusCode());
        }

        return self::getExceptionForCode($exception, 500);
    }

    /**
     * Check if exception class exists for status code.
     */
    private static function hasExceptionForCode(int|string $code): bool
    {
        return in_array(intval($code), array_keys(self::exceptionClasses()));
    }

    /**
     * Call `json` method from exception class.
     */
    private static function getExceptionForCode(Throwable $exception, int|string $code): JsonResponse
    {
        $class = self::exceptionClasses()[intval($code)];

        return call_user_func([new $class($exception), 'json']);
    }

    /**
     * API exception classes.
     */
    private static function exceptionClasses(): array
    {
        return [
            400 => \App\Exceptions\Api\ApiBadRequestException::class,
            401 => \App\Exceptions\Api\ApiUnauthorizedException::class,
            403 => \App\Exceptions\Api\ApiForbiddenException::class,
            404 => \App\Exceptions\Api\ApiNotFoundException::class,
            405 => \App\Exceptions\Api\ApiMethodNotAllowedException::class,
            422 => \App\Exceptions\Api\ApiValidationException::class,
            429 => \App\Exceptions\Api\ApiTooManyRequestsException::class,
            500 => \App\Exceptions\Api\ApiServerErrorException::class,
            503 => \App\Exceptions\Api\ApiMaintenanceException::class,
        ];
    }
}
