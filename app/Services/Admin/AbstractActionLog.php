<?php namespace App\Services\Admin;

use App\Services\Admin\ActionLog\Mark;

/**
 * 操作日志
 *
 * @author jiang <mylampblog@163.com>
 */
abstract class AbstractActionLog
{
    abstract public function handler();

    protected function isLog()
    {
    	return app()->make(Mark::BIND_NAME)->isLog();
    }

    protected function getExtDatas()
    {
    	return app()->make(Mark::BIND_NAME)->getExtDatas();
    }
}
