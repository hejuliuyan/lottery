<?php namespace App\Services\Admin\Category\Validate;

use Validator, Lang;
use App\Services\Admin\BaseValidate;

/**
 * 用户组列表表单验证
 *
 * @author jiang <mylampblog@163.com>
 */
class Category extends BaseValidate
{
    /**
     * 增加用户组的时候的表单验证
     *
     * @access public
     */
    public function add(\App\Services\Admin\Category\Param\CategorySave $data)
    {
        // 创建验证规则
        $rules = array(
            'name' => 'required',
            'is_active' => 'required'
        );
        
        // 自定义验证消息
        $messages = array(
            'name.required' => Lang::get('category.name_empty'),
            'is_active.required' => Lang::get('category.is_active_empty')
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
    public function edit(\App\Services\Admin\Category\Param\CategorySave $data)
    {
        return $this->add($data);
    }
    
}
