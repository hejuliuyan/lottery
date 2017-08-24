<?php namespace App\Services\Admin\ActionLog;

/**
 * 用户操作日志
 *
 * @author jiang <mylampblog@163.com>
 */
class Mark
{
    CONST BIND_NAME = 'ACTION_LOG_BIND_NAME';

    /**
     * 标志是否写日志
     * 
     * @var boolean
     */
    private $mark = false;

    /**
     * 附带的信息
     */
    private $extDatas = [];

    /**
     * 启用写日志
     */
    public function setMarkYes()
    {
        $this->mark = true;
        return $this;
    }

    /**
     * 不启用写日志
     */
    public function setMarkNo()
    {
        $this->mark = false;
        return $this;
    }

    /**
     * 附带的信息
     */
    public function setExtDatas($extDatas)
    {
        $this->extDatas = $extDatas;
        return $this;
    }

    /**
     * 返回附带的信息
     */
    public function getExtDatas()
    {
        return $this->extDatas;
    }

    /**
     * 是否写日志
     */
    public function isLog()
    {
        $mark = $this->mark;
        $this->mark = false;
        return $mark;
    }
    
}
