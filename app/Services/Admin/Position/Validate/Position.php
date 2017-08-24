<?php namespace App\Services\Admin\Position\Validate;

use Validator, Lang;
use App\Services\Admin\BaseValidate;

/**
 * 增加文章推荐位表单验证
 *
 * @author jiang <mylampblog@163.com>
 */
class Position extends BaseValidate
{
    /**
     * 增加文章推荐位的时候的表单验证
     *
     * @access public
     */
    public function add(\App\Services\Admin\Position\Param\PositionSave $data)
    {
        // 创建验证规则
        $rules = array(
            'name' => 'required',
            'is_active' => 'required'
        );
        
        // 自定义验证消息
        $messages = array(
            'name.required' => Lang::get('position.name_empty'),
            'is_active.required' => Lang::get('position.is_active_empty')
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
     * 编辑文章推荐位的时候的表单验证
     *
     * @access public
     */
    public function edit(\App\Services\Admin\Position\Param\PositionSave $data)
    {
        return $this->add($data);
    }
    
}
