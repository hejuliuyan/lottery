<?php namespace App\Services\Admin\Workflow;

use Lang;
use App\Models\Admin\Workflow as WorkflowModel;
use App\Models\Admin\WorkflowStep as workflowStepModel;
use App\Services\Admin\Workflow\Validate\Workflow as WorkflowValidate;
use App\Services\Admin\Workflow\Validate\WorkflowStep as WorkflowStepValidate;
use App\Services\Admin\BaseProcess;

/**
 * 工作流
 *
 * @author jiang <mylampblog@163.com>
 */
class Process extends BaseProcess
{
    /**
     * 工作流模型
     * 
     * @var object
     */
    private $workflowModel;

    /**
     * 工作流表单验证对象
     * 
     * @var object
     */
    private $workflowValidate;

    /**
     * 工作流步骤表单验证对象
     * 
     * @var object
     */
    private $workflowStepModel;

    /**
     * 工作流步骤表单验证对象
     * 
     * @var object
     */
    private $workflowStepValidate;

    /**
     * 初始化
     *
     * @access public
     */
    public function __construct()
    {
        if( ! $this->workflowModel) $this->workflowModel = new WorkflowModel();
        if( ! $this->workflowValidate) $this->workflowValidate = new WorkflowValidate();
        if( ! $this->workflowStepModel) $this->workflowStepModel = new workflowStepModel();
        if( ! $this->workflowStepValidate) $this->workflowStepValidate = new WorkflowStepValidate();
    }

    /**
     * 工作流列表
     *
     * @access public
     */
    public function workflowInfos($where = [])
    {
        if(empty($where)) return $this->workflowModel->getAllWorkflowByPage();
        if(isset($where['ids'])) return $this->workflowModel->getWorkflowInIds($where['ids']);
        return [];
    }

    /**
     * 取得单条工作流信息
     *
     * @param array $where 条件
     * @return array
     */
    public function workflowInfo($where)
    {
        return $this->workflowModel->getWorkflowInfo($where);
    }

    /**
     * 增加新的工作流
     *
     * @param object $data
     * @access public
     * @return boolean true|false
     */
    public function addWorkflow(\App\Services\Admin\Workflow\Param\WorkflowSave $data)
    {
        if( ! $this->workflowValidate->add($data)) return $this->setErrorMsg($this->workflowValidate->getErrorMessage());
        $checkCode = $this->workflowModel->getWorkflowInfo(['code' => $data->code]);
        if( ! empty($checkCode)) return $this->setErrorMsg(Lang::get('workflow.code_exists'));
        if( ! in_array($data->type, [WorkflowModel::W_TYPE_TIER, WorkflowModel::W_TYPE_ASSIST])) return $this->setErrorMsg(Lang::get('common.illegal_operation'));
        if($this->workflowModel->addWorkflow($data->toArray()) !== false) return true;
        return $this->setErrorMsg(Lang::get('common.action_error'));
    }

    /**
     * 编辑工作流
     *
     * @param string $data
     * @access public
     * @return boolean true|false
     */
    public function editWorkflow(\App\Services\Admin\Workflow\Param\WorkflowSave $data)
    {
        if( ! isset($data->id)) return $this->setErrorMsg(Lang::get('common.action_error'));
        $id = $data->id; unset($data->id);
        if( ! $id) return $this->setErrorMsg(Lang::get('common.illegal_operation'));
        $checkCode = $this->workflowModel->getWorkflowInfo(['code' => $data->code, 'self' => false, 'self_id' => $id]);
        if( ! empty($checkCode)) return $this->setErrorMsg(Lang::get('workflow.code_exists'));
        if( ! in_array($data->type, [WorkflowModel::W_TYPE_TIER, WorkflowModel::W_TYPE_ASSIST])) return $this->setErrorMsg(Lang::get('common.illegal_operation'));
        if( ! $this->workflowValidate->edit($data)) return $this->setErrorMsg($this->workflowValidate->getErrorMessage());
        if($this->workflowModel->editWorkflow($data->toArray(), $id) !== false) return true;
        return $this->setErrorMsg(Lang::get('common.action_error'));
    }

    /**
     * 删除工作流
     *
     * @param array $where 条件
     * @return true|false
     * @access public
     */
    public function deleteWorkflow($where)
    {
        if(isset($where['ids'])) $ids = array_map('intval', $where['ids']);
        if(isset($ids))
        {
            $result = $this->workflowModel->deleteWorkflow($ids);
            if($result !== false)
            {
                $modelStepUser = new \App\Models\Admin\WorkflowStepUser();
                foreach($ids as $workflowId)
                {
                    $this->workflowStepModel->commonDelete(['workflow_id' => $workflowId]);
                    $modelStepUser->commonDelete(['workflow_id' => $workflowId]);
                }
            }
            return true;
        }
        return false;
    }

    /**
     * 取得工作流详细步骤的信息
     *
     * @param array $where 条件
     * @return array
     */
    public function workflowStepInfos($where = [])
    {
        if(isset($where['ids'])) return $this->workflowStepModel->getWorkflowStepInIds($where['ids']);
        $result = $this->workflowStepModel->getAllWorkflowStepByPage($where);
        if(isset($where['join_user']))
        {
            $modelStepUser = new \App\Models\Admin\WorkflowStepUser();
            foreach($result as $key => $val)
            {
                $userInfo = $modelStepUser->getWorkflowStepUsersJoinUsersByStepId($val['id']);
                $relationUsers = [];
                foreach($userInfo as $user)
                {
                    $relationUsers[] = $user['realname'];
                }
                $result[$key]['relatioin_users'] = implode(',', $relationUsers);
            }
        }
        return $result;
    }

