<?php

namespace App\Widget\Admin;

use App\Widget\Admin\AbstractBase;
use App\Models\Admin\Position as PositionModel;

/**
 * 文章列表小组件
 *
 * @author jiang <mylampblog@163.com>
 */
class Content extends AbstractBase
{
    /**
     * 文章列表编辑操作
     *
     * @access public
     */
    public function edit($data)
    {
        $this->setCurrentAction('content', 'edit', 'blog')->checkPermission();
        $url = R('common', $this->module.'.'.$this->class.'.'.$this->function, ['id' => $data['id']]);
        $html = $this->hasPermission ?
                    '<a href="'.$url.'"><i class="fa fa-pencil"></i></a>'
                        : '<i class="fa fa-pencil" style="color:#ccc"></i>';
        return $html;
    }

    /**
     * 文章列表删除操作
     *
     * @access public
     */
    public function delete($data)
    {
        $this->setCurrentAction('content', 'delete', 'blog')->checkPermission();
        $url = R('common', $this->module.'.'.$this->class.'.'.$this->function, ['id' => $data['id']]);
        $html = $this->hasPermission ?
                    '<a href="javascript:ajaxDelete(\''.$url.'\', \'ajax-reload\', \'确定吗？\');"><i class="fa fa-trash-o"></i></a>'
                        : '<i class="fa fa-trash-o" style="color:#ccc"></i>';
        return $html;
    }

    /**
     * 面包屑中的按钮
     *
     * @access public
     */
    public function navBtn()
    {
        $this->setCurrentAction('content', 'add', 'blog')->checkPermission();
        $url = R('common', $this->module.'.'.$this->class.'.'.$this->function);
        $html = $this->hasPermission ?
                    '<div class="btn-group" style="float:right;"><a href="'.$url.'" title="增加文章" class="btn btn-primary btn-xs"><span aria-hidden="true" class="glyphicon glyphicon-plus"></span>增加文章</a></div>'
                        : '';
        return $html;
    }

    /**
     * 批量删除
     *
     * @access public
     */
    public function deleteSelect()
    {
        $this->setCurrentAction('content', 'delete', 'blog')->checkPermission();
        $html = $this->hasPermission ?
                    '<div class="btn-group btn-group-sm" style="float:left;margin:10px 0;margin-right:10px;"><a class="btn btn-primary pl-delete" data-loading="处理中..." ><i class="fa fa-trash-o"></i> <span class="sys-btn-submit-str">批量删除</span></a></div>'
                        : '';
        return $html;
    }

    /**
     * 文章推到推荐位
     *
     * @access public
     */
    public function position()
    {
        $this->setCurrentAction('content', 'position', 'blog')->checkPermission();
        $html = $this->hasPermission ?
                    '<div class="btn-group btn-group-sm" style="float:left;margin:10px 0;margin-right:10px;"><a class="btn btn-primary pl-position" data-loading="处理中..." ><i class="fa fa-exchange"></i> <span class="sys-btn-submit-str">关联推荐位</span></a></div>'
                        : '';
        return $html;
    }

    /**
     * 推荐位弹窗的内容
     */
    public function positionDialogContent()
    {
        $this->setCurrentAction('content', 'position', 'blog')->checkPermission();
        $list = with(new PositionModel())->activePosition();
        $html = $this->hasPermission ?
                        view('admin.content.position_dialog_content', compact('list'))->render()
                        : '';
        return json_encode(['content' => $html]);
    }

}