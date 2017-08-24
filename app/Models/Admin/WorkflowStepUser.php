<?php namespace App\Models\Admin;

use App\Models\Admin\Base;

/**
 * 工作流步骤用户表模型
 *
 * @author jiang
 */
class WorkflowStepUser extends Base
{
    /**
     * 表名
     *
     * @var string
     */
    protected $table = 'workflow_user';

    /**
     * 可以被集体附值的表的字段
     *
     * @var string
     */
    protected $fillable = array('workflow_step_id', 'user_id', 'workflow_id');
    
    /**
     * 增加工作流步骤的用户关联
     * 
     * @param array $data 所需要插入的信息
     */
    public function addWorkflowStepUser(array $data)
    {
        return $this->insert($data);
    }

    /**
     * 取得指定条件的工作流步骤与用户关联的信息
     * 
     * @param array $where
     * @return array
     */
    public function getWorkflowStepUsers($where)
    {
        if(isset($where['step_id'])) $query = $this->where('workflow_step_id', '=', intval($where['step_id']));
        if(isset($query)) return $query->get()->toArray();
        return [];
    }

    /**
     * 根据步骤的ID删除指定的数据
     *
     * @return true|false
     */
    public function deleteByStepId($stepId)
    {
        return $this->where('workflow_step_id', '=', $stepId)->delete();
    }

    /**
     * 根据条件删除数据
     */
    public function commonDelete($where)
    {
        if(isset($where['workflow_id'])) $sql = $this->where('workflow_id', '=', intval($where['workflow_id']));
        if(isset($sql)) return $sql->delete();
        return false;
    }

    /**
     * 取得指定条件的工作流步骤与用户关联的信息
     * 
     * @param array $where
     * @return array
     */
    public function getWorkflowStepUsersJoinUsersByStepId($stepId)
    {
        $query = $this->select(['workflow_user.*', 'users.realname'])->leftJoin('users', 'workflow_user.user_id', '=', 'users.id')->where('workflow_user.workflow_step_id', '=', intval($stepId));
        return $query->get()->toArray();
    }
    
}