    /**
     * 返回固定的步骤信息，暂时只支持到九步
     *
     * @return  array
     */
    public function workflowStepLevelList()
    {
        return [
            ['step_level' => 1, 'title' => '审核第一步'],
            ['step_level' => 2, 'title' => '审核第二步'],
            ['step_level' => 3, 'title' => '审核第三步'],
            ['step_level' => 4, 'title' => '审核第四步'],
            ['step_level' => 5, 'title' => '审核第五步'],
            ['step_level' => 6, 'title' => '审核第六步'],
            ['step_level' => 7, 'title' => '审核第七步'],
            ['step_level' => 8, 'title' => '审核第八步'],
            ['step_level' => 9, 'title' => '审核第九步'],
        ];
    }

    /**
     * 增加新的工作流步骤
     *
     * @param object $data
     * @access public
     * @return boolean true|false
     */
    public function addWorkflowStep(\App\Services\Admin\Workflow\Param\WorkflowStepSave $data)
    {
        if( ! empty($data['step_level']))
        {
            if( ! in_array($data['step_level'], array_fetch($this->workflowStepLevelList(), 'step_level') )) return $this->setErrorMsg(Lang::get('common.illegal_operation'));
        }
        
        if( ! $this->workflowStepValidate->add($data)) return $this->setErrorMsg($this->workflowStepValidate->getErrorMessage());

        if( ! empty($data->code))
        {
            $checkCode = $this->workflowStepModel->getWorkflowStepInfo(['code' => $data->code]);
            if( ! empty($checkCode)) return $this->setErrorMsg(Lang::get('workflow.code_exists'));
        }

        if($this->workflowStepModel->addWorkflowStep($data->toArray()) !== false) return true;
        return $this->setErrorMsg(Lang::get('common.action_error'));
    }

    /**
     * 取得单条工作流步骤信息
     *
     * @param array $where 条件
     * @return array
     */
    public function workflowStepInfo($where)
    {
        return $this->workflowStepModel->getWorkflowStepInfo($where);
    }

    /**
     * 编辑工作流步骤
     *
     * @param string $data
     * @access public
     * @return boolean true|false
     */
    public function editWorkflowStep(\App\Services\Admin\Workflow\Param\WorkflowStepSave $data)
    {
        if( ! isset($data->id)) return $this->setErrorMsg(Lang::get('common.action_error'));
        if( ! empty($data['step_level']))
        {
            if( ! in_array($data['step_level'], array_fetch($this->workflowStepLevelList(), 'step_level') )) return $this->setErrorMsg(Lang::get('common.illegal_operation'));
        }
        $id = $data->id; unset($data->id);
        if( ! $id) return $this->setErrorMsg(Lang::get('common.illegal_operation'));
        if( ! $this->workflowStepValidate->edit($data)) return $this->setErrorMsg($this->workflowStepValidate->getErrorMessage());

        if( ! empty($data->code))
        {
            $checkCode = $this->workflowStepModel->getWorkflowStepInfo(['code' => $data->code, 'self' => false, 'self_id' => $id]);
            if( ! empty($checkCode)) return $this->setErrorMsg(Lang::get('workflow.code_exists'));
        }

        if($this->workflowStepModel->editWorkflowStep($data->toArray(), $id) !== false) return true;
        return $this->setErrorMsg(Lang::get('common.action_error'));
    }

    /**
     * 删除工作流步骤
     *
     * @param array $where 条件
     * @return true|false
     * @access public
     */
    public function deleteWorkflowStep($where)
    {
        if(isset($where['ids'])) $ids = array_map('intval', $where['ids']);
        if(isset($ids))
        {
            $result = $this->workflowStepModel->deleteWorkflowStep($ids);
            $modelStepUser = new \App\Models\Admin\WorkflowStepUser();
            if($result !== false)
            {
                foreach($ids as $stepId)
                {
                    $modelStepUser->deleteByStepId($stepId);
                }
            }
            return true;
        }
        return false;
    }

    /**
     * 已经关联的用户ID
     *
     * @param int $stepId 步骤的ID
     * @return array
     */
    public function hasRelationUser($stepId)
    {
        $model = new \App\Models\Admin\WorkflowStepUser();
        $list = $model->getWorkflowStepUsers(['step_id' => intval($stepId)]);
        $ids = [];
        foreach($list as $key => $val)
        {
            $ids[] = $val['user_id'];
        }
        return $ids;
    }

    /**
     * 设置关联人员
     *
     * @access public
     */
    public function setRelation($workflowId, $stepId, $userIds)
    {
        $model = new \App\Models\Admin\WorkflowStepUser();
        $deleteBefore = $model->deleteByStepId($stepId);
        if($deleteBefore !== false)
        {
            if( ! is_array($userIds)) return false;
            $insertData = [];
            foreach($userIds as $key => $val)
            {
                $insertData[] = ['workflow_step_id' => $stepId, 'user_id' => $val, 'workflow_id' => $workflowId];
            }
            return $model->addWorkflowStepUser($insertData);
        }
        return false;
    }

}