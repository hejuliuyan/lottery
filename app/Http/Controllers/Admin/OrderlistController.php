<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Orderlist as OrderModel;
use Request;
use DB;

/**
 * 订单管理
 * @author zhou 2016-6-30
 */
class OrderlistController extends Controller {
    /**
     * 列表显示页面
     */
	public function index() {
	    //判断检索条件是否为空
		$data ['type'] = (isset ( $_GET ['type'] )) ? $_GET ['type'] : '';
		$data ['order_qi'] = (isset ( $_GET ['order_qi'] )) ? $_GET ['order_qi'] : '';
		$data ['mobile'] = (isset ( $_GET ['mobile'] )) ? $_GET ['mobile'] : '';
		$data ['keeper_mobile'] = (isset ( $_GET ['keeper_mobile'] )) ? $_GET ['keeper_mobile'] : '';
		$data ['order_num'] = (isset ( $_GET ['order_num'] )) ? $_GET ['order_num'] : '';
		$data ['begin_time'] = (isset ( $_GET ['begin_time'] )) ? $_GET ['begin_time'] : '';
		$data ['end_time'] = (isset ( $_GET ['end_time'] )) ? $_GET ['end_time'] : '';
		$type_arr = array (
				"01" => '大乐透',
				"02" => '七星彩',
				"03" => '排列三',
				"04" => '排列五' 
		);
		$status_arr = array (
				0 => '订单已提交',
				1 => '用户已支付',
				2 => '店铺已接单',
				3 => '店铺已出票',
				4 => '已确认出票',
				5 => '用户已退单',
				6 => '订单已中奖',
				7 => '店铺已派奖' 
		);
		$Model = new OrderModel ();
		$lists = $Model->lists ( $data );//获取订单数据
		return view ( 'admin.orderlist.index' )->with ( 'lists', $lists )->with ( 'where', $data )->with ( 'type_arr', $type_arr )->with ( 's_arr', $status_arr );
	}
}