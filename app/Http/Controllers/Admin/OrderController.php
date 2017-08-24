<?php


namespace App\Http\Controllers\Admin;

use App\Models\Admin\OrderContent as OrderModel;
use App\Models\Admin\Access as AccessModel;
use Request;
use DB;

/**
 * 订单管理
 *
 * @author deng 2016-6-30 19:47
 */
class OrderController extends Controller {
	/**
	 * 订单显示页面
	 */
	public function ad_order() {
		if (isset ( $_GET ['id'] )) {
			$Model = new OrderModel ();
			$data = $Model->ad_order ( $_GET ['id'] );
			$pic = $Model->show_o_pic($_GET ['id']);
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
			
			return view ( 'admin.order.index' )->with ( 'data', $data )->with ( 'type_arr', $type_arr )->with ( 's_arr', $status_arr )->with('pic',$pic);
		} else {
			
		}
	}
	
	/**
	 * 订单修改中奖总金额
	 */
	public function update_total() {
		$model = new OrderModel ();
		$res = $model->update_total ( $_POST );
		echo json_encode ( $res );
	}
	
	/**
	 * 订单状态显示
	 */
	public function order_detail_log() {
		$model = new OrderModel ();
		$res = $model->order_detail_log ( $_POST );
		echo json_encode ( $res );
	}
	
	/**
	 * 用户退单
	 */
	public function user_out() {
		$model = new OrderModel ();
		$res = $model->user_out ( $_POST );
		echo json_encode ( $res );
	}
}