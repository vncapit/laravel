<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Throwable;
use App\Http\ApiResponseTrait;

class Handler extends ExceptionHandler
{
    use ApiResponseTrait;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {

        });
    }

    protected function shouldReturnJson($request, Throwable $e)
    {
        return true;
    }

    /**
     * Note: Handle all exception, response in a api json result
     * @param \Illuminate\Http\Request $request
     * @param Throwable $exception
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response
     */
    public function render($request, \Throwable $exception)
    {
        if ($exception instanceof ValidationException) {
            $errorMessage = $exception->errors() ;
            return $this->failed(RedirectResponse::HTTP_UNPROCESSABLE_ENTITY, $errorMessage);
        }

        if ($exception instanceof AuthenticationException) {
            $errorMessage = $exception->getMessage();
            return $this->failed(RedirectResponse::HTTP_UNPROCESSABLE_ENTITY, $errorMessage);
        }

        return parent::render($request, $exception);
    }
}
