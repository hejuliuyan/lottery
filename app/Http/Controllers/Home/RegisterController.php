<?php namespace App\Http\Controllers\Home;

use App\Models\Home\Reglogin as RegloginModel;
use Request;


/**
 * 登录注册和店铺相关
 *
 * @author deng 2016‎年‎8‎月‎17‎日，‏‎10:36:06
 */
class RegisterController extends Controller
{
    /**
     * 注册
     */
    public function reg()
    {
// $name = $_POST['username'];
        $regloginModel = new RegloginModel();
        $reg = $regloginModel->reg_info($_POST);

        echo json_encode($reg);
    }

    /**
     * 个人登录
     */
    public function login()
    {

        $RegloginModel = new RegloginModel();
        $reg = $RegloginModel->login_info($_POST);

        echo json_encode($reg);
    }

    /**
     * 店铺登录
     */
    public function shop_login()
    {

        $RegloginModel = new RegloginModel();
        $reg = $RegloginModel->shoplogin_info($_POST);

        echo json_encode($reg);
    }

    /**
     * APP端店铺登录
     */
    public function shop_login_app()
    {

        $RegloginModel = new RegloginModel();
        $reg = $RegloginModel->shop_login_app($_POST);

        echo json_encode($reg);
    }

    /**
     * APP端用户注册
     */
    public function reg_app()
    {

        $RegloginModel = new RegloginModel();
        $reg = $RegloginModel->reg_app($_POST);

        echo json_encode($reg);
    }

    /**
     * 修改密码
     */
    public function update_pass()
    {

        $RegloginModel = new RegloginModel();
        $reg = $RegloginModel->update_pass($_POST);

        echo json_encode($reg);
    }

    //判断有无支付密码
    public function is_pay_psd()
    {
        if (isset($_POST['userid']) && isset($_POST['openid'])) {
            $RegloginModel = new RegloginModel();
            $data = $RegloginModel->is_pay_psd($_POST);
            /*if (isset($data)) {

            }*/
            return isset($data) ? $data : '0';
        } else {
            return false;
        }
    }

    /**
     * 身份完善检查
     */
    public function personal_check()
    {

        $RegloginModel = new RegloginModel();
        $reg = $RegloginModel->personal_check($_POST);

        echo json_encode($reg);
    }

    /**
     * 店铺身份完善检查
     */
    public function shop_check()
    {

        $RegloginModel = new RegloginModel();
        $reg = $RegloginModel->shop_check($_POST);

        echo json_encode($reg);
    }

    /**
     * 店铺信息监测
     */
    public function shopid_check()
    {

        $RegloginModel = new RegloginModel();
        $reg = $RegloginModel->shopid_check($_POST);

        echo json_encode($reg);
    }

    /**
     * 投注记录
     */
    public function tz_record()
    {

        $RegloginModel = new RegloginModel();
        $reg = $RegloginModel->tz_record($_POST);

        echo json_encode($reg);
    }

    /**
     * 中奖记录
     */
    public function award_record()
    {

        $RegloginModel = new RegloginModel();
        $reg = $RegloginModel->award_record($_POST);

        echo json_encode($reg);
    }

    /**
     * 保存方案
     */
    public function save_case()
    {

        $RegloginModel = new RegloginModel();
        $reg = $RegloginModel->save_case($_POST);

        echo json_encode($reg);
    }

    /**
     * 方案删除
     */
    public function save_del()
    {

        $RegloginModel = new RegloginModel();
        $reg = $RegloginModel->save_del($_POST);

        echo json_encode($reg);
    }

    /**
     * 查询保存方案
     */
    public function save_search()
    {

        $RegloginModel = new RegloginModel();
        $reg = $RegloginModel->save_search($_POST);

        echo json_encode($reg);
    }

    /**
     * 方案详情
     */
    public function save_detail()
    {

        $RegloginModel = new RegloginModel();
        $reg = $RegloginModel->save_detail($_POST);

        echo json_encode($reg);
    }

