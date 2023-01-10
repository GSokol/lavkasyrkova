<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;
use Settings;

class Handler extends ExceptionHandler
{
    // эти коды должны быть уникальными, а у разных Exception'ов могут быть свои отдельные наборы кодов
    // формируются так: сначала 1, затем категория по статусу (400 или 403 и т.д.), затем порядковый номер
    const CODE_EXCEPTION_VALIDATION = 140001;
    const CODE_EXCEPTION_CSRF = 140101;
    const CODE_EXCEPTION_AUTHORIZATION = 140301;
    const CODE_EXCEPTION_UNAUTHORIZED = 140302;
    const CODE_EXCEPTION_ACCESS_DENIED = 140303;
    const CODE_EXCEPTION_WITH_MESSAGE = 140305;
    const CODE_EXCEPTION_UNKNOWN_ROUTE = 140401;

    protected $data = [];

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
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        // $this->renderable(function (NotFoundHttpException $exception, $request) {
        //     dump('register', $exception);
        //     // dump('register', $request->is('dashboard', 'dashboard/*'));
        //     // if (auth()->guard('dashboard')->check() && $request->is('dashboard', 'dashboard/*')) {
        //     //     return response()->view('dashboard::errors.404', [], Response::HTTP_NOT_FOUND);
        //     // }
        // });
    }

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    // public function report(Exception $exception)
    // {
    //     parent::report($exception);
    // }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, $exception)
    {
        if (config('app.debug')) {
            $response['debug'][CODE] = $exception->getCode();
            $response['debug'][MSG] = $exception->getMessage();
            $response['debug'][FILE] = $exception->getFile();
            $response['debug'][LINE] = $exception->getLine();
            $response['debug']['exception'] = get_class($exception);
            // for SQL Exceptions
            if ($exception instanceof \PDOException) {
                $response['debug'][SQL] = $exception->getSql(); // исходный sql запрос
                $response['debug']['bindings'] = $exception->getBindings(); // параметры запроса
            }
        }
        // если запрос типа ajax вернуть REST ответ
        if ($request->isXmlHttpRequest() || $request->expectsJson()) {
            $response[ERR] = Response::HTTP_BAD_REQUEST;
            $response[MSG] = 'Server error';
            $response[DESC] = $exception->getMessage();

            // Ошибка авторизация. Утрачен token
            if ($exception instanceof \Illuminate\Session\TokenMismatchException) {
                $response[ERR] = Response::HTTP_UNAUTHORIZED;
                $response[CODE] = self::CODE_EXCEPTION_CSRF;
                $response[MSG] = 'AUTH_ERROR: csrf token mismatch';
            }
            // Остальные ошибки авторизации
            if ($exception instanceof \Illuminate\Auth\Access\AuthorizationException) {
                $response[ERR] = Response::HTTP_FORBIDDEN;
                $response[CODE] = self::CODE_EXCEPTION_AUTHORIZATION;
                $response[MSG] = 'Action is unauthorized';
                $response[DESC] = $exception->getMessage();
            }
            // Ошибка запрещения неавторизованного доступа
            if ($exception instanceof \Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException) {
                $response[ERR] = Response::HTTP_FORBIDDEN;
                $response[CODE] = self::CODE_EXCEPTION_UNAUTHORIZED;
                $response[MSG] = 'Access denied';
            }
            // Ошибки запрещения доступа по отсутствию пермиссий
            if ($exception instanceof \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException) {
                $response[ERR] = Response::HTTP_FORBIDDEN;
                $response[CODE] = self::CODE_EXCEPTION_ACCESS_DENIED;
                $response[MSG] = 'Action is not permitted';
                if ($message = $exception->getMessage()) {
                    $response[DATA] = compact('message');
                }
            }
            // Роут не найден
            if ($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
                $response[ERR] = Response::HTTP_NOT_FOUND;
                $response[CODE] = self::CODE_EXCEPTION_UNKNOWN_ROUTE;
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
                $response[CODE] = self::CODE_EXCEPTION_VALIDATION;
                $response[MSG] = 'Validation error: incorrect field(s)';
                $response[DATA] = $this->formatValidationErrors($exception->validator->getMessageBag()->toArray());
            }
            return response()->json($response, $response[ERR]);
        }

        // страница не найдена
        if ($exception instanceof NotFoundHttpException || $exception instanceof ModelNotFoundException) {
            // если адрес в URL начинается с dashboard и аутентифицирован guard=dashboard
            if (auth()->guard('dashboard')->check() && $request->is('dashboard', 'dashboard/*')) {
                // View::composer('dashboard::components.header', 'Dashboard\Http\View\Composers\HeaderComposer');
                return response()->view('dashboard::errors.404', [], Response::HTTP_NOT_FOUND);
            }
            // TODO вынести в view/composers
            View::share('settings', Settings::getSettingsAll());
            return response()->view('errors.404', [], Response::HTTP_NOT_FOUND);
        }

        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into a response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Auth\AuthenticationException $exception
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($this->shouldReturnJson($request, $exception)) {
            return response()->json(['message' => $exception->getMessage()], 401);
        }
        if ($request->is('dashboard', 'dashboard/*')) {
            return redirect()->guest(route('dashboard.login'));
        }
        return redirect()->guest(route('face.login'));
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
