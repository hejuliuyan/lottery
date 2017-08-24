<?php namespace App\Services\Admin\ActionLog\Foundation\Group;

use App\Services\Admin\AbstractActionLog;
use App\Events\Admin\ActionLog;
use Request, Lang;

/**
 * 用户操作日志
 *
 * @author jiang <mylampblog@163.com>
 */
class Delete extends AbstractActionLog
{
    /**
     * 删除用户时的日志记录
     */
    public function handler()
    {
        if( ! $this->isLog()) return false;
        $extDatas = $this->getExtDatas();
        if( ! isset($extDatas['groupInfos']) or ! is_array($extDatas['groupInfos'])) return false;
        if(empty($extDatas['groupInfos']) or ! is_array($extDatas['groupInfos'])) return false;
        foreach($extDatas['groupInfos'] as $value)
        {
            event(new ActionLog(Lang::get('actionlog.delete_group', ['groupname' => $value['group_name']])));
        }
    }
    
}
