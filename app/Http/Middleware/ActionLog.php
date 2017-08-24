<?php namespace App\Http\Middleware;

use Closure;
use App\Services\Admin\MCAManager;
use App\Services\Admin\ActionLog\Mark;

/**
 * 用户操作日志
 *
 * @author jiang <mylampblog@163.com>
 */
class ActionLog
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
        $this->initLogMark();
        $response = $next($request);
        $this->log();
        return $response;
    }

    /**
     * 写入日志
     */
    private function log()
    {
        $MCA = app()->make(MCAManager::MAC_BIND_NAME);
        $module = ucwords($MCA->getModule());
        $action = ucwords($MCA->getAction());
        $class = ucwords($MCA->getClass());
        $logNamespace = '\\App\\Services\\Admin\\ActionLog\\';
        $manager = $logNamespace.$module.'\\'.$class.'\\'.$action;
        if( ! class_exists($manager)) return false;
        $managerObj = new $manager();
        $instanceof = $managerObj instanceof \App\Services\Admin\AbstractActionLog;
        if( ! $instanceof) return false;
        $managerObj->handler();
    }

    private function initLogMark()
    {
        $mark = new Mark();
        if( ! app()->bound(Mark::BIND_NAME))
        {
            app()->singleton(Mark::BIND_NAME, function() use ($mark)
            {
                return $mark;
            });
        }
    }

}
