<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

use App\Exceptions\{ModelDuplicateException, ModelNotFoundException};
class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        //Model Not Found
        if ($exception instanceof ModelNotFoundException) {
            return response()->apiFail([
                'Code' => $exception->getCode(),
                'Message' => $exception->getMessage(),
            ], 404);
        }

        //Model Duplicate
        if ($exception instanceof ModelDuplicateException) {
            return response()->apiFail([
                'Code' => $exception->getCode(),
                'Message' => $exception->getMessage(),
            ], 409);
        }

        //api validate failed
        if ($exception instanceof ApiValidationException) {
            return response()->apiFail([
                'Code' => $exception->getCode(),
                'Message' => $exception->getMessage(),
            ], 400);
        }

        return response()->apiFail([
            'Code' => 500,
            'Message' => 'Internal Server Error',
        ], 500);
    }
}
