<?php namespace App\Services\Admin\Content\Validate;

use Validator, Lang;
use App\Services\Admin\BaseValidate;

/**
 * 表单验证
 *
 * @author jiang <mylampblog@163.com>
 */
class Content extends BaseValidate
{
    /**
     * 增加文章的时候的表单验证
     *
     * @access public
     */
    public function add(\App\Services\Admin\Content\Param\ContentSave $data)
    {
        // 创建验证规则
        $rules = array(
            'title' => 'required',
            'summary' => 'required',
            'tags' => 'required',
            'classify' => 'required',
            'content' => 'required',
            'status' => 'required',
        );
        
        // 自定义验证消息
        $messages = array(
            'title.required' => Lang::get('content.title_empty'),
            'summary.required' => Lang::get('content.summary_empty'),
            'tags.required' => Lang::get('content.tags_empty'),
            'classify.required' => Lang::get('content.classify_empty'),
            'content.required' => Lang::get('content.content_empty'),
            'status.required' => Lang::get('content.status_empty')
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
     * 编辑文章的时候的表单验证
     *
     * @access public
     */
    public function edit(\App\Services\Admin\Content\Param\ContentSave $data)
    {
        return $this->add($data);
    }
    
}
