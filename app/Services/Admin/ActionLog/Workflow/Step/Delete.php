<?php namespace App\Services\Admin\ActionLog\Workflow\Step;

use App\Services\Admin\AbstractActionLog;
use App\Events\Admin\ActionLog;
use Request, Lang;

/**
 * 工作流操作日志
 *
 * @author jiang <mylampblog@163.com>
 */
class Delete extends AbstractActionLog
{
    /**
     * 删除工作流时的日志记录
     */
    public function handler()
    {
        if( ! $this->isLog()) return false;
        $extDatas = $this->getExtDatas();
        if( ! isset($extDatas['workflowStepInfo']) or ! is_array($extDatas['workflowStepInfo']) or empty($extDatas['workflowStepInfo'])) return false;
        foreach($extDatas['workflowStepInfo'] as $value)
        {
            event(new ActionLog(Lang::get('actionlog.delete_workflow_step', ['name' => $value['name']])));
        }
    }
    
}
