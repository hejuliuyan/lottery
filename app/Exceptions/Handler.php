<?php

namespace App\Exceptions;

use Exception, Request;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Debug\ExceptionHandler as SymfonyDisplayer;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        return parent::render($request, $e);
    }

    /**
     * 自定义错误页
     */
    /*protected function renderHttpException(HttpException $e)
    {
        //error_log(print_r($e,true));
        if(Request::ajax() and ! config('app.debug'))
        {
            return response()->json(['error_code' => $e->getStatusCode()]);
        }
        elseif (view()->exists('error.common') and ! config('app.debug'))
        {
            return response()->view('error.common', ['errorCode' => $e->getStatusCode()], $e->getStatusCode());
        }
        else
        {
            return (new SymfonyDisplayer(config('app.debug')))->createResponse($e);
        }
    }*/

    protected function convertExceptionToResponse(Exception $e)
    {
        $debug = config('app.debug', false);

        if ($debug) {
            // 当 debug 为 true 时，返回默认的报错页面
            return (new SymfonyDisplayer($debug))->createResponse($e);
        }

        return response()->view('error.common', ['expection' => $e]);
    }

}
