<?php namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

/**
 * 后台的模型基类
 */
class Base extends Model
{
	/**
	 * 每页多少
	 *
	 * @var int
	 */
	CONST PAGE_NUMS = 15;

	/**
     * 关闭自动维护updated_at、created_at字段
     * 
     * @var boolean
     */
    public $timestamps = false;
}