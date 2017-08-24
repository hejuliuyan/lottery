<?php

namespace App\Widget\Admin;

use App\Widget\Admin\AbstractBase;
use App\Services\Admin\Acl\Acl as AclManager;

/**
 * 权限列表小组件
 *
 * @author jiang <mylampblog@163.com>
 */
class Acl extends AbstractBase
{
    /**
     * 权限列表编辑操作
     *
     * @access public
     */
    public function edit($data)
    {
        $this->setCurrentAction('acl', 'edit', 'foundation')->checkPermission();
        $url = R('common', $this->module.'.'.$this->class.'.'.$this->function, ['id' => url_param_encode($data['id'])]);
        $html = $this->hasPermission ?
                    '<a href="'.$url.'"><i class="fa fa-pencil"></i></a>'
                        : '<i class="fa fa-pencil" style="color:#ccc"></i>';
        return $html;
    }

    /**
     * 权限列表删除操作
     *
     * @access public
     */
    public function delete($data)
    {
        $this->setCurrentAction('acl', 'delete', 'foundation')->checkPermission();
        $url = R('common', $this->module.'.'.$this->class.'.'.$this->function, ['id' => url_param_encode($data['id'])]);
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
        $this->setCurrentAction('acl', 'add', 'foundation')->checkPermission();
        $url = R('common', $this->module.'.'.$this->class.'.'.$this->function);
        $html = $this->hasPermission ?
                    '<div class="btn-group" style="float:right;"><a href="'.$url.'" title="增加新的功能" class="btn btn-primary btn-xs"><span aria-hidden="true" class="glyphicon glyphicon-plus"></span>增加新的功能</a></div>'
                        : '';
        return $html;
    }

    /**
     * 排序的按钮
     *
     * @access public
     */
    public function sort()
    {
        $this->setCurrentAction('acl', 'sort', 'foundation')->checkPermission();
        $html = $this->hasPermission ?
                    '<div class="btn-group" style="float:left;margin:10px 0;margin-right:20px;"><a class="btn btn-primary btn-sm sys-btn-submit" data-loading="处理中..." ><i class="fa fa-sort"></i> <span class="sys-btn-submit-str">排序</span></a></div>'
                        : '';
        return $html;
    }

    /**
     * 子项目用到的key
     * 
     * @var string
     */
    private $son;

    /**
     * 递归select中的option下拉表单，用于权限增加和编辑
     * 
     * @param  array $datas 数据源
     * @param  mixed $prefix 下拉表单的线，只能传false
     * @return html 返回组装好的option代码
     */
    public function acllist(array $datas, $pid, $prefix = false)
    {
        $html = '';

        if( ! $this->son) $this->son = \App\Services\Admin\Tree::getSonKey();
        
        foreach($datas as $key => $value)
        {
            if($prefix === false)
            {
                if($pid != $value['id'] && $pid != 'all') continue;
            }
            $line = ($prefix === false ? '' : $prefix).'┆┄';
            $html .= view('admin.acl.list', compact('value', 'prefix'));
            if(isset($value[$this->son]) && is_array($value[$this->son]))
            {
                $html .= $this->acllist($value[$this->son], $pid, $line);
            }
        }
        return $html;
    }

}