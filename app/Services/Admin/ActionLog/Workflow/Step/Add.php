<?php namespace App\Services\Admin\ActionLog\Workflow\Step;

use App\Services\Admin\AbstractActionLog;
use App\Events\Admin\ActionLog;
use Request, Lang;

/**
 * 工作流步骤管理操作日志
 *
 * @author jiang <mylampblog@163.com>
 */
class Add extends AbstractActionLog
{
    /**
     * 增加工作流步骤时的日志记录
     */
    public function handler()
    {
        if(Request::method() !== 'POST') return false;
        if( ! $this->isLog()) return false;
        $workflowStepInfo = Request::input('data');
        if( ! isset($workflowStepInfo['name'])) return false;
        event(new ActionLog(Lang::get('actionlog.add_workflow_step', ['name' => $workflowStepInfo['name']])));
    }
    
}
