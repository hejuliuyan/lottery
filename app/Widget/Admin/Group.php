<?php

namespace App\Widget\Admin;

use App\Widget\Admin\AbstractBase;
use App\Services\Admin\Acl\Acl;

/**
 * 用户组列表小组件
 *
 * @author jiang <mylampblog@163.com>
 */
class Group extends AbstractBase
{
    /**
     * 用户组列表编辑操作
     *
     * @access public
     */
    public function edit($data)
    {
        $this->setCurrentAction('group', 'edit', 'foundation')->setData($data)->checkPermission(Acl::GROUP_LEVEL_TYPE_GROUP);
        $url = R('common', $this->module.'.'.$this->class.'.'.$this->function, ['id' => url_param_encode($data['id'])]);
        $html = $this->hasPermission ?
                    '<a href="'.$url.'"><i class="fa fa-pencil"></i></a>'
                        : '<i class="fa fa-pencil" style="color:#ccc"></i>';
        return $html;
    }

    /**
     * 用户组列表删除操作
     *
     * @access public
     */
    public function delete($data)
    {
        $this->setCurrentAction('group', 'delete', 'foundation')->setData($data)->checkPermission(Acl::GROUP_LEVEL_TYPE_GROUP);
        $url = R('common', $this->module.'.'.$this->class.'.'.$this->function, ['id' => url_param_encode($data['id'])]);
        $html = $this->hasPermission ?
                    '<a href="javascript:ajaxDelete(\''.$url.'\', \'sys-list\', \'确定吗？\');"><i class="fa fa-trash-o"></i></a>'
                        : '<i class="fa fa-trash-o" style="color:#ccc"></i>';
        return $html;
    }

    /**
     * 用户组列表删除操作
     *
     * @access public
     */
    public function acl($data)
    {
        $this->setCurrentAction('acl', 'group', 'foundation')->setData($data)->checkPermission(Acl::GROUP_LEVEL_TYPE_GROUP);
        $url = R('common', $this->module.'.'.$this->class.'.'.$this->function, ['id' => url_param_encode($data['id'])]);
        $html = $this->hasPermission ?
                    '<a href="'.$url.'"><i class="fa fa-user"></i></a>'
                        : '<i class="fa fa-user" style="color:#ccc"></i>';
        return $html;
    }

    /**
     * 面包屑中的按钮
     *
     * @access public
     */
    public function navBtn()
    {
        $this->setCurrentAction('group', 'add', 'foundation')->checkPermission(Acl::GROUP_LEVEL_TYPE_GROUP);
        $url = R('common', $this->module.'.'.$this->class.'.'.$this->function);
        $html = $this->hasPermission ?
                    '<div class="btn-group" style="float:right;"><a href="'.$url.'" title="增加新的用户组" class="btn btn-primary btn-xs"><span aria-hidden="true" class="glyphicon glyphicon-plus"></span>增加新的用户组</a></div>'
                        : '';
        return $html;
    }

}