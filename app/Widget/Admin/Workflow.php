<?php

namespace App\Widget\Admin;

use App\Widget\Admin\AbstractBase;
use App\Services\Admin\Acl\Acl;

/**
 * 工作流小组件
 *
 * @author jiang <mylampblog@163.com>
 */
class Workflow extends AbstractBase
{
    /**
     * 面包屑中的按钮
     *
     * @access public
     */
    public function navBtn()
    {
        $this->setCurrentAction('index', 'add', 'workflow')->checkPermission();
        $url = R('common', $this->module.'.'.$this->class.'.'.$this->function);
        $html = $this->hasPermission ?
                    '<div class="btn-group" style="float:right;"><a href="'.$url.'" title="增加工作流" class="btn btn-primary btn-xs"><span aria-hidden="true" class="glyphicon glyphicon-plus"></span>增加工作流</a></div>'
                        : '';
        return $html;
    }

    /**
     * 工作流管理列表编辑操作
     *
     * @access public
     */
    public function edit($data)
    {
        $this->setCurrentAction('index', 'edit', 'workflow')->checkPermission();
        $url = R('common', $this->module.'.'.$this->class.'.'.$this->function, ['id' => $data['id']]);
        $html = $this->hasPermission ?
                    '<a href="'.$url.'"><i class="fa fa-pencil"></i></a>'
                        : '<i class="fa fa-pencil" style="color:#ccc"></i>';
        return $html;
    }

    /**
     * 工作流管理列表删除操作
     *
     * @access public
     */
    public function delete($data)
    {
        $this->setCurrentAction('index', 'delete', 'workflow')->checkPermission();
        $url = R('common', $this->module.'.'.$this->class.'.'.$this->function, ['id' => $data['id']]);
        $html = $this->hasPermission ?
                    '<a href="javascript:ajaxDelete(\''.$url.'\', \'sys-list\', \'确定吗？\');"><i class="fa fa-trash-o"></i></a>'
                        : '<i class="fa fa-trash-o" style="color:#ccc"></i>';
        return $html;
    }

    /**
     * 工作流管理列表详情
     *
     * @access public
     */
    public function detail($data)
    {
        $this->setCurrentAction('step', 'index', 'workflow')->checkPermission();
        $url = R('common', $this->module.'.'.$this->class.'.'.$this->function, ['id' => $data['id']]);
        $html = $this->hasPermission ?
                    '<a title="详情" href="'.$url.'"><i class="fa fa-list"></i></a>'
                        : '<i class="fa fa-list" style="color:#ccc"></i>';
        return $html;
    }

}