<?php namespace App\Models\Admin;

use App\Models\Admin\Base;

/**
 * 工作流步骤表模型
 *
 * @author jiang
 */
class WorkflowStep extends Base
{
    /**
     * 表名
     *
     * @var string
     */
    protected $table = 'workflow_step';

    /**
     * 可以被集体附值的表的字段
     *
     * @var string
     */
    protected $fillable = array('workflow_id', 'name', 'description', 'step_level', 'addtime', 'code');
    
    /**
     * 取得所有的工作流步骤
     *
     * @return array
     */
    public function getAllWorkflowStepByPage($where = [])
    {
        $currentQuery = $this->orderBy('step_level', 'asc');
        if(isset($where['workflow_id'])) $currentQuery->where('workflow_id', '=', intval($where['workflow_id']));
        $result = $currentQuery->paginate(self::PAGE_NUMS);
        return $result;
    }

    /**
     * 增加工作流步骤
     * 
     * @param array $data 所需要插入的信息
     */
    public function addWorkflowStep(array $data)
    {
        return $this->create($data);
    }

    /**
     * 取得单条工作流步骤信息
     *
     * @param array $where 条件
     * @return array
     */
    public function getWorkflowStepInfo($where)
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
     * 修改工作流步骤
     * 
     * @param array $data 所需要插入的信息
     */
    public function editWorkflowStep(array $data, $id)
    {
        return $this->where('id', '=', intval($id))->update($data);
    }

    /**
     * 删除工作流步骤
     * 
     * @param array $id 工作流的ID
     */
    public function deleteWorkflowStep(array $ids)
    {
        return $this->destroy($ids);
    }

    /**
     * 取得指定ID组的工作流步骤信息
     * 
     * @param intval $ids 工作流的ID
     * @return array
     */
    public function getWorkflowStepInIds($ids)
    {
        if( ! is_array($ids)) return false;
        return $this->whereIn('id', $ids)->get()->toArray();
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

    
}
