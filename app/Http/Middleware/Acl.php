<?php namespace App\Http\Middleware;

use Closure;
use App\Services\Admin\Acl\Acl as AclManager;
use App\Services\Admin\MCAManager;

/**
 * 用户权限验证
 *
 * @author jiang <mylampblog@163.com>
 */
class Acl
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
        $param = $this->buildAclParam($request);
        $aclObject = new AclManager();
        $ret = $aclObject->checkUriPermission($param->module, $param->class, $param->action);
        if( ! $ret) return abort(401);
        $ret = $aclObject->checkIfHasReg($param->module, $param->class, $param->action);
        if( ! $ret) return abort(404, 'function hasn`t been registered');
        $this->bindAclParams($param);
        $response = $next($request);
        return $response;
    }

    /**
     * buildAclParam
     *
     * @param object $repuest
     */
    private function buildAclParam($request)
    {
        $object = new \stdClass();
        $object->class = $request->route('class');
        $object->action = $request->route('action');
        $object->module = $request->route('module');
        if( ! $object->class and ! $object->action and ! $object->module)
        {
            $currentRouteName = $request->route()->getName();
            $currentRouteNameArr = explode('.', $currentRouteName);
            if(isset($currentRouteNameArr[2]))
            {
                $object->module = $currentRouteNameArr[0];
                $object->class = $currentRouteNameArr[1];
                $object->action = $currentRouteNameArr[2];
            }
        }
        return $object;
    }

    /**
     * bind acl params
     *
     * @param object $object
     */
    private function bindAclParams($object)
    {
        $mac = new MCAManager();
        $mac->setModule($object->module)->setClass($object->class)->setAction($object->action);
        if( ! app()->bound(MCAManager::MAC_BIND_NAME))
        {
            app()->singleton(MCAManager::MAC_BIND_NAME, function() use ($mac)
            {
                return $mac;
            });
        }
    }

}
