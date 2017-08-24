<?php namespace App\Services\Admin\ActionLog\Workflow\Index;

use App\Services\Admin\AbstractActionLog;
use App\Events\Admin\ActionLog;
use Request, Lang;

/**
 * 工作流管理操作日志
 *
 * @author jiang <mylampblog@163.com>
 */
class Add extends AbstractActionLog
{
    /**
     * 增加工作流时的日志记录
     */
    public function handler()
    {
        if(Request::method() !== 'POST') return false;
        if( ! $this->isLog()) return false;
        $workflowInfo = Request::input('data');
        if( ! isset($workflowInfo['name'])) return false;
        event(new ActionLog(Lang::get('actionlog.add_new_workflow', ['name' => $workflowInfo['name']])));
    }
    
}
