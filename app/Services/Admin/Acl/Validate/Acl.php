<?php namespace App\Services\Admin\Acl\Validate;

use Validator, Lang;
use App\Services\Admin\BaseValidate;

/**
 * 功能表单验证
 *
 * @author jiang <mylampblog@163.com>
 */
class Acl extends BaseValidate
{
    /**
     * 增加功能的时候的表单验证
     *
     * @access public
     */
    public function add(\App\Services\Admin\Acl\Param\AclSave $data)
    {
        //创建验证规则
        $rules = array(
            'name'    => 'required',
            'module'  => 'required',
            'class'   => 'required',
            'action'  => 'required',
            'pid'     => 'required|numeric',
        );
        
        //自定义验证消息
        $messages = array(
            'name.required'   => Lang::get('acl.acl_name_empty'),
            'module.required'  => Lang::get('acl.acl_module_empty'),
            'class.required'  => Lang::get('acl.acl_class_empty'),
            'pid.numeric'     => Lang::get('acl.acl_pid_empty'),
            'pid.required'    => Lang::get('acl.acl_pid_empty'),
            'action.required' => Lang::get('acl.acl_action_empty')
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
     * 编辑用户权限的时候的表单验证
     *
     * @access public
     */
    public function edit(\App\Services\Admin\Acl\Param\AclSave $data)
    {
        return $this->add($data);
    }
    
}
