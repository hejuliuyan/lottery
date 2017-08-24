<?php namespace App\Http\Controllers\Home;
use App\Models\Home\Shop as ShopModel;
use Request;

/**
 * 店铺相关功能
 * @author deng 2016‎年‎8‎月‎26‎日，‏‎17:39:41
 */
class ShopController extends Controller
{
  

    /**
     * 店铺读取订单信息
     */
    public function shop_order(){
        $ShopModel = new ShopModel();
        $res= $ShopModel->shop_order($_POST);
        $data = array('status'=>1,'msg'=>'成功','data'=>$res);
        echo json_encode($data);
       
    }

     /**
     * 接单处理
     */
    public function jd_order(){
        $ShopModel = new ShopModel();
        $res= $ShopModel->jd_order($_POST);
        $data = array('status'=>1,'msg'=>'成功','data'=>$res);
        echo json_encode($data);
       
    }

    /**
     * 店铺状态改变
     */
    public function shop_status(){
        $ShopModel = new ShopModel();
        $res= $ShopModel->shop_status($_POST);
        $data = array('status'=>1,'msg'=>'成功','data'=>$res);
        echo json_encode($data);
       
    }

    /**
     * 出票信息
     */
    public function cp_detail(){
        $ShopModel = new ShopModel();
        $res= $ShopModel->cp_detail($_POST);
        $data = array('status'=>1,'msg'=>'成功','data'=>$res);
        echo json_encode($data);
       
    }

     /**
     * 出票信息号码查询
     */
    public function cp_detail_num(){
        $ShopModel = new ShopModel();
        $res= $ShopModel->cp_detail_num($_POST);
        $data = array('status'=>1,'msg'=>'成功','data'=>$res);
        echo json_encode($data);
       
    }
    /**
     * 订单状态改变
     */
    public function cp_status(){
        $ShopModel = new ShopModel();
        $res= $ShopModel->cp_status($_POST);
        $data = array('status'=>1,'msg'=>'成功','data'=>$res);
        echo json_encode($data);
       
    }


    /**
     * 判断店铺上下线状态
     */
    public function pd_shop_status(){
        $ShopModel = new ShopModel();
        $res= $ShopModel->pd_shop_status($_POST);
        $data = array('status'=>1,'msg'=>'成功','data'=>$res);
        echo json_encode($data);
       
    }

     /**
     * 查找最新订单
     */
    public function new_order(){
        $ShopModel = new ShopModel();
        $res= $ShopModel->new_order($_POST);
        $data = array('status'=>1,'msg'=>'成功','data'=>$res);
        echo json_encode($data);
       
    }

    /**
     * 查找店铺openid
     */
    public function shop_open(){
        $ShopModel = new ShopModel();
        $res= $ShopModel->shop_open($_POST);
        $data = array('status'=>1,'msg'=>'成功','data'=>$res);
        echo json_encode($data);
       
    }

    /**
     * 改变店铺出票次数
     */
    public function cp_nums(){
        $ShopModel = new ShopModel();
        $res= $ShopModel->cp_nums($_POST);
        $data = array('status'=>1,'msg'=>'成功','data'=>$res);
        echo json_encode($data);
       
    }

    /**
     * 读取店铺待接订单
     */
    public function order_wait(){
        $ShopModel = new ShopModel();
        $res= $ShopModel->order_wait($_POST);
        $data = array('status'=>1,'msg'=>'成功','data'=>$res);
        echo json_encode($data);
       
    }

    /**
     * 读取店铺派奖订单
     */
    public function pj_wait(){
        $ShopModel = new ShopModel();
        $res= $ShopModel->pj_wait($_POST);
        $data = array('status'=>1,'msg'=>'成功','data'=>$res);
        echo json_encode($data);
       
    }

    /**
     * 查找店铺余额
     */
    public function shop_balance(){
        $orderModel = new ShopModel();
        $data = $orderModel->shop_balance($_POST);
        echo json_encode($data);
        die();
    }

}