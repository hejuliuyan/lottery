<?php namespace App\Services\Admin\Workflow\Validate;

use Validator, Lang;
use App\Services\Admin\BaseValidate;

/**
 * 增加和编辑工作流表单验证
 *
 * @author jiang <mylampblog@163.com>
 */
class Workflow extends BaseValidate
{
    /**
     * 增加工作流的时候的表单验证
     *
     * @access public
     */
    public function add(\App\Services\Admin\Workflow\Param\WorkflowSave $data)
    {
        // 创建验证规则
        $rules = array(
            'name' => 'required',
            'description' => 'required',
            'code' => 'required',
            'type' => 'required',
        );
        
        // 自定义验证消息
        $messages = array(
            'name.required' => Lang::get('workflow.workflow_name_empty'),
            'description.required' => Lang::get('workflow.workflow_description_empty'),
            'code.required' => Lang::get('workflow.workflow_code_empty'),
            'type.required' => Lang::get('workflow.workflow_type_empty'),
        );
        
        //开始验证
        $validator = Validator::make($data->toArray(), $rules, $messages);
        if($validator->fails())
        {
            $this->errorMsg = $validator->messages()->first();
            return false;
        }
        return true;
    }
    
    /**
     * 编辑工作流的时候的表单验证
     *
     * @access public
     */
    public function edit(\App\Services\Admin\Workflow\Param\WorkflowSave $data)
    {
        return $this->add($data);
    }
    
}
