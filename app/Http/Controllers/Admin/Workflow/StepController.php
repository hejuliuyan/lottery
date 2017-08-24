<?php namespace App\Http\Controllers\Admin\Workflow;

use App\Http\Controllers\Admin\Controller;
use App\Services\Admin\Workflow\Process;
use App\Libraries\Js;
use Request, Lang;

/**
 * 工作流步骤
 *
 * @author jiang <mylampblog@163.com>
 */
class StepController extends Controller
{
    /**
     * 工作流步骤管理
     */
    public function index()
    {
        $workflowId = Request::input('id');
        if( ! $workflowId or ! is_numeric($workflowId)) return Js::error(Lang::get('common.illegal_operation'), true);
    	$manger = new Process();
    	$workflowInfo = $manger->workflowInfo(['id' => $workflowId]);
        if(empty($workflowInfo)) return Js::error(Lang::get('common.illegal_operation'), true);
        $list = $manger->workflowStepInfos(['workflow_id' => $workflowId, 'join_user' => true ]);
    	$page = $list->setPath('')->appends(Request::all())->render();
        return view('admin.workflow_step.detail', compact('workflowInfo', 'list', 'page'));
    }

    /**
     * 增加新的工作流
     */
    public function add()
    {
        if(Request::method() == 'POST') return $this->saveDatasToDatabase();
        $workflowId = Request::input('id');
        if( ! $workflowId or ! is_numeric($workflowId)) return Js::error(Lang::get('common.illegal_operation'), true);
        $manger = new Process();
        $workflowInfo = $manger->workflowInfo(['id' => $workflowId]);
        if(empty($workflowInfo)) return Js::error(Lang::get('common.illegal_operation'), true);
        $stepList = $manger->workflowStepLevelList();
        $formUrl = R('common', 'workflow.step.add');
        return view('admin.workflow_step.add', compact('formUrl', 'workflowId', 'stepList', 'workflowInfo'));
    }

    /**
     * 增加工作流入库处理
     *
     * @access private
     */
    private function saveDatasToDatabase()
    {
        $this->checkFormHash();
        $data = (array) Request::input('data');
        $workflowId = (int) Request::input('workflow_id');
        $data['workflow_id'] = $workflowId;
        $params = new \App\Services\Admin\Workflow\Param\WorkflowStepSave();
        $data['addtime'] = time();
        $params->setAttributes($data);
        $manager = new Process();
        if($manager->addWorkflowStep($params) !== false)
        {
            $this->setActionLog();
            return Js::locate(R('common', 'workflow.step.index', ['id' => $workflowId]), 'parent');
        }
        return Js::error($manager->getErrorMessage());
    }

    /**
     * 编辑工作流步骤
     *
     * @access public
     */
    public function edit()
    {
        if(Request::method() == 'POST') return $this->updateDatasToDatabase();
        $stepId = (int) Request::input('stepid');
        $workflow_Id = (int) Request::input('workflow_id');
        if( ! $stepId or ! is_numeric($stepId)) return Js::error(Lang::get('common.illegal_operation'), true);
        $manger = new Process();
        $workflowInfo = $manger->workflowInfo(['id' => $workflow_Id]);
        if(empty($workflowInfo)) return Js::error(Lang::get('common.illegal_operation'), true);
        $stepList = $manger->workflowStepLevelList();
        $info = $manger->workflowStepInfo(['id' => $stepId]);
        if(empty($info)) return Js::error(Lang::get('workflow.step_not_found'), true);
        $formUrl = R('common', 'workflow.step.edit');
        return view('admin.workflow_step.add', compact('info', 'formUrl', 'stepId', 'stepList', 'workflow_Id', 'workflowInfo'));
    }
    
    /**
     * 编辑工作流步骤入库处理
     *
     * @access private
     */
    private function updateDatasToDatabase()
    {
        $this->checkFormHash();
        $stepId = (int) Request::input('workflow_step_id');
        $workflowId = (int) Request::input('workflow_id');
        $data = Request::input('data');
        if( ! $data or ! is_array($data)) return Js::error(Lang::get('common.illegal_operation'));
        $data['id'] = $stepId;
        $data['workflow_id'] = $workflowId;
        $params = new \App\Services\Admin\Workflow\Param\WorkflowStepSave();
        $params->setAttributes($data);
        $manager = new Process();
        if($manager->editWorkflowStep($params))
        {
            $this->setActionLog();
            return Js::locate(R('common', 'workflow.step.index', ['id' => $workflowId]), 'parent');
        }
        return Js::error($manager->getErrorMessage());
    }

    /**
     * 删除工作流步骤
     *
     * @access public
     */
    public function delete()
    {
        $id = Request::input('id');
        if( ! is_array($id))
        {
            if( ! $id ) return responseJson(Lang::get('common.action_error'));
            $id = array($id);
        }
        $id = array_map('intval', $id);
        $manager = new Process();
        $info = $manager->workflowStepInfos(['ids' => $id]);
        if($manager->deleteWorkflowStep(['ids' => $id]))
        {
            $this->setActionLog(['workflowStepInfo' => $info]);
            return responseJson(Lang::get('common.action_success'), true);
        }
        return responseJson($manager->getErrorMessage());
    }

    /**
     * 设置关联人员
     *
     * @access public
     */
    public function relation()
    {
        if(Request::method() == 'POST') return $this->setRelation();
        $stepId = (int) Request::input('stepid');
        $workflowId = (int) Request::input('workflow_id');
        if( ! $stepId or ! $workflowId) return Js::error(Lang::get('common.illegal_operation'), true);
        $manager = new Process();
        $info = $manager->workflowStepInfo(['id' => $stepId]);
        if(empty($info) or $info['workflow_id'] != $workflowId) return Js::error(Lang::get('common.illegal_operation'), true);
        $userList = (new \App\Services\Admin\User\Process())->getWorkflowUser(['nums' => 30]);
        $page = $userList->setPath('')->appends(Request::all())->render();
        $hasRelationUser = $manager->hasRelationUser($stepId);
        foreach($userList as $key => $val)
        {
            if(in_array($val['id'], $hasRelationUser)) $userList[$key]['selected'] = true;
            else $userList[$key]['selected'] = false;
        }
        return view('admin.workflow_step.relation', compact('page', 'stepId', 'workflowId', 'info', 'userList'));
    }

    /**
     * 设置审核步骤与用户的关联
     *
     * @access private
     */
    private function setRelation()
    {
        $this->checkFormHash();
        $stepId = (int) Request::input('stepId');
        $workflowId = (int) Request::input('workflowId');
        $userIds = Request::input('ids');
        if( ! $userIds) return Js::error(Lang::get('workflow.relation_user_empty'));
        if( ! $stepId or ! $workflowId or ! is_array($userIds)) return Js::error(Lang::get('common.illegal_operation'));
        $userIds = array_map('intval', $userIds);
        $manager = new Process();
        $stepInfo = $manager->workflowStepInfo(['id' => $stepId]);
        if(empty($stepInfo)) return Js::error(Lang::get('common.illegal_operation'));
        if($manager->setRelation($workflowId, $stepId, $userIds))
        {
            $this->setActionLog(['userIds' => $userIds, 'stepInfo' => $stepInfo]);
            return Js::alert(Lang::get('common.action_success'));
        }
        return Js::error($manager->getErrorMessage());
    }


}