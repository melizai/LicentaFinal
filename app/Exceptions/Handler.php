<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Auth\AuthenticationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        // Add exception types that you don't want to report here.
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
     */
    public function register()
    {
        $this->renderable(function (ValidationException $e, $request) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $e->errors()
            ], 422);
        });

        $this->renderable(function (HttpException $e, $request) {
            return response()->json([
                'message' => $e->getMessage() ?: 'HTTP Error',
                'status_code' => $e->getStatusCode()
            ], $e->getStatusCode());
        });

        $this->renderable(function (AuthenticationException $e, $request) {
            return response()->json([
                'message' => 'Unauthenticated'
            ], 401);
        });

        $this->renderable(function (Throwable $e, $request) {
            return response()->json([
                'message' => 'Server Error',
                'error' => $e->getMessage()
            ], 500);
        });
    }

    /**
     * Convert a validation exception into a JSON response.
     *
     * @param ValidationException $exception
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    protected function invalidJson($request, ValidationException $exception)
    {
        return response()->json([
            'message' => 'Validation Error',
            'errors' => $exception->errors()
        ], $exception->status);
    }

    /**
     * Convert an authentication exception into a JSON response.
     *
     * @param \Illuminate\Http\Request $request
     * @param AuthenticationException $exception
     * @return \Illuminate\Http\JsonResponse
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return response()->json([
            'message' => 'Unauthenticated'
        ], 401);
    }
}
