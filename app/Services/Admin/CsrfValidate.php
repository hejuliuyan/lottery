<?php namespace App\Services\Admin;

use Crypt, Session, Request;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Str;

class CsrfValidate {

    /**
     * 由于系统默认的get请求不支持验证csrf，所以这里手动的来验证
     */
    public function tokensMatch()
    {
        $token = Session::token();
        $header = Request::header('X-XSRF-TOKEN');
        $match = Str::equals($token, Request::input('_token')) ||
               ($header && Str::equals($token, $header));
        if( ! $match) throw new TokenMismatchException;
    }
}