<?php namespace App\Services\Admin\User\Param;

use App\Services\Admin\AbstractParam;

/**
 * 用户操作有关的参数容器，固定参数，方便分离处理。
 *
 * @author jiang <mylampblog@163.com>
 */
class UserModifyPassword extends AbstractParam
{
    protected $oldPassword;

    protected $newPassword;

    protected $newPasswordRepeat;

    /**
     * setOldPassword
     * @param string $oldPassword 旧的密码
     */
    public function setOldPassword($oldPassword)
    {
        $this->oldPassword = $this->attributes['oldPassword'] = $oldPassword;
        return $this;
    }

    /**
     * setNewPassword
     * @param string $oldPassword 新的密码
     */
    public function setNewPassword($newPassword)
    {
        $this->newPassword = $this->attributes['newPassword'] = $newPassword;
        return $this;
    }

    /**
     * setNewPassword
     * @param string $oldPassword 新的密码
     */
    public function setNewPasswordRepeat($newPasswordRepeat)
    {
        $this->newPasswordRepeat = $this->attributes['newPasswordRepeat'] = $newPasswordRepeat;
        return $this;
    }

    
    
}
