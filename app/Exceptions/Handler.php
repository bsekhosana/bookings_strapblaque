<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        \RedisException::class,
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
        'new_password',
    ];

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @throws \Throwable
     */
    public function render($request, Throwable $e): Response
    {
        // Maintenance mode
        if ($e instanceof HttpException) {
            if ($e->getStatusCode() === 503 && \App::maintenanceMode()->active()) {
                $e = new HttpException(503, '', null, [
                    'Refresh'     => 60,
                    'Retry-After' => 60,
                ]);
            } elseif ($e->getStatusCode() === 404 && \Str::startsWith($e->getMessage(), 'The route')) {
                $e = new NotFoundHttpException('The page you are looking for could not be found.');
            }
        }

        // Transform API exceptions into JSON responses.
        if (\Str::startsWith($request->getRequestUri(), ['/api/', 'api/'])) {
            return \App\Exceptions\Api\ExceptionHandler::handle($e);
        }

        // Avoid showing: "No query results for model [App\Models\Model]" on 404 error page.
        if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
            $e = new NotFoundHttpException;
        }

        return parent::render($request, $e);
    }

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
