<?php namespace App\Services\Admin;

use App\Services\Admin\SC;

/**
 * 主要用来储存当前请求的模块、类、函数
 *
 * @author jiang <mylampblog@163.com>
 */
class MCAManager {

    /**
     * 当前类绑定到容器中的标识
     *
     * @var string
     */
    CONST MAC_BIND_NAME = 'mac';

    /**
     * 标识为一级菜单
     *
     * @var int
     */
    CONST MENU_LEVEL_FIRST = 1;

    /**
     * 标识为二级菜单
     *
     * @var int
     */
    CONST MENU_LEVEL_SECOND = 2;

    /**
     * 标识为三级菜单
     *
     * @var int
     */
    CONST MENU_LEVEL_THIRD = 3;

    /**
     * 当前请求的模块
     * 
     * @var string
     */
    private $module;

    /**
     * 当前请求的类
     * 
     * @var string
     */
    private $class;

    /**
     * 当前请求的函数
     * 
     * @var string
     */
    private $action;

    /**
     * 当前请求所对应的详细的功能信息
     * 
     * @var array
     */
    private $currentMCA;

    /**
     * 当前登录用户的所有权限信息
     * 
     * @var array
     */
    private $userPermission;

    /**
     * set current module
     * 
     * @param string $module
     */
    public function setModule($module)
    {
        $this->module = $module;
        return $this;
    }

    /**
     * set current action
     * 
     * @param string $action
     */
    public function setAction($action)
    {
        $this->action = $action;
        return $this;
    }

    /**
     * set current class
     * 
     * @param string $class
     */
    public function setClass($class)
    {
        $this->class = $class;
        return $this;
    }

    /**
     * get current module
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * get current action
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * get current class
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * 取得当前的操作的功能信息
     * 
     * @return array 功能信息
     */
    public function getCurrentMCAInfo()
    {
        return $this->currentMCAInfo();
    }

    /**
     * 取得当前操作所属的顶级菜单信息
     * 
     * @return array 功能信息
     */
    public function getCurrentMCAfatherMenuInfo()
    {
        return $this->searchMCAMatchMenuLevelForCurrentMCA(self::MENU_LEVEL_FIRST, $this->currentMCAInfo());
    }

    /**
     * 取得当前操作所属的二级菜单信息
     * 
     * @return array 功能信息
     */
    public function getCurrentMCASecondFatherMenuInfo()
    {
        return $this->searchMCAMatchMenuLevelForCurrentMCA(self::MENU_LEVEL_SECOND, $this->currentMCAInfo());
    }

    /**
     * 当前请求所对应的一级菜单，这里只考虑三层的情况
     * 
     * @param  string $module 模块
     * @param  string $class  类
     * @param  string $action 函数
     * @return true|false
     */
    public function matchFirstMenu($module, $class, $action)
    {
        $currentMCAInfo = $this->currentMCAInfo();
        if($currentMCAInfo['level'] == self::MENU_LEVEL_FIRST)
        {
            $menuInfo = $currentMCAInfo;
        }
        else
        {
            $menuInfo = $this->searchMCAMatchMenuLevelForCurrentMCA(self::MENU_LEVEL_FIRST, $currentMCAInfo);
        }
        if(empty($menuInfo)) return false;
        if($module == $menuInfo['module'] and $class == $menuInfo['class'] and $action == $menuInfo['action']) return true;
        return false;
    }

    /**
     * 当前请求所对应的二级菜单，这里只考虑三层的情况
     * 
     * @param  string $module 模块
     * @param  string $class  类
     * @param  string $action 函数
     * @return true|false
     */
    public function matchSecondMenu($module, $class, $action)
    {
        $currentMCAInfo = $this->currentMCAInfo();
        if($currentMCAInfo['level'] == self::MENU_LEVEL_SECOND)
        {
            $menuInfo = $currentMCAInfo;
        }
        else
        {
            $menuInfo = $this->searchMCAMatchMenuLevelForCurrentMCA(self::MENU_LEVEL_SECOND, $currentMCAInfo);
        }
        if(empty($menuInfo)) return false;
        if($module == $menuInfo['module'] and $class == $menuInfo['class'] and $action == $menuInfo['action']) return true;
        return false;
    }

    /**
     * 当前请求所对应的三级菜单，这里只考虑三层的情况
     * 
     * @param  string $module 模块
     * @param  string $class  类
     * @param  string $action 函数
     * @return true|false
     */
    public function matchThirdMenu($module, $class, $action)
    {
        $currentMCAInfo = $this->currentMCAInfo();
        if($currentMCAInfo['level'] == self::MENU_LEVEL_THIRD)
        {
            $menuInfo = $currentMCAInfo;
        }
        else
        {
            $menuInfo = $this->searchMCAMatchMenuLevelForCurrentMCA(self::MENU_LEVEL_THIRD, $currentMCAInfo);
        }
        if(empty($menuInfo)) return false;
        if($module == $menuInfo['module'] and $class == $menuInfo['class'] and $action == $menuInfo['action']) return true;
        return false;
    }

    /**
     * 根据当前的请求查找符合要求的权限信息
     * 
     * @param int $level 几级菜单但不是一级菜单
     * @return array
     */
    private function searchMCAMatchMenuLevelForCurrentMCA($menuLevel, $currentMCAInfo)
    {
        $userPermission = $this->getUserPermission();
        foreach($userPermission as $key => $value)
        {
            if($currentMCAInfo['pid'] == $value['id'] and ! empty($value['id']))
            {
                if($value['level'] == $menuLevel) return $value;
                return $this->searchMCAMatchMenuLevelForCurrentMCA($menuLevel, $value);
            }
        }
        return [];
    }

    /**
     * 当前请求所对应的功能信息
     * 
     * @return array
     */
    private function currentMCAInfo()
    {
        if( ! $this->currentMCA)
        {
            $userPermission = $this->getUserPermission();
            foreach($userPermission as $key => $value)
            {
                if($this->matchCurrentMCA($value))
                {
                    $this->currentMCA = $value;
                    break;
                }
            }
        }
        return $this->currentMCA;
    }

    /**
     * find match mca
     */
    private function matchCurrentMCA($value)
    {
        if($this->getModule() == $value['module']
            and $this->getClass() == $value['class']
                and $this->getAction() == $value['action'])
            return true;
        return false;
    }

    /**
     * return user permission
     */
    private function getUserPermission()
    {
        if( ! $this->userPermission)
            $this->userPermission = SC::getUserPermissionSession();
        return $this->userPermission;
    }

}