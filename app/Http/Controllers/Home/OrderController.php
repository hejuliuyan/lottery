<?php namespace App\Http\Controllers\Home;
use App\Models\Home\Order as OrderModel;
use Request;

/**
 * 订单相关
 *
 * @author wang 2016‎年‎8‎月‎18‎日，‏‎16:35:43
 */
class OrderController extends Controller
{
    /**
     * 第一步订单
     */
    public function order(){
		$data['userid'] = $_POST['userid'];//用户id
		$data['order_qi'] = $_POST['order_qi'];//彩票期数
		$data['cp_hm'] = $_POST['cp_hm'];//彩票号码
		$data['user_mobile'] = $_POST['user_mobile'];//用户手机号
		$data['order_money'] = $_POST['order_money'];//获取用户金额
		$data['order_b'] = $_POST['order_b'];//获取倍数
		$data['order_z'] = $_POST['order_z'];//获取订单注数
		$data['add'] = $_POST['add'];//获取订单注数
		$data['type'] = $_POST['type'];//彩票类型
		$data['type_id']=$_POST['type_id'];
		$data['shop_id']=$_POST['shop_id'];
		//$data['order_detail'] = $_POST['order_detail'];//彩票金额倍数2|1

		if($data['order_b']<1){
			$data = array('status'=>0,'msg'=>'订单倍数不得小于1倍','data'=>'');
		}else if($data['order_money']<1){
			$data = array('status'=>2,'msg'=>'订单金额不得小于1元','data'=>'');
		}else{
			$orderModel = new OrderModel();
			$order = $orderModel->order($data);
			$data = array('status'=>1,'msg'=>'成功','data'=>$order);
		}
		echo json_encode($data);
		die();
	}

    /**
     * 排三插入订单投注方式
     */
    public function order_tz_type(){
		$data['tz_type'] = $_POST['tz_type'];//用户id
		$data['order_id'] = $_POST['order_id'];//用户订单
		
		$orderModel = new OrderModel();
		$detail = $orderModel->order_tz_type($data);
		echo json_encode($data);
		die();
	}


	/**
     * 读取第一步订单详情
     */
	public function order_detail(){
		$data['userid'] = $_POST['userid'];//用户id
		$data['order_id'] = $_POST['order_id'];//用户订单
		
		$orderModel = new OrderModel();
		$detail = $orderModel->order_detail($data);
		$data = array('status'=>1,'msg'=>'成功','data'=>$detail);
		echo json_encode($data);
		die();
	}
	
	/**
     * 修改订单详情
     */
	public function updorder(){
		$data['order_id'] = $_POST['order_id'];//用户订单
		$data['type_id'] = $_POST['type_id'];//取票方式
		$data['shop_id'] = $_POST['shop_id'];//彩票id
		
		$orderModel = new OrderModel();
		$detail = $orderModel->updorder($data);
		$data = array('status'=>1,'msg'=>'成功','data'=>$detail);
		echo json_encode($data);
		die();
	}
	
	/**
     * 把用户的订单日志写到库里
     */
	public function orderlog(){
		$data['order_id'] = $_POST['order_id'];//用户订单
		$data['order_status'] = $_POST['order_status'];//订单状态
		$data['d_value'] = $_POST['value'];//备注内容
		
		
		$orderModel = new OrderModel();
		$res=$orderModel->orderlog($data);
		echo json_encode($res);
	}
	
	/**
     * 把订单日志读取出来
     */
	public function odetail_log(){
		$orderModel = new OrderModel();
		$detail = $orderModel->odetail_log($_POST);
		$data = array('status'=>1,'msg'=>'成功','data'=>$detail);
		echo json_encode($data);
		die();
	}


	/**
     * 银联支付
     */
	public function order_bank(){
		$orderModel = new OrderModel();
		$detail = $orderModel->order_bank($_POST);
		$data = array('status'=>1,'msg'=>'成功','data'=>$detail);
		echo json_encode($data);
		die();
	}

    /**
     * 余额支付
     */
    public function order_balance(){
    	$orderModel = new OrderModel();
    	$detail = $orderModel->order_balance($_POST);
    	$data = array('status'=>1,'msg'=>'成功','data'=>$detail);
    	echo json_encode($data);
    	die();
    }

    /**
     * 获取当期彩票的期数
     */
    public function cp_qi(){
    	$data['types'] = $_POST['types'];
    	$orderModel = new OrderModel();
    	$data = $orderModel->cp_qi($data);
    	echo json_encode($data);
    	die();
    }

    /**
     * 用户退单
     */
    public function out_order(){
    	$orderModel = new OrderModel();
    	$data = $orderModel->out_order($_POST);
    	echo json_encode($data);
    	die();
    }

    /**
     * 重新下单
     */
    public function order_reset(){
    	$data['order_id'] = $_POST['order_id'];
    	$orderModel = new OrderModel();
    	$data = $orderModel->order_reset($data);
    	echo json_encode($data);
    	die();
    }

    /**
     * 查找店铺openid
     */
    public function shop_search(){
    	$data['order_id'] = $_POST['order_id'];
    	$orderModel = new OrderModel();
    	$data = $orderModel->shop_search($data);
    	echo json_encode($data);
    	die();
    }

	 /**
     * 查找店铺电话
     */
	 public function shop_phone(){
	 	$data['order_id'] = $_POST['order_id'];
	 	$orderModel = new OrderModel();
	 	$data = $orderModel->shop_phone($data);
	 	echo json_encode($data);
	 	die();
	 }

	 /**
     * 查找用户余额
     */
	 public function user_balance(){
	 	$orderModel = new OrderModel();
	 	$data = $orderModel->user_balance($_POST);
	 	echo json_encode($data);
	 	die();
	 }

    /**
     * 	支付成功页面
     */
    public function order_yes(){
    	$data['order_id'] = $_POST['order_id'];
    	$orderModel = new OrderModel();
    	$data = $orderModel->order_yes($data);
    	echo json_encode($data);
    	die();
    }

    /**
     * 	退单成功页面
     */
    public function order_no(){
    	$data['order_id'] = $_POST['order_id'];
    	$orderModel = new OrderModel();
    	$data = $orderModel->order_no($data);
    	echo json_encode($data);
    	die();
    }

    /**
     * 	派奖成功页面
     */
    public function order_paj(){
    	$data['order_id'] = $_POST['order_id'];
    	$orderModel = new OrderModel();
    	$data = $orderModel->order_paj($data);
    	echo json_encode($data);
    	die();
    }

    /**
     * 	查询订单状态
     */
    public function order_check(){
    	$data['order_id'] = $_POST['order_id'];
    	$orderModel = new OrderModel();
    	$data = $orderModel->order_check($data);
    	echo json_encode($data);
    	die();
    }

     /**
     * 	出票入库
     */
     public function cp_rk(){
     	$orderModel = new OrderModel();
     	$data = $orderModel->cp_rk($_POST);
     	echo json_encode($data);
     	die();
     }

    /**
     * 	再来一单
     */
    public function order_more(){
    	$data['order_id'] = $_POST['order_id'];
    	$orderModel = new OrderModel();
    	$data = $orderModel->order_more($data);
    	echo json_encode($data);
    	die();
    }

    /**
     * 	搜索订单号
     */
    public function serach_orderid(){
    	$orderModel = new OrderModel();
    	$data = $orderModel->serach_orderid($_POST);
    	echo json_encode($data);
    	die();
    }

    

}