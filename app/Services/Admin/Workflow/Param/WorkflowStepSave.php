<?php namespace App\Services\Admin\Workflow\Param;

use App\Services\Admin\AbstractParam;

/**
 * Workflow_step操作有关的参数容器，固定参数，方便分离处理。
 *
 * @author jiang <mylampblog@163.com>
 */
class WorkflowStepSave extends AbstractParam
{
    protected $name;

    protected $description;

    protected $addtime;

    protected $id;

    protected $workflow_id;

    protected $step_level;

    protected $code;

}
