<?php

namespace App\Http\Controllers\Admin\Foundation;

use App\Http\Controllers\Admin\Controller;
use App\Models\Admin\Group as GroupModel;
use Request, Lang, Session;
use App\Services\Admin\Group\Process as GroupActionProcess;
use App\Libraries\Js;
use App\Services\Admin\Acl\Acl;

/**
 * 用户组管理
 *
 * @author jiang <mylampblog@163.com>
 */
class GroupController extends Controller
{
    /**
     * 显示用户组列表首页
     *
     * @access public
     */
    public function index()
    {
        Session::flashInput(['http_referer' => Request::fullUrl()]);
        $groupModel = new GroupModel();
        $grouplist = $groupModel->getAllGroupByPage();
        $page = $grouplist->setPath('')->appends(Request::all())->render();
        return view('admin.group.index', compact('grouplist', 'page'));
    }
    
    /**
     * 增加用户组
     *
     * @access public
     */
    public function add()
    {
        if(Request::method() == 'POST') return $this->saveDatasToDatabase();
        $formUrl = R('common', 'foundation.group.add');
        return view('admin.group.add', compact('formUrl'));
    }
    
    /**
     * 增加用户组入库处理
     *
     * @access private
     */
    private function saveDatasToDatabase()
    {
        $data = (array) Request::input('data');
        $params = new \App\Services\Admin\Group\Param\GroupSave();
        $params->setAttributes($data);
        $manager = new GroupActionProcess();
        if($manager->addGroup($params) !== false)
        {
            $this->setActionLog();
            return Js::locate(R('common', 'foundation.group.index'), 'parent');
        }
        return Js::error($manager->getErrorMessage());
    }

    /**
     * 删除用户组
     *
     * @access public
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
        $groupModel = new GroupModel();
        $groupInfos = $groupModel->getGroupInIds($id);
        $manager = new GroupActionProcess();
        if($manager->detele($id))
        {
            $this->setActionLog(['groupInfos' => $groupInfos]);
            return responseJson(Lang::get('common.action_success'), true);
        }
        return responseJson($manager->getErrorMessage());
    }
    
    /**
     * 编辑用户组
     *
     * @access public
     */
    public function edit()
    {
        if(Request::method() == 'POST') return $this->updateDatasToDatabase();
        Session::flashInput(['http_referer' => Session::getOldInput('http_referer')]);
        $id = Request::input('id');
        $groupId = url_param_decode($id);
        if( ! $groupId or ! is_numeric($groupId)) return Js::error(Lang::get('common.illegal_operation'));
        $groupInfo = (new GroupModel())->getOneGroupById($groupId);
        if(empty($groupInfo)) return Js::error(Lang::get('group.group_not_found'));
        if( ! (new Acl())->checkGroupLevelPermission($groupId, Acl::GROUP_LEVEL_TYPE_GROUP)) return Js::error(Lang::get('common.account_level_deny'), true);
        $formUrl = R('common', 'foundation.group.edit');
        return view('admin.group.add', compact('groupInfo', 'formUrl', 'id'));
    }
    
    /**
     * 编辑用户组入库处理
     *
     * @access private
     */
    private function updateDatasToDatabase()
    {
        $httpReferer = Session::getOldInput('http_referer');
        $data = Request::input('data');
        if( ! $data or ! is_array($data)) return Js::error(Lang::get('common.illegal_operation'));
        $params = new \App\Services\Admin\Group\Param\GroupSave();
        $params->setAttributes($data);
        $manager = new GroupActionProcess();
        if($manager->editGroup($params))
        {
            $this->setActionLog();
            $backUrl = ( ! empty($httpReferer)) ? $httpReferer : R('common', 'foundation.group.index');
            return Js::locate($backUrl, 'parent');
        }
        return Js::error($manager->getErrorMessage());
    }

}