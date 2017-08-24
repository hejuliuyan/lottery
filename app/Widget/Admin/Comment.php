<?php

namespace App\Widget\Admin;

use App\Widget\Admin\AbstractBase;

/**
 * 文章评论小组件
 *
 * @author jiang <mylampblog@163.com>
 */
class Comment extends AbstractBase
{
    /**
     * 文章评论删除操作
     *
     * @access public
     */
    public function delete($data)
    {
        $this->setCurrentAction('comment', 'delete', 'blog')->checkPermission();
        $url = R('common', $this->module.'.'.$this->class.'.'.$this->function, ['id' => $data['id']]);
        $html = $this->hasPermission ?
                    '<a title="删除" href="javascript:ajaxDelete(\''.$url.'\', \'ajax-reload\', \'确定吗？\');"><i class="fa fa-trash-o"></i></a>'
                        : '<i class="fa fa-trash-o" style="color:#ccc"></i>';
        return $html;
    }

    /**
     * 评论批量删除
     *
     * @access public
     */
    public function deleteSelect()
    {
        $this->setCurrentAction('comment', 'delete', 'blog')->checkPermission();
        $html = $this->hasPermission ?
                    '<div class="btn-group btn-group-sm" style="float:left;margin:10px 0;margin-right:10px;"><a class="btn btn-primary pl-delete" data-loading="处理中..." ><i class="fa fa-trash-o"></i> <span class="sys-btn-submit-str">批量删除</span></a></div>'
                        : '';
        return $html;
    }

    /**
     * 文章评论回复
     *
     * @access public
     */
    public function reply($data)
    {
        $this->setCurrentAction('comment', 'reply', 'blog')->checkPermission();
        $html = $this->hasPermission ?
                    '<a title="回复" href="javascript:;" class="comment-reply" data-id="'.$data['id'].'"><i class="fa fa-reply"></i></a>'
                        : '<i class="fa fa-reply" style="color:#ccc"></i>';
        return ['html' => $html, 'hasPermission' => $this->hasPermission];
    }

}