    /**
     * 方案详情号码
     */
    public function save_detail_num()
    {

        $RegloginModel = new RegloginModel();
        $reg = $RegloginModel->save_detail_num($_POST);
        $data = array('status' => 1, 'msg' => '成功', 'data' => $reg);
        echo json_encode($data);
    }

    /**
     * 计算可下拉次数
     */
    public function save_total()
    {

        $RegloginModel = new RegloginModel();
        $reg = $RegloginModel->save_total($_POST);
        echo json_encode($reg);
    }


    /**
     * 查找电话号码
     */
    public function get_phone()
    {

        $RegloginModel = new RegloginModel();
        $reg = $RegloginModel->get_phone($_POST);
        echo json_encode($reg);
    }

    /**
     * 支付密码新建
     */
    public function pay_psd_add()
    {
        $regloginModel = new RegloginModel();
        $reg = $regloginModel->pay_add($_POST);

        echo json_encode($reg);
    }

    /**
     * 支付密码修改
     */
    public function pay_psd_saves()
    {
        $RegloginModel = new RegloginModel();
        $reg = $RegloginModel->pay_saves($_POST);

        echo json_encode($reg);
    }

    /**
     * 用户支付密码
     */
    public function do_pay_psd()
    {
        $RegloginModel = new RegloginModel();
        $reg = $RegloginModel->do_pay($_POST);

        echo json_encode($reg);
    }

    /**
     * 支付密码
     */
    public function dosp_pay_psd()
    {
        $RegloginModel = new RegloginModel();
        $reg = $RegloginModel->dosp_pay($_POST);

        echo json_encode($reg);
    }

    /**
     * 查看支付密码密码是否设置
     */
    public function has_pay_psd()
    {
        $RegloginModel = new RegloginModel();
        $res = $RegloginModel->has_pay_psd($_POST);
        echo $res;
    }

     /**
     * 查看我的店铺
     */
    public function myshop()
    {
        $RegloginModel = new RegloginModel();
        $res = $RegloginModel->myshop($_POST);
        echo json_encode($res);
    }

     /**
     * 设置默认店铺
     */
    public function set_shop()
    {
        $RegloginModel = new RegloginModel();
        $res = $RegloginModel->set_shop($_POST);
        echo json_encode($res);
    }

    /**
     * 默认店铺显示
     */
    public function mr_shop()
    {
        $RegloginModel = new RegloginModel();
        $res = $RegloginModel->mr_shop($_POST);
        echo json_encode($res);
    }

    /**
     * sesssion店铺
     */
    public function session_shop()
    {
        $RegloginModel = new RegloginModel();
        $res = $RegloginModel->session_shop($_POST);
        echo json_encode($res);
        
    }

    /**
     * 首页标题
     */
    public function index_title()
    {
        $RegloginModel = new RegloginModel();
        $res = $RegloginModel->index_title();
        echo json_encode($res);
    }

    /**
     * 用户个人中心余额查询
     */
    public function search_user_balance()
    {
        $RegloginModel = new RegloginModel();
        $res = $RegloginModel->search_user_balance($_POST);
        echo json_encode($res);
    }

   

    /**
     * 扫描绑定店铺
     */
    public function update_shop()
    {
        $RegloginModel = new RegloginModel();
        $res = $RegloginModel->update_shop($_POST);
        echo json_encode($res);
    }

    /**
     * 显示选择店铺
     */
    public function c_shop()
    {
        $RegloginModel = new RegloginModel();
        $res = $RegloginModel->c_shop($_POST);
        echo json_encode($res);
    }

    /**
     * 判断是否扫码
     */
    public function pd_shop_search()
    {
        $RegloginModel = new RegloginModel();
        $res = $RegloginModel->pd_shop_search();
        echo json_encode($res);
    }

    /**
     * 读取彩店列表
     */
    public function search_shop(){
        $RegloginModel = new RegloginModel();
        $shoplist['lists'] = $RegloginModel->search_shop($_POST);
        $data = array('status'=>1,'msg'=>'成功','data'=>$shoplist);
        echo json_encode($data);
        die();
    }


     

}