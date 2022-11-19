<?php

namespace App\Exceptions;

use App\Http\Resources\FaultResponse;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
            //
        });
    }

    /**
     * Здесь перехватываем исключения при работе приложения. Нужно точно указать класс исключения
     *
     * @param Request $request
     * @param Throwable $e
     * @return JsonResponse|SymfonyResponse
     * @throws Throwable
     */
    public function render($request, Throwable $e): JsonResponse|SymfonyResponse
    {
        return match (true) {
            $e instanceof NoFoundFeedbackException => $this->getNoFoundResponse($e),
            $e instanceof BaseException => $this->getFaultResponse($e, $e->getCode()),

            default => parent::render($request, $e),
        };
    }

    private function getFaultResponse(Throwable $e, string $code = SymfonyResponse::HTTP_BAD_GATEWAY): JsonResponse
    {
        return (new FaultResponse($e->getMessage()))->response()->setStatusCode($code);
    }

    private function getNoFoundResponse(Throwable $e): JsonResponse
    {
        return $this->getFaultResponse($e, SymfonyResponse::HTTP_NOT_FOUND);
    }
}
