<?php namespace App\Services\Admin\Acl\Param;

use App\Services\Admin\AbstractParam;

/**
 * 权限操作有关的参数容器，固定参数，方便分离处理。
 *
 * @author jiang <mylampblog@163.com>
 */
class AclSave extends AbstractParam
{
    protected $name;

    protected $module;

    protected $class;

    protected $action;

    protected $pid;

    protected $mark;

    protected $display;

    protected $add_time;

    protected $id;

    public function setName($name)
    {
        $this->name = $this->attributes['name'] = $name;
        return $this;
    }

    public function setModule($module)
    {
        $this->module = $this->attributes['module'] = $module;
        return $this;
    }

    public function setClass($class)
    {
        $this->class = $this->attributes['class'] = $class;
        return $this;
    }

    public function setAction($action)
    {
        $this->action = $this->attributes['action'] = $action;
        return $this;
    }

    public function setPid($pid)
    {
        $this->pid = $this->attributes['pid'] = $pid;
        return $this;
    }

    public function setMark($mark)
    {
        $this->mark = $this->attributes['mark'] = $mark;
        return $this;
    }

    public function setDisplay($display)
    {
        $this->display = $this->attributes['display'] = $display;
        return $this;
    }

    public function setAddTime($addTime)
    {
        $this->add_time = $this->attributes['add_time'] = $addTime;
        return $this;
    }

    public function setId($id)
    {
        $this->id = $this->attributes['id'] = $id;
        return $this;
    }

}
