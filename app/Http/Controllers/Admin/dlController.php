<?php namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller as BaseController;
use App\Services\Formhash;
use App\Services\Admin\ActionLog\Mark;
use Illuminate\Support\Facades\Session;

/**
 * 父控制类类
 *
 * @author jiang <mylampblog@163.com>
 */
abstract class dlController extends BaseController
{
    /**
     * 检测表单篡改
     *
     * @return true|exception
     */

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
