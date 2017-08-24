<?php namespace App\Services\Admin\Workflow;

use App\Models\Admin\Workflow as WorkflowModel;
use App\Services\Admin\BaseProcess;
use App\Services\Admin\SC;

/**
 * 工作流权限检测
 *
 * @author jiang <mylampblog@163.com>
 */
class Check extends BaseProcess
{
    /**
     * 默认的审核状态
     *
     * @var int
     */
    CONST DEFAULT_STATUS = 0;

    /**
     * 默认的审核状态的替换状态,即如果为0的话代表的是第一步审核
     *
     * @var int
     */
    CONST DEFAULT_STATUS_REPLACE = 1;

    /**
     * 如果走到了最后的一步，那么设置为这个值
     *
     * @var int
     */
    CONST DEFAULT_STATUS_FINAL_PASS = 99;

    /**
     * 工作流模型
     * 
     * @var object
     */
    private $workflowModel;

    /**
     * 指定用户和调用代码的用户审核权限缓存
     * 
     * @var array
     */
    private $userWorkflow;

    /**
     * finalLevel
     * 
     * @var array
     */
    private $finalLevel;

    /**
     * 初始化
     *
     * @access public
     */
    public function __construct()
    {
        if( ! $this->workflowModel) $this->workflowModel = new WorkflowModel();
    }

    /**
     * 检测是否有审核的权限
     *
     * @param string $code 调用代码，即检测哪个工作流的
     * @param array $status 当前审核状态
     * @access public
     */
    public function checkAcl($code, $status = [])
    {
        if( ! is_array($status) or ! is_string($code)) return false;
        $userInfo = SC::getLoginSession();
        if( ! isset($this->userWorkflow[$code])) $this->userWorkflow[$code] = $this->workflowModel->getCurrentUserWorkflowLevel($userInfo->id, $code);
        $this->getFinalLevel($code);
        $isCheck = false;
        foreach($status as $s)
        {
            if($s == self::DEFAULT_STATUS) $s = self::DEFAULT_STATUS_REPLACE;
            if(in_array($s, $this->userWorkflow[$code]) or $this->otherness($s) )
            {
                $isCheck = true;
                break;
            }
        }
        return $isCheck;
    }

    /**
     * 检测工作流的步骤是否有修改过，且步骤少于之前的。
     *
     * 需要注意的是如果你修改过工作流的步骤，无论如何请保持它们的连续性，即按照第一步，第二步，第三步……的顺序
     * 
     * @return boolean
     */
    private function otherness($currentStatus)
    {
        return ($currentStatus > $this->finalLevel and $currentStatus != self::DEFAULT_STATUS_FINAL_PASS);
    }

    /**
     * 返回下一步审核的状态值
     *
     * <code>
     *     $result = ['is_final' => false, 'status' => 2];
     * </code
     *
     * $result['is_final']代表的是，是不是走到了最后一步了。
     * $result['status'] 审核后所要设置的值
     * 
     * @return int|true
     */
    public function getComfirmStatus($code, $currentStatus)
    {
        if( ! is_numeric($currentStatus) or ! is_string($code)) return false;
        if($this->isFinal($code, $currentStatus)) return ['is_final' => true, 'status' => self::DEFAULT_STATUS_FINAL_PASS];
        if($currentStatus == self::DEFAULT_STATUS) $currentStatus = self::DEFAULT_STATUS_REPLACE;
        return ['is_final' => false, 'status' => ++$currentStatus];
    }

    /**
     * 是不是最后一步审核
     * 
     * @return boolean
     */
    private function isFinal($code, $currentStatus)
    {
        $this->getFinalLevel($code);
        return $this->finalLevel <= $currentStatus;
    }

    /**
     * 取得最后一步的step_level值
     */
    private function getFinalLevel($code)
    {
        if( ! isset($this->finalLevel)) $this->finalLevel = $this->workflowModel->worflowFinalLevel($code);
    }

    /**
     * 检测指定的工作流的指定的步骤是否有权限
     * 
     * @return true|false
     */
    public function checkStepAcl($workflowCode, $workflowStepCode)
    {
        if( ! is_string($workflowCode) or ! is_string($workflowStepCode)) return false;
        $key = md5($workflowCode.$workflowStepCode);
        $userInfo = SC::getLoginSession();
        if( ! isset($this->userWorkflow[$key])) $this->userWorkflow[$key] = $this->workflowModel->getCurrentUserWorkflowStep($userInfo->id, $workflowCode, $workflowStepCode);
        return ! empty($this->userWorkflow[$key]);
    }

}