<?php

namespace App\Http\Controllers\Admin\Foundation;

use App\Http\Controllers\Admin\Controller;
use App\Models\Admin\Permission as PermissionModel;
use App\Models\Admin\Access as AccessModel;
use App\Models\Admin\User as UserModel;
use App\Models\Admin\Group as GroupModel;
use Request, Lang, Session;
use App\Services\Admin\Acl\Process as AclActionProcess;
use App\Libraries\Js;
use App\Services\Admin\Acl\Acl;
use App\Services\Admin\Tree;
use App\Services\Admin\SC;

/**
 * 权限菜单相关
 *
 * @author jiang <mylampblog@163.com>
 */
class AclController extends Controller
{
    /**
     * 显示权限列表首页
     *
     * @access public
     */
    public function index()
    {
        Session::flashInput(['http_referer' => Request::fullUrl()]);
        $pid = (int) Request::input('pid', 'all');
        $permissionModel = new PermissionModel();
        $list = $permissionModel->getAllAccessPermission();
        $list = Tree::genTree($list);
        return view('admin.acl.index', compact('list', 'pid'));
    }

    /**
     * 增加权限功能
     *
     * @access public
     */
    public function add()
    {
        if(Request::method() == 'POST') return $this->savePermissionToDatabase();
        $formUrl = R('common', 'foundation.acl.add');
        $list = (new PermissionModel())->getAllAccessPermission();
        $select = Tree::dropDownSelect(Tree::genTree($list));
        return view('admin.acl.add', compact('select', 'formUrl'));
    }

    /**
     * 增加功能权限入库处理
     *
     * @access private
     */
    private function savePermissionToDatabase()
    {
        $data = (array) Request::input('data');
        $data['add_time'] = time();
        $params = new \App\Services\Admin\Acl\Param\AclSave();
        $params->setAttributes($data);
        $manager = new AclActionProcess();
        if($manager->addAcl($params) !== false) return Js::locate(R('common', 'foundation.acl.index'), 'parent');
        return Js::error($manager->getErrorMessage());
    }
    
    /**
     * 删除权限功能
     *
     * @access public
     * @todo 只能删除自己所拥有的权限？有没有必要做？
     */
    public function delete()
    {
        $id = Request::input('id');
        if( ! is_array($id))
        {
            if( ! $id = url_param_decode($id)) return responseJson(Lang::get('common.action_error'));
            $id = array($id);
        }
        $id = array_map('intval', $id);
        $manager = new AclActionProcess();
        if($manager->detele($id) !== false) return responseJson(Lang::get('common.action_success'), true);;
        return responseJson($manager->getErrorMessage());
    }
    
    /**
     * 编辑权限功能
     *
     * @access public
     */
    public function edit()
    {
        if(Request::method() == 'POST') return $this->updatePermissionToDatabase();
        Session::flashInput(['http_referer' => Session::getOldInput('http_referer')]);
        $id = Request::input('id');
        $permissionId = url_param_decode($id);
        if( ! $permissionId or ! is_numeric($permissionId)) return Js::error(Lang::get('common.illegal_operation'), true);
        $permissionModel = new PermissionModel();
        $list = (array) Tree::genTree($permissionModel->getAllAccessPermission());
        $permissionInfo = $permissionModel->getOnePermissionById(intval($permissionId));
        if(empty($permissionInfo)) return Js::error(Lang::get('common.acl_not_found'), true);
        $select = Tree::dropDownSelect($list, $permissionInfo['pid']);
        $formUrl = R('common', 'foundation.acl.edit');
        return view('admin.acl.add', compact('select', 'permissionInfo', 'formUrl', 'id'));
    }
    
    /**
     * 编辑功能权限入库处理
     *
     * @access private
     */
    private function updatePermissionToDatabase()
    {
        $httpReferer = Session::getOldInput('http_referer');
        $data = Request::input('data');
        if( ! $data) return Js::error(Lang::get('common.info_incomplete'));
        $params = new \App\Services\Admin\Acl\Param\AclSave();
        $params->setAttributes($data);
        $manager = new AclActionProcess();
        if($manager->editAcl($params) !== false)
        {
            $backUrl = ( ! empty($httpReferer)) ? $httpReferer : R('common', 'foundation.acl.index'); 
            return Js::locate($backUrl, 'parent');
        }
        return Js::error($manager->getErrorMessage());
    }
    
    /**
     * 排序权限功能
     *
     * @access public
     */
    public function sort()
    {
        $sort = Request::input('sort');
        if( ! $sort or ! is_array($sort)) return Js::error(Lang::get('common.choose_checked'));
        foreach($sort as $key => $value)
        {
            if((new PermissionModel())->sortPermission($key, $value) === false) $err = true;
        }
        if(isset($err)) return Js::error(Lang::get('common.action_error'));
        return Js::locate(R('common', 'foundation.acl.index'), 'parent');
    }

