<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        // если запрос типа ajax вернуть REST ответ
        if ($request->isXmlHttpRequest() || $request->expectsJson()) {
            $response[ERR] = Response::HTTP_BAD_REQUEST;
            $response[MSG] = 'Server error';
            $response[DESC] = $exception->getMessage();

            // Ошибка авторизация. Утрачен token
            if ($exception instanceof \Illuminate\Session\TokenMismatchException) {
                $response[ERR] = Response::HTTP_UNAUTHORIZED;
                $response[MSG] = 'AUTH_ERROR: csrf token mismatch';
            }
            // Остальные ошибки авторизации
            if ($exception instanceof \Illuminate\Auth\Access\AuthorizationException) {
                $response[ERR] = Response::HTTP_FORBIDDEN;
                $response[MSG] = 'Action is unauthorized';
                $response[DESC] = $exception->getMessage();
            }
            // Ошибка запрещения неавторизованного доступа
            if ($exception instanceof \Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException) {
                $response[ERR] = Response::HTTP_FORBIDDEN;
                $response[MSG] = 'Access denied';
            }
            // Ошибки запрещения доступа по отсутствию пермиссий
            if ($exception instanceof \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException) {
                $response[ERR] = Response::HTTP_FORBIDDEN;
                $response[MSG] = 'Action is not permitted';
                if ($message = $exception->getMessage()) {
                    $response[DATA] = compact('message');
                }
            }
            // Роут не найден
            if ($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
                $response[ERR] = Response::HTTP_NOT_FOUND;
                $response[MSG] = "API route [{$request->path()}] not found";
            }
            // Синтаксическая ошибка
            if ($exception instanceof \Symfony\Component\Debug\Exception\FatalThrowableError) {
                $response[ERR] = Response::HTTP_INTERNAL_SERVER_ERROR;
                $response[MSG] = 'Fatal error';
            }
            // SQL Exceptions
            if ($exception instanceof \Illuminate\Database\QueryException || $exception instanceof \PDOException) {
                $response[MSG] = 'SQL_ERROR';
            }
            // Ошибки валидации
            if ($exception instanceof \Illuminate\Validation\ValidationException) {
                $response[ERR] = Response::HTTP_UNPROCESSABLE_ENTITY;
                $response[MSG] = 'Validation error: incorrect field(s)';
                $response[DATA] = $this->formatValidationErrors($exception->validator->getMessageBag()->toArray());
            }
            return response()->json($response, $response[ERR]);
        }

        return parent::render($request, $exception);
    }

    /**
     * формат вывод ошибок валидации
     *
     * @param array $errors
     * @return array
     */
    private function formatValidationErrors($errors) {
        $result = [];
        foreach ($errors as $field => $messages) {
            foreach ($messages as $message) {
                $result[] = ['field' => $field, 'message' => $message];
            }
        }
        return $result;
    }
}
