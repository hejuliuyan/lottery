<?php


namespace App\Models\Admin;

use App\Models\Admin\Base;
use DB;

/**
 * 文章表模型
 *
 * @author deng
 */
class Ordercontent extends Base {
	
	/**
	 * 订单管理首页
	 */
	public function ad_order($id) {
		$data = DB::table ( 'cp_order' )->join ( 'cp_member', 'cp_order.uid', '=', 'cp_member.id' )->join ( 'cp_shop', 'cp_order.order_shop', '=', 'cp_shop.id' )->select ( 'cp_order.*', 'cp_member.real_name', 'cp_shop.shop_name')->where ( 'cp_order.id', $id )->get ();
		$arr = DB::table ( 'cp_order_detail' )->where('order_id',$id)->get();
		foreach($arr as $val){
			$numbers[] = $val->numbers;
		}
		$data[0]->numbers = $numbers;
		return $data;
	}
	public function show_o_pic($id){
		$res = DB::table ( 'cp_order_pic' )->where('o_id',$id)->get();
		return $res;
	}
	/**
	 * 订单修改中奖总金额
	 */
	public function update_total($data) {
		$data = DB::table ( 'cp_order' )->where ( 'id', '=', $data ['order_id'] )->update ( array (
				'win_total' => $data ['win_total'],
				'status' => '6' 
		) );
		
		if ($data) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * 订单状态显示
	 */
	public function order_detail_log($data) {
		$data = DB::table ( 'cp_order_log' )->where ( 'order_id', '=', $data ['order_id'] )->get ();
		
		foreach ( $data as $k => $v ) {
			$v->new_time = date ( 'Y-m-d H:i:s', $v->time + 28800 );
		}
		if ($data) {
			return $data;
		} else {
			return false;
		}
	}
	
	/**
	 * 用户退单
	 */
	public function user_out($data) {
		DB::beginTransaction();
		$da = DB::table ( 'cp_order' )->where ( 'id', '=', $data ['order_id'] )->update ( array (
				'active' => '1',
				'status' => '5',
				'update_date' => time()
		) );
		
		$money = DB::table ( 'cp_order' )->where ( 'id', '=', $data ['order_id'] )->pluck ( 'order_money' );
		$user_trans_id = '17' . time () . mt_rand ( 1000, 9999 );
		$document_id = DB::table ( 'cp_trans_member' )->where ( 'order_id', '=', $data ['order_id'] )->where ( 'trans_title', '=', '2' )->pluck ( 'trans_id' );
		$trans_date = date ( 'Y-m-d H:i:s', time () + 28800 );
		
		$uid = DB::table ( 'cp_order' )->where ( 'id', '=', $data ['order_id'] )->pluck ( 'uid' );
		$user_openid = DB::table ( 'cp_member' )->where ( 'id', '=', $uid )->pluck ( 'openid' );
		$user_trans_balance = DB::table ( 'cp_trans_member' )->where ( 'trans_account', '=', $user_openid )->orderBy ( 'trans_date', 'desc' )->take ( 1 )->select ( 'trans_balance' )->get ();
		
		if ($user_trans_balance) {
			foreach ( $user_trans_balance as $k => $v ) {
				$user_trans_balance = $v->trans_balance;
			}
		} else {
			$user_trans_balance = 0;
		}
		
		$user_trans_balance = $user_trans_balance + $money;
		$dd = DB::table ( 'cp_trans_member' )->insertGetId ( array (
				'trans_id' => $user_trans_id,
				'document_id' => $document_id,
				'order_id' => $data ['order_id'],
				'trans_account' => $user_openid,
				'opp_account' => $user_openid,
				'trans_title' => '5',
				'trans_price' => $money,
				'trans_date' => $trans_date,
				'trans_way' => '2',
				'trans_balance' => $user_trans_balance,
				'trans_result' => '1' 
		) );
		
		if ($dd) {
			DB::commit();
			return true;
		} else {
			DB::rollback();
			return false;
		}
	}
}