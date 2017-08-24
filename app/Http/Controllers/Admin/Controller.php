<?php namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller as BaseController;
use App\Services\Formhash;
use App\Services\Admin\ActionLog\Mark;
use Illuminate\Support\Facades\Session;
use Illuminate\Routing\Redirector;
use Route;
use App;
/**
 * 父控制类类
 *
 * @author jiang <mylampblog@163.com>
 */
abstract class Controller extends BaseController
{
    /**
     * 检测表单篡改
     * 
     * @return true|exception
     */

    //自动验证
    /*public function __construct(){
        if (! Session::get('admin')) {
            //return redirect()->route("/login");
            echo '<script> window.location.href="/index.php/login";</script>';
            return false;
        }
    }*/
    public function __construct(){
        if (empty(Session::get('admin'))) {
            //return redirect()->route("/login");
            echo '<script> window.location.href="/index.php/login";</script>';
            return false;
        }
        $lg = Session::get('locale');
        if (empty($lg) || !isset($lg)) {
            App::setLocale('cn');
        } else {
            App::setLocale($lg);
        }
    }

    protected function checkFormHash()
    {
        return (new Formhash())->checkFormHash();
    }

    /**
     * 启用操作日志记录
     */
    protected function setActionLog($extDatas = [])
    {
    	return app()->make(Mark::BIND_NAME)->setMarkYes()->setExtDatas($extDatas);
    }

}
