<?php namespace App\Services\Admin\Login;

abstract class AbstractProcess {

    /**
     * 是否已经登录
     */
    abstract public function hasLogin();

    /**
     * 登录退出
     */
    abstract public function logout();

    /**
     * 检测登录
     */
    abstract public function check($username, $password);

    /**
     * 登录的数据验证
     */
    abstract public function validate($username, $password);

    /**
     * 登录密钥
     */
    abstract public function setPublicKey();
}