<?php

namespace App\Http\Controllers\Home;

use App\Models\Home\Cashbox as CashboxModel;
use Request;
use DB;
use Log;

/**
 * 我的钱箱
 * @task 85
 * @author zhou 2016-6-23 14:32
 */
class MycashboxController extends Controller
{
    /**
     * 我的钱箱列表
     */
    public function index()
    {
        if (!$_GET['phone']) {
            return false;
        }
        $arr['phone'] = $_GET['phone'];
        $Model = new CashboxModel ();
        if (empty ($_GET ['date'])) {
            $_GET ['date'] = null;
        }
        //判断最近时间显示
        if ($_GET ['date'] == '3') {
            $time = strtotime("-3 month") + 28800;
            $date = date('Y-m-d H:i:s', $time);
        } elseif ($_GET ['date'] == '2') {
            $time = strtotime("-1 month") + 28800;
            $date = date('Y-m-d H:i:s', $time);
        } else {
            $time = strtotime("-1 week") + 28800;
            $date = date('Y-m-d H:i:s', $time);
        }
        $arr ['date'] = $date;
        $arr ['token'] = $_GET ['token'];
        $data = $Model->lists($arr);
        echo json_encode($data);
        exit ();
    }

    /**
     * 账单详情页面
     */
    public function info()
    {
        $Model = new CashboxModel ();
        $data = $Model->info($_GET ['id']);
        echo json_encode($data);
        exit ();
    }

    /**
     * 店铺提现
     */
    public function wd()
    {
        $Model = new CashboxModel ();
        //验证用户信息与提交数据
        if ((!empty ($_POST ['money'])) && (!empty ($_POST ['token']))) {
            $data = $_POST;
            $data ['time'] = date("Y-m-d H:i:s", time() + 28800);
            $data = $Model->wd($data);
        } else {
            if ((empty ($_POST ['money']) || ($_POST ['money'] == 0) || ($_POST ['money'] == null) || ($_POST ['money'] < '0.01'))) {
                $data ['msg'] = '操作失败,请检查余额与提现金额';
            } else {
                $data ['msg'] = '操作失败，检查登录状态';
            }
            $data ['s'] = '0';
        }
        echo json_encode($data);
    }

    /**
     * 店铺充值
     */
    public function up()
    {
        $Model = new CashboxModel ();
        // 数据验证
        if ((!empty ($_POST ['money'])) && (!empty ($_POST ['token']))) {
            $data = $_POST;
            $data ['time'] = date("Y-m-d H:i:s", time() + 28800);
            $data = $Model->up($data);
        } else {
            $data ['s'] = '0';
            $data ['msg'] = '操作失败，检查登录状态和支付金额';
        }
        echo json_encode($data);
    }

    /**
     * 店铺对应用户列表
     */
    public function customer()
    {
        if (isset($_POST['shopid'])) {
            //获取店铺对应用户
            $shopid = DB::table('cp_shop')->where('shop_token', $_POST['shopid'])->pluck('id');
            $arr = DB::table('cp_balance')->join('cp_member', 'cp_balance.userid', '=', 'cp_member.id')->where('cp_balance.shopid', $shopid)->select('cp_member.id', 'cp_balance.balance', 'cp_member.mobile')->get();
            return $arr;
        } else {
            return false;
        }


    }

    /**
     * 追加金额
     */
    public function Additional()
    {
        $Model = new CashboxModel ();
        //数据验证
        if ((!empty ($_POST ['money'])) && (!empty ($_POST ['token'])) && (!empty($_POST['uid']))) {
            $data = $_POST;
            $data ['time'] = date("Y-m-d H:i:s", time() + 28800);
            $data = $Model->add($data);
        } else {
            $data ['s'] = '0';
            $data ['msg'] = '操作失败，检查登录状态和支付金额';
        }
        echo json_encode($data);
    }
}
