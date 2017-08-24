<?php namespace App\Services\Admin;

/**
 * 服务基类
 *
 * @author jiang <mylampblog@163.com>
 */
abstract class AbstractService
{
    /**
     * 错误的信息载体
     *
     * @access protected
     */
    protected $errorMsg;
    
    /**
     * 取回错误的信息
     *
     * @access public
     */
    public function getErrorMessage()
    {
        return $this->errorMsg;
    }

    /**
     * 设置错误的信息
     *
     * @param string $errorMsg 错误的信息
     */
    public function setErrorMsg($errorMsg)
    {
    	$this->errorMsg = $errorMsg;
    	return false;
    }
}
