<?php

namespace App\Models\Admin;

use App\Models\Admin\Base;
use DB;

/**
 * 订单列表
 * @task 87
 * @author zhou 2016-6-23 18:39
 */
class Orderlist extends Base {
    /**
     * @param $data
     * @return mixed
     * 订单列表
     */
	public function lists($data) {
		if(isset($data['begin_time'])){
			$data['begin_time']=strtotime($data['begin_time']);
		}
		if(isset($data['end_time'])){
			$data['end_time']=strtotime($data['end_time']);
		}		
		$data = DB::table ( 'cp_order' )->join ( 'cp_member', 'cp_order.uid', '=', 'cp_member.id' )->join ( 'cp_shop', 'cp_order.order_shop', '=', 'cp_shop.id' )->select ( 'cp_order.*', 'cp_member.real_name', 'cp_shop.shop_name' )
		->where ( function ($query) use ($data) {
			if (! empty ( $data ['type'] )) {
				$query->where ( 'cp_order' . '.type', '=', $data ['type'] );
			}
		} )->where ( function ($query) use ($data) {
			if (isset ( $data ['order_qi'] ) && is_numeric ( $data ['order_qi'] )) {
				$query->where ( 'cp_order' . '.order_qi', '=', $data ['order_qi'] );
			}
		} )->where ( function ($query) use ($data) {
			if (isset ( $data ['mobile'] ) && is_numeric ( $data ['mobile'] )) {
				$query->where ( 'cp_member' . '.mobile', '=', $data ['mobile'] );
			}
		} )->where ( function ($query) use ($data) {
			if (isset ( $data ['keeper_mobile'] ) && is_numeric ( $data ['keeper_mobile'] )) {
				$query->where ( 'cp_shop' . '.keeper_mobile', '=', $data ['keeper_mobile'] );
			}
		} )->where ( function ($query) use ($data) {
			if (isset ( $data ['order_num'] ) && is_numeric ( $data ['order_num'] )) {
				$query->where ( 'cp_order' . '.order_num', '=', $data ['order_num'] );
			}
		} )->where ( function ($query) use ($data) {
			if (isset ( $data ['begin_time'] ) && is_numeric ( $data ['begin_time'] )) {
				$query->where ( 'cp_order' . '.order_date', '>', $data ['begin_time'] );
			}
		} )->where ( function ($query) use ($data) {
			if (isset ( $data ['end_time'] ) && is_numeric ( $data ['end_time'] )) {
				$query->where ( 'cp_order' . '.order_date', '<', $data ['end_time'] );
			}
		} )->orderBy('cp_order.order_date','desc')->paginate ( 20 );
		return $data;
	}
}
