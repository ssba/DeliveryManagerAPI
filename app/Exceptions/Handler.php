<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Config;

class Handler extends ExceptionHandler
{

    public $sentryID = "";

    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [ /*
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class, */
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        if ($this->shouldReport($exception)) {
            $this->sentryID = app('sentry')->captureException($exception);
        }
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response'
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof BadRequestExeption) {
            return $this->responseWrapper($request, $exception->getMessage(), 400);
        }

        if ($exception instanceof BadTokenExeption) {
            return $this->responseWrapper($request, null, 401);
        }

        if ($exception instanceof ForbiddenExeption ||
            $exception instanceof AuthorizationException) {
            return $this->responseWrapper($request, null, 403);
        }

        if ($exception instanceof ModelNotFoundException ||
            $exception instanceof NotFoundHttpException) {
            return $this->responseWrapper($request, null, 404);

        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            return $this->responseWrapper($request, null, 405);
        }

        if ($exception instanceof ConflictExeption) {
            return $this->responseWrapper($request, $exception->getMessage(), 409);
        }

        if ($exception instanceof ValidationException) {
            return $this->responseWrapper($request, $exception->validator, 412);
        }

        if ($exception instanceof Exception ||
            $exception instanceof HttpException) {
            return $this->responseWrapper($request, null, 500);
        }

        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Illuminate\Auth\AuthenticationException $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest('login');
    }


    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Int $code
     * @param  string|null $messages
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    protected function responseWrapper($request, $messages ,$code)
    {
        $obj = $this->getJSONErrorFormatedObject($messages,$code);


        if ($request->expectsJson()) {

            return response()->json($obj, $code, [], JSON_NUMERIC_CHECK | JSON_BIGINT_AS_STRING | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
                ->withHeaders([
                    'Content-Type' => "application/vnd.api+json"
                ]);

        } elseif (Config::get('app.debug')){

            return response()->view('debug',[ 'json' => $obj ],$code)->withHeaders([
                'Content-Type' => "text/html; charset=utf-8"
            ]);

        }

        return response()->view('blank',[],$code)->withHeaders([
            'Content-Type' => "text/html; charset=utf-8"
        ]);


    }

    /**
     * get JSON standard object.
     *
     * @url http://jsonapi.org/format/#errors
     * @param  Int $code
     * @param  string|null $messages
     * @return array
     */
    private function getJSONErrorFormatedObject($messages = null,$code) : array
    {
        $obj = [
            "id" => $this->sentryID,
            "code" => $code,
            "status" => \Symfony\Component\HttpFoundation\Response::$statusTexts[$code],
        ];

        if(!is_null($messages))
            $obj["detail"] = $messages;

        return $obj;

    }
}