    /**
     * 对用户进行权限设置
     * 
     * @access public
     */
    public function user()
    {
        if(Request::method() == 'POST') return $this->saveUserPermissionToDatabase();
        $id = url_param_decode(Request::input('id'));
        if( ! $id or ! is_numeric($id)) return Js::error(Lang::get('common.illegal_operation'), true);
        $info = (new UserModel())->getOneUserById(intval($id));
        if(empty($info)) return Js::error(Lang::get('common.illegal_operation'), true);
        if( ! (new Acl())->checkGroupLevelPermission($id, Acl::GROUP_LEVEL_TYPE_USER)) return Js::error(Lang::get('common.account_level_deny'), true);

        //取回用户所拥有的权限列表
        $list = SC::getUserPermissionSession();

        //当前用户的权限
        $userAcl = (new AccessModel())->getUserAccessPermission(intval($id));
        $hasPermissions = array();
        foreach($userAcl as $key => $value)
        {
            $hasPermissions[] = $value['permission_id'];
        }

        //为ztree做数据准备
        $zTree = []; $all = [];
        foreach($list as $key => $value)
        {
            $arr = ['id' => $value['id'], 'pId' => $value['pid'], 'name' => $value['name'], 'open' => true];
            if(in_array($value['id'], $hasPermissions)) $arr['checked'] = true;
            $zTree[] = $arr;
            $all[] = $value['id'];
        }

        $router = 'user';
        return view('admin.acl.setpermission',
            compact('zTree', 'id', 'info', 'router', 'all')
        );
    }

    /**
     * 用户权限入库
     * 
     * @return boolean true|false
     */
    private function saveUserPermissionToDatabase()
    {
        $this->checkFormHash();
        $permissions = (array) Request::input('permission');
        $id = Request::input('id');
        $all = Request::input('all');
        if( ! $id or ! is_numeric($id) or ! $all) return responseJson(Lang::get('common.illegal_operation'));
        $params = new \App\Services\Admin\Acl\Param\AclSet();
        $params->setPermission($permissions)->setAll($all)->setId($id);
        $manager = new AclActionProcess();
        $result = $manager->setUserAcl($params);
        if($result)
        {
            $this->setActionLog();
            return responseJson(Lang::get('common.action_success'));
        }
        return responseJson($manager->getErrorMessage());
    }
    
    /**
     * 对用户组进行权限设置
     * 
     * @access public
     */
    public function group()
    {
        if(Request::method() == 'POST') return $this->saveGroupPermissionToDatabase();
        $id = url_param_decode(Request::input('id'));
        if( ! $id or ! is_numeric($id)) return Js::error(Lang::get('common.illegal_operation'), true);
        $info = (new GroupModel())->getOneGroupById(intval($id));
        if(empty($info)) return Js::error(Lang::get('common.illegal_operation'), true);
        if( ! (new Acl())->checkGroupLevelPermission($id, Acl::GROUP_LEVEL_TYPE_GROUP)) return Js::error(Lang::get('common.account_level_deny'), true);
        
        //取回用户组所拥有的权限列表
        $list = (array) SC::getUserPermissionSession();

        //当前所要编辑的用户组的权限，用于标识是否已经勾选
        $groupAcl = (new AccessModel())->getGroupAccessPermission(intval($id));
        $hasPermissions = array();
        foreach($groupAcl as $key => $value)
        {
            $hasPermissions[] = $value['permission_id'];
        }

        //为ztree做数据准备
        $zTree = []; $all = [];
        foreach($list as $key => $value)
        {
            $arr = ['id' => $value['id'], 'pId' => $value['pid'], 'name' => $value['name'], 'open' => true];
            if(in_array($value['id'], $hasPermissions)) $arr['checked'] = true;
            $zTree[] = $arr;
            $all[] = $value['id'];
        }

        $router = 'group';
        return view('admin.acl.setpermission',
            compact('zTree', 'id', 'info', 'router', 'all')
        );
    }

    /**
     * 用户组权限入库
     * 
     * @return boolean true|false
     */
    private function saveGroupPermissionToDatabase()
    {
        $this->checkFormHash();
        $permissions = (array) Request::input('permission');
        $id = Request::input('id');
        $all = Request::input('all');
        if( ! $id or ! is_numeric($id) or ! $all) return responseJson(Lang::get('common.illegal_operation'));
        if( ! (new Acl())->checkGroupLevelPermission($id, Acl::GROUP_LEVEL_TYPE_GROUP)) return responseJson(Lang::get('common.account_level_deny'));
        $params = new \App\Services\Admin\Acl\Param\AclSet();
        $params->setPermission($permissions)->setAll($all)->setId($id);
        $manager = new AclActionProcess();
        $result = $manager->setGroupAcl($params);
        if($result)
        {
            $this->setActionLog();
            return responseJson(Lang::get('common.action_success'));
        }
        return responseJson($manager->getErrorMessage());
    }

}