<?php namespace App\Http\Middleware;

use Closure;
use App\Services\Admin\SC;
use App\Services\Admin\Login\Process as LoginProcess;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $isLogin = (new LoginProcess())->getProcess()->hasLogin();
        if(empty($isLogin)) {
            return redirect('/');
        }
        return $next($request);
    }

}
