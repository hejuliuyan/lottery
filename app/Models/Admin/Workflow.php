<?php namespace App\Models\Admin;

use App\Models\Admin\Base;

/**
 * 工作流表模型
 *
 * @author jiang
 */
class Workflow extends Base
{
    /**
     * 表名
     *
     * @var string
     */
    protected $table = 'workflow';

    /**
     * 可以被集体附值的表的字段
     *
     * @var string
     */
    protected $fillable = array('name', 'description', 'addtime', 'code', 'type');

    /**
     * 多用户的类OA审核标识
     *
     * @var int
     */
    CONST W_TYPE_TIER = 1;

    /**
     * 辅助审核标识
     *
     * @var int
     */
    CONST W_TYPE_ASSIST = 2;
    
    /**
     * 取得所有的工作流
     *
     * @return array
     */
    public function getAllWorkflowByPage()
    {
        $currentQuery = $this->orderBy('id', 'desc')->paginate(self::PAGE_NUMS);
        return $currentQuery;
    }

    /**
     * 增加工作流
     * 
     * @param array $data 所需要插入的信息
     */
    public function addWorkflow(array $data)
    {
        return $this->create($data);
    }

    /**
     * 取得单条工作流信息
     *
     * @param array $where 条件
     * @return array
     */
    public function getWorkflowInfo($where)
    {
        $search = $this->select(array('*'));
        if(isset($where['id'])) $search->where('id', '=', intval($where['id']));
        if(isset($where['code']))
        {
            $search->where('code', '=', $where['code']);
            if(isset($where['self'], $where['self_id']) and $where['self'] === false)
            {
                $search->where('id', '!=', $where['self_id']);
            }
        }
        return $search->first();
    }

    /**
     * 修改工作流
     * 
     * @param array $data 所需要插入的信息
     */
    public function editWorkflow(array $data, $id)
    {
        return $this->where('id', '=', intval($id))->update($data);
    }

    /**
     * 删除工作流
     * 
     * @param array $id 工作流的ID
     */
    public function deleteWorkflow(array $ids)
    {
        return $this->destroy($ids);
    }

    /**
     * 取得指定ID组的工作流信息
     * 
     * @param intval $ids 工作流的ID
     * @return array
     */
    public function getWorkflowInIds($ids)
    {
        if( ! is_array($ids)) return false;
        return $this->whereIn('id', $ids)->get()->toArray();
    }

    /**
     * 取得当前用户所拥有的审核权限
     *
     * @param int $userId 用户的ID
     * @param string $code 调用的code
     * @access public
     */
    public function getCurrentUserWorkflowLevel($userId, $code)
    {
        $workflow = \DB::table('workflow_user')->select('workflow_step.step_level')
                    ->leftJoin('workflow_step', 'workflow_user.workflow_step_id', '=', 'workflow_step.id')
                    ->leftJoin('workflow', 'workflow_step.workflow_id', '=', 'workflow.id')
                    ->where('workflow_user.user_id', '=', $userId)
                    ->where('workflow.code', '=', $code)
                    ->get();
        $result = [];
        foreach($workflow as $val)
        {
            $result[] = $val->step_level;
        }
        return $result;
    }

    /**
     * 返回最后审核的值
     */
    public function worflowFinalLevel($code)
    {
        $workflow = \DB::table('workflow')->select('workflow_step.step_level')
                    ->leftJoin('workflow_step', 'workflow.id', '=', 'workflow_step.workflow_id')
                    ->where('workflow.code', '=', $code)
                    ->orderBy('workflow_step.step_level', 'desc')
                    ->first();
        return $workflow->step_level;
    }

    /**
     * 指定工作流指定工作流步骤的信息
     *
     * @param int $userId 用户的ID
     * @param string $workflowCode 调用的工作流code
     * @param string $workflowStepCode 调用的工作流步骤code
     * @access public
     */
    public function getCurrentUserWorkflowStep($userId, $workflowCode, $workflowStepCode)
    {
        $result = \DB::table('workflow_user')->select('workflow_step.id')
                    ->leftJoin('workflow_step', 'workflow_user.workflow_step_id', '=', 'workflow_step.id')
                    ->leftJoin('workflow', 'workflow_step.workflow_id', '=', 'workflow.id')
                    ->where('workflow_user.user_id', '=', $userId)
                    ->where('workflow.code', '=', $workflowCode)
                    ->where('workflow_step.code', '=', $workflowStepCode)
                    ->first();
        return $result;
    }

    
}
