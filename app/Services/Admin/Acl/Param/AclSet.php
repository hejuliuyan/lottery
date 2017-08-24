<?php namespace App\Services\Admin\Acl\Param;

use App\Services\Admin\AbstractParam;

/**
 * 权限操作有关的参数容器，固定参数，方便分离处理。
 *
 * @author jiang <mylampblog@163.com>
 */
class AclSet extends AbstractParam
{
    protected $permission;

    protected $all;

    protected $id;

    public function setPermission($permission)
    {
        $this->permission = $this->attributes['permission'] = (array) $permission;
        return $this;
    }

    public function setAll($all)
    {
        $this->all = $this->attributes['all'] = $all;
        return $this;
    }

    public function setId($id)
    {
        $this->id = $this->attributes['id'] = $id;
        return $this;
    }

}
