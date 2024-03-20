<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($this->isHttpException($exception)) {
            switch ($exception->getStatusCode()) {
                case 404:
                    return response()->view('errors.404', ["title" => "404"], 404);
                    break;
                case 500:
                    return response()->view('errors.500', ["title" => "500"], 500);
                    break;
                case 503:
                    return response()->view('errors.503', ["title" => "503"], 503);
                    break;
                default:
                    return $this->renderHttpException($exception);
                    break;
            }
        }

        return parent::render($request, $exception);
    }
}
