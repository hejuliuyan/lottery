<?php namespace App\Services\Admin\ActionLog\Foundation\User;

use App\Services\Admin\AbstractActionLog;
use App\Events\Admin\ActionLog;
use Request, Lang;

/**
 * 用户操作日志
 *
 * @author jiang <mylampblog@163.com>
 */
class Add extends AbstractActionLog
{
    /**
     * 增加用户时的日志记录
     */
    public function handler()
    {
        if(Request::method() !== 'POST') return false;
        if( ! $this->isLog()) return false;
        $userInfo = Request::input('data');
        if( ! isset($userInfo['name'])) return false;
        event(new ActionLog(Lang::get('actionlog.add_new_user', ['username' => $userInfo['name']])));
    }
    
}
