<?php namespace App\Services\Home\Comment\Validate;

use Validator, Lang;
use App\Services\Home\BaseValidate;

/**
 * 功能表单验证
 *
 * @author jiang <mylampblog@163.com>
 */
class Comment extends BaseValidate
{
    /**
     * 增加评论的表单验证
     *
     * @access public
     */
    public function add($data)
    {
        //创建验证规则
        $rules = array(
            'object_id'    => 'required',
            'object_type'   => 'required',
            'content'     => 'required',
            'nickname'  => 'required',
        );
        
        //自定义验证消息
        $messages = array(
            'object_id.required'   => Lang::get('home.comment_object_id_empty'),
            'object_type.required'  => Lang::get('home.comment_object_type_empty'),
            'nickname.required'    => Lang::get('home.comment_nickname_empty'),
            'content.required' => Lang::get('home.comment_content_empty')
        );
        
        //开始验证
        $validator = Validator::make($data, $rules, $messages);
        if($validator->fails())
        {
            $this->errorMsg = $validator->messages()->first();
            return false;
        }
        return true;
    }
    
}
