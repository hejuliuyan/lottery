<?php namespace App\Services\Admin\ActionLog\Foundation\Group;

use App\Services\Admin\AbstractActionLog;
use App\Events\Admin\ActionLog;
use Request, Lang;

/**
 * 用户操作日志
 *
 * @author jiang <mylampblog@163.com>
 */
class Edit extends AbstractActionLog
{
    /**
     * 编辑用户组时的日志记录
     */
    public function handler()
    {
        if(Request::method() !== 'POST') return false;
        if( ! $this->isLog()) return false;
        $groupInfo = Request::input('data');
        if( ! isset($groupInfo['group_name'])) return false;
        event(new ActionLog(Lang::get('actionlog.edit_group', ['groupname' => $groupInfo['group_name']])));
    }
    
}
