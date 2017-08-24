<?php namespace App\Services\Admin\Workflow\Param;

use App\Services\Admin\AbstractParam;

/**
 * Workflow操作有关的参数容器，固定参数，方便分离处理。
 *
 * @author jiang <mylampblog@163.com>
 */
class WorkflowSave extends AbstractParam
{
    protected $name;

    protected $description;

    protected $addtime;

    protected $id;

    protected $code;

    protected $type;

}
