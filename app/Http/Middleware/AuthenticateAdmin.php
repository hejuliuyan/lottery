<?php

namespace App\Http\Middleware;

use Closure;
use Zizaco\Entrust\EntrustFacade as Entrust;
use Route, URL, Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use DB;
use App;

class AuthenticateAdmin
{
    /**
     * 权限系统中间件
     * @param  [type]  $request [description]
     * @param  Closure $next    [description]
     * @param  [type]  $guard   [description]
     * @return [type]           [description]
     */
    public function handle($request, Closure $next, $guard = null)
    {

        /*$lg = Session::get('locale');
        if (empty($lg) || !isset($lg)) {
            App::setLocale('cn');
        } else {
            App::setLocale($lg);
        }*/
        $routes = Route::currentRouteName();
        $my_id = Session::get('admin');
        if ($my_id == '1') {
            return $next($request);
            exit();
        }
        if ($routes === 'admin.login') {
            return $next($request);
            exit();
        } else {
            if (!Session::get('admin')) {
                if ($routes == 'admin_index') {
                    return response()->view('admin.login.index');
                    exit();
                }
                return response()->view('admin.login.index');
                exit();
            }
            if ($routes == 'admin_index') {
                return $next($request);
                return response()->view('admin.index.index');
                exit();
            }
            $data = DB::table('permissions')->join('permission_role', 'permissions.id', '=', 'permission_role.permission_id')
                ->join('roles', 'permission_role.role_id', '=', 'roles.id')
                ->join('role_user', 'roles.id', '=', 'role_user.role_id')
                ->join('users', 'role_user.user_id', '=', 'users.id')
                ->where('permissions.name', '=', Route::currentRouteName())
                ->select('users.id')
                ->get();
            if (!isset($data) || (empty($data))) {
                echo '<script language="javascript">alert("' . iconv("UTF-8", "GBK", '你没有权限访问') . '");window.history.back(-1);</script>';
                exit();
            }
            foreach ($data as $k => $val) {
                $arr[$k] = $val->id;
            }
            if (in_array($my_id, $arr) == false) {
                echo '<script language="javascript">alert("' . iconv("UTF-8", "GBK", '你没有权限访问') . '");window.history.back(-1);</script>';
                exit();
            }
            /*$a = Entrust::hasRole($data);*/
            // error_log(print_r($data, true));


        }

        return $next($request);
    }
}
