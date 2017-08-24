<?php

namespace App\Widget\Admin;

use App\Services\Admin\Acl\Acl;

/**
 * 小组件
 *
 * @author jiang <mylampblog@163.com>
 */
Abstract class AbstractBase
{
    /**
     * 权限处理类对象
     *
     * @var object
     */
    protected $acl;

    /**
     * 传入过来的数据
     * 
     * @var array
     */
    protected $data;

    /**
     * 当前module
     * 
     * @var string
     */
    protected $module;

    /**
     * 当前class
     * 
     * @var string
     */
    protected $class;

    /**
     * 当前function
     * 
     * @var string
     */
    protected $function;

    /**
     * 标识是否有权限
     *
     * @var boolean
     */
    protected $hasPermission;

    /**
     * 初始化
     */
    public function __construct()
    {
        $this->acl = new Acl();
    }

    /**
     * 设置当前请求的module,class,function
     *
     * @param string $class 类
     * @param string $function 函数
     * @param string $module 模块
     * @access public
     * @return object $this
     */
    public function setCurrentAction($class, $function, $module = '')
    {
        $this->module = $module;
        $this->class = $class;
        $this->function = $function;
        return $this;
    }

    /**
     * 设置传进来的额外的数据
     * 
     * @param array $data
     * @return object $this
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * 检测是否有权限
     *
     * @param string $type 取值为Acl::GROUP_LEVEL_TYPE_LEVEL, Acl::GROUP_LEVEL_TYPE_USER, Acl::GROUP_LEVEL_TYPE_GROUP
     * @access protected
     */
    protected function checkPermission($type = NULL)
    {
        $this->hasPermission = $this->acl->checkIfHasPermission($this->module, $this->class, $this->function);
        if(isset($this->data['id']) && in_array($type, [Acl::GROUP_LEVEL_TYPE_LEVEL, Acl::GROUP_LEVEL_TYPE_USER, Acl::GROUP_LEVEL_TYPE_GROUP])
            && ! $this->acl->checkGroupLevelPermission($this->data['id'], $type))
                $this->hasPermission = false;
    }

}