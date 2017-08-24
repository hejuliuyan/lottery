<?php namespace App\Services\Admin\Group\Validate;

use Validator, Lang;
use App\Services\Admin\BaseValidate;

/**
 * 用户组列表表单验证
 *
 * @author jiang <mylampblog@163.com>
 */
class Group extends BaseValidate
{
    /**
     * 增加用户组的时候的表单验证
     *
     * @access public
     */
    public function add(\App\Services\Admin\Group\Param\GroupSave $data)
    {
        // 创建验证规则
        $rules = array(
            'group_name' => 'required',
            'level' => 'required|numeric',
        );
        
        // 自定义验证消息
        $messages = array(
            'group_name.required' => Lang::get('group.group_name_empty'),
            'level.required' => Lang::get('group.group_level_empty'),
            'level.numeric' => Lang::get('group.group_level_empty'),
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
     * 编辑用户组的时候的表单验证
     *
     * @access public
     */
    public function edit(\App\Services\Admin\Group\Param\GroupSave $data)
    {
        return $this->add($data);
    }
    
}
