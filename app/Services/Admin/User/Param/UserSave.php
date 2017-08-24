<?php namespace App\Services\Admin\User\Param;

use App\Services\Admin\AbstractParam;

/**
 * 用户操作有关的参数容器，固定参数，方便分离处理。
 *
 * @author jiang <mylampblog@163.com>
 */
class UserSave extends AbstractParam
{
    protected $name;

    protected $realname;

    protected $password;

    protected $mobile;

    protected $mark;

    protected $group_id;

    protected $add_time;

    protected $id;

    public function setName($name)
    {
        $this->name = $this->attributes['name'] = $name;
        return $this;
    }

    public function setRealname($realname)
    {
        $this->realname = $this->attributes['realname'] = $realname;
        return $this;
    }

    public function setPassword($password)
    {
        $this->password = $this->attributes['password'] = $password;
        return $this;
    }

    public function setMobile($mobile)
    {
        $this->mobile = $this->attributes['mobile'] = $mobile;
        return $this;
    }

    public function setMark($mark)
    {
        $this->mark = $this->attributes['mark'] = $mark;
        return $this;
    }

    public function setGroupId($group_id)
    {
        $this->group_id = $this->attributes['group_id'] = $group_id;
        return $this;
    }

    public function setAddTime($add_time)
    {
        $this->add_time = $this->attributes['add_time'] = $add_time;
        return $this;
    }

    public function setId($id)
    {
        $this->id = $this->attributes['id'] = $id;
        return $this;
    }
    
}
