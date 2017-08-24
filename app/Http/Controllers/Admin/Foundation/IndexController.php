<?php namespace App\Http\Controllers\Admin\Foundation;

use App\Services\Admin\SC;
use App\Http\Controllers\Admin\Controller;

/**
 * 登录相关
 *
 * @author jiang <mylampblog@163.com>
 */
class IndexController extends Controller
{
    /**
     * 显示首页
     */
    public function index()
    {
        return view('admin.index.index');
    }

    /**
     * 显示首页
     */
    public function cs()
    {
        return view('admin.index.cs');
    }

    /**
     * 测试工作流
     */
    public function workflow()
    {
        $check = new \App\Services\Admin\Workflow\Check();
        //检测有没有权限
        $is = $check->checkAcl('W_sdfg', [2]);
        var_dump($is);
        //下一步所要设置的信息
        $next = $check->getComfirmStatus('W_sdfg', 1);
        var_dump($next);

        $checkStep = $check->checkStepAcl('W_fu', 'W_fuus');
        var_dump($checkStep);
    }

}