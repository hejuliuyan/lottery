<?php namespace App\Http\Controllers\Admin\Foundation;

use App\Http\Controllers\Admin\Controller;
use App\Services\Admin\Login\Process as LoginProcess;
use App\Services\Admin\SC;
use App\Models\Admin\User;
use App\Services\Admin\Acl\Acl;
use Request;

/**
 * 登录相关
 *
 * @author jiang <mylampblog@163.com>
 */
class LoginController extends Controller
{
    /**
     * 登录页面，如果没有登录会显示登录页面。
     *
     * @access public
     */
    public function index()
    {
        $isLogin = (new LoginProcess())->getProcess()->hasLogin();
        if($isLogin) return redirect(R('common', 'foundation.index.index'));
        return response(view('admin.login.index'));
    }

    /**
     * 开始登录处理，并保存用户的权限信息
     *
     * @param App\Services\Admin\Login\Process $loginProcess 登录核心处理
     * @access public
     */
    public function getProc(LoginProcess $loginProcess, Acl $aclObj)
    {
        $username = Request::input('username');
        $password = Request::input('password');
        $callback = Request::input('callback');
        if($error = $loginProcess->getProcess()->validate($username, $password))
        {
            return response()->json(['msg' => $error, 'result' => false])->setCallback($callback);
        }
        //开始登录验证
        if($userInfo = $loginProcess->getProcess()->check($username, $password))
        {
            //设置用户的权限
            SC::setUserPermissionSession($aclObj->getUserAccessPermission($userInfo));
        }

        $result = $userInfo ? ['msg' => '登录成功', 'result' => true, 'jumpUrl' => R('common', 'foundation.index.index')]
                                : ['msg' => '登录失败', 'result' => false];
        
        return response()->json($result)->setCallback($callback);
    }

    /**
     * 初始化登录，返回加密密钥
     *
     * @param App\Services\Login\Process $loginProcess 登录核心处理
     * @access public
     */
    public function getPrelogin(LoginProcess $loginProcess)
    {
        $publicKey = $loginProcess->getProcess()->setPublicKey();
        return response()->json(['pKey' => $publicKey, 'a' => csrf_token()])->setCallback(Request::input('callback'));
    }

    /**
     * 登录退出
     */
    public function getOut(LoginProcess $loginProcess)
    {
        $loginProcess->getProcess()->logout();
        return redirect(url('/'));
    }

}