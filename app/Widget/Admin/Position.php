<?php

namespace App\Widget\Admin;

use App\Widget\Admin\AbstractBase;

/**
 * 推荐位列表小组件
 *
 * @author jiang <mylampblog@163.com>
 */
class Position extends AbstractBase
{
    /**
     * 推荐位列表编辑操作
     *
     * @access public
     */
    public function edit($data)
    {
        $this->setCurrentAction('position', 'edit', 'blog')->checkPermission();
        $url = R('common', $this->module.'.'.$this->class.'.'.$this->function, ['id' => $data['id']]);
        $html = $this->hasPermission ?
                    '<a href="'.$url.'"><i class="fa fa-pencil"></i></a>'
                        : '<i class="fa fa-pencil" style="color:#ccc"></i>';
        return $html;
    }

    /**
     * 推荐位列表删除操作
     *
     * @access public
     */
    public function delete($data)
    {
        $this->setCurrentAction('position', 'delete', 'blog')->checkPermission();
        $url = R('common', $this->module.'.'.$this->class.'.'.$this->function, ['id' => $data['id']]);
        $html = $this->hasPermission ?
                    '<a href="javascript:ajaxDelete(\''.$url.'\', \'sys-list\', \'确定吗？\');"><i class="fa fa-trash-o"></i></a>'
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
        $this->setCurrentAction('position', 'add', 'blog')->checkPermission();
        $url = R('common', $this->module.'.'.$this->class.'.'.$this->function);
        $html = $this->hasPermission ?
                    '<div class="btn-group" style="float:right;"><a href="'.$url.'" title="增加推荐位" class="btn btn-primary btn-xs"><span aria-hidden="true" class="glyphicon glyphicon-plus"></span>增加推荐位</a></div>'
                        : '';
        return $html;
    }

    /**
     * 工作流管理列表详情
     *
     * @access public
     */
    public function relation($data)
    {
        $this->setCurrentAction('position', 'relation', 'blog')->checkPermission();
        $url = R('common', $this->module.'.'.$this->class.'.'.$this->function, ['position' => $data['id']]);
        $html = $this->hasPermission ?
                    '<a title="关联的文章" href="'.$url.'"><i class="fa fa-list"></i></a>'
                        : '<i class="fa fa-list" style="color:#ccc"></i>';
        return $html;
    }

    /**
     * 推荐位列表删除文章关联操作
     *
     * @access public
     */
    public function deleteRelation($data)
    {
        $this->setCurrentAction('position', 'delrelation', 'blog')->checkPermission();
        $url = R('common', $this->module.'.'.$this->class.'.'.$this->function, ['prid' => $data['id']]);
        $html = $this->hasPermission ?
                    '<a title="取消关联" href="javascript:ajaxDelete(\''.$url.'\', \'ajax-reload\', \'确定吗？\');"><i class="fa fa-trash-o"></i></a>'
                        : '<i class="fa fa-trash-o" style="color:#ccc"></i>';
        return $html;
    }

    /**
     * 批量删除文章关联
     *
     * @access public
     */
    public function deleteSelectRelation()
    {
        $this->setCurrentAction('position', 'delrelation', 'blog')->checkPermission();
        $html = $this->hasPermission ?
                    '<div class="btn-group btn-group-sm" style="float:left;margin:10px 0;margin-right:10px;"><a class="btn btn-primary pl-delete" data-loading="处理中..." ><i class="fa fa-trash-o"></i> <span class="sys-btn-submit-str">取消关联</span></a></div>'
                        : '';
        return $html;
    }

    /**
     * 批量删除文章关联
     *
     * @access public
     */
    public function relationSort()
    {
        $this->setCurrentAction('position', 'relationsort', 'blog')->checkPermission();
        $html = $this->hasPermission ?
                    '<div class="btn-group btn-group-sm" style="float:left;margin:10px 0;margin-right:10px;"><a class="btn btn-primary pl-sort" data-loading="处理中..." ><i class="fa fa-sort"></i> <span class="sys-btn-submit-str">排序</span></a></div>'
                        : '';
        return $html;
    }

}