<?php namespace App\Services\Admin;

use Session, Cookie, Request;

class SC {

    /**
     * 用户登录的session key
     */
    CONST LOGIN_MARK_SESSION_KEY = 'LOGIN_MARK_SESSION';

    /**
     * 密钥 session key
     */
    CONST PUBLIC_KEY = 'LOGIN_PROCESS_PUBLIC';

    /**
     * 设置用户权限的key
     *
     * @var string
     */
    CONST USER_ACL_SESSION_KEY = 'USER_ACL_SESSION';

    /**
     * 所有的权限的key
     *
     * @var string
     */
    CONST ALL_PERMISSION_KEY = 'ALL_PERMISSION_KEY';

    /**
     * 设置登录成功的session
     * 
     * @param array $userInfo 用户的相关信息
     */
    static public function setLoginSession($userInfo)
    {
        return Session::put(self::LOGIN_MARK_SESSION_KEY, $userInfo);
    }

    /**
     * 返回登录成功的session
     */
    static public function getLoginSession()
    {
        return Session::get(self::LOGIN_MARK_SESSION_KEY);
    }

    /**
     * 删除登录的session
     * 
     * @return void
     */
    static public function delLoginSession()
    {
        Session::forget(self::LOGIN_MARK_SESSION_KEY);
        Session::flush();
        Session::regenerate();
    }

    /**
     * 设置并返回加密密钥
     *
     * @return string 密钥
     */
    static public function setPublicKey()
    {
        $key = uniqid();
        Session::put(self::PUBLIC_KEY, $key);
        return $key;
    }

    /**
     * 取得刚才设置的加密密钥
     * 
     * @return string 密钥
     */
    static public function getPublicKey()
    {
        return Session::get(self::PUBLIC_KEY);
    }

    /**
     * 删除密钥
     * 
     * @return void
     */
    static public function delPublicKey()
    {
        Session::forget(self::PUBLIC_KEY);
        Session::flush();
        Session::regenerate();
    }

    /**
     * 把用户的权限保存到session中，方便系统使用。
     * 
     * @param array $aclArray
     * @access public
     * @return true|false
     */
    static public function setUserPermissionSession($aclArray)
    {
        return Session::put(self::USER_ACL_SESSION_KEY, $aclArray);
    }

    /**
     * 返回保存在session中的用户权限信息
     *
     * @access public
     */
    static public function getUserPermissionSession()
    {
        return Session::get(self::USER_ACL_SESSION_KEY);
    }

    /**
     * 把所有的权限保存到session中。
     * 
     * @access public
     * @return true|false
     */
    static public function setAllPermissionSession($allAclInfo)
    {
        return Session::put(self::ALL_PERMISSION_KEY, $allAclInfo);
    }

    /**
     * 返回保存在session中的所有权限信息
     *
     * @access public
     */
    static public function getAllPermissionSession()
    {
        return Session::get(self::ALL_PERMISSION_KEY);
    }

}