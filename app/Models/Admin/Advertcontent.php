<?php

namespace App\Models\Admin;

use App\Models\Admin\Base;
use DB;

/**
 * 文章表模型
 *
 * @author wang
 */
class Advertcontent extends Base {
	
	/**
	 * 获取开奖结果列表
	 *
	 * @param array $data
	 *        	所需要插入的信息
	 */
	public function lists() {
		$data = DB::table ( 'cp_shuffling_pic' )->get ();
		return $data;
	}
	
	/*
	 *
	 * 添加
	 *
	 */
	public function add($data) {
		$data = DB::table ( 'cp_shuffling_pic' )->insert ( [ 
				'p_name' => $data,
				'create_time' => date ( 'Y-m-d H:i:s', time () ),
				'state' => '1' 
		] );
		return $data;
		// return $this->create($data);
	}
	public function saves($data) {
		$res = DB::table ( 'cp_shuffling_pic' )->where ( 'id', $data ['id'] )->update ( [ 
				'state' => $data ['state'] 
		] );
		return $res;
	}
	public function del($data) {
		$res=DB::table('cp_shuffling_pic')->where('id', $data['id'])->delete();
	}
}
