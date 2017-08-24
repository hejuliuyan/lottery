<?php

namespace App\Http\Controllers\Home;

use App\Models\Home\Wallet as WalletModel;
use Request;
use DB;
use Log;

/**
 * 首页
 * @task 76
 * @author zhou 2016-6-23 14:32
 */
class MywalletController extends Controller
{
    /**
     * 我的钱包首页
     */
    public function index()
    {
        $WalletModel = new WalletModel ();
        if (!$_GET['shopid']) {
            $arr['shopid'] = DB::table('cp_member')->where('tokenid', '=', $_GET['token'])->pluck('shop_id');
        } else {
            $arr['shopid'] = $_GET['shopid'];
        }
        if (empty ($_GET ['date'])) {
            $_GET ['date'] = null;
        }
        //判断最近时间
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

        if ($_GET['token'] == 'null') {
            return '0';
            exit ();
        } else {
            if (isset($_GET['shopid']) && !empty($_GET['shopid']) && $_GET['shopid'] != 'undefined') {
                $arr['shopid'] = $_GET['shopid'];
            } else {
                $arr['shopid'] = DB::table('cp_member')->where('tokenid', $_GET['token'])->pluck('shop_id');
            }
//            Log::info($_GET['shopid']);
            $arr ['date'] = $date;
            $arr ['token'] = $_GET ['token'];
            $data = $WalletModel->lists($arr);
            echo json_encode($data);
            exit ();
        }

    }

    /**
     * 我的钱包交易详情页面
     */
    public function info()
    {
        $WalletModel = new WalletModel ();
        $data = $WalletModel->info($_GET ['id']);
        echo json_encode($data);
        /* var_dump($data); */
        exit ();
    }

    /**
     * 我的钱包提现
     * 已屏蔽
     */
    public function wd()
    {
        $WalletModel = new WalletModel ();
        //数据验证
        if ((!empty ($_POST ['money'])) && (!empty ($_POST ['token']))) {
            $data = $_POST;
            $data ['time'] = date("Y-m-d H:i:s", time() + 28800);//获取当前时间
            $data = $WalletModel->wd($data);
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
     * 我的钱包充值
     */
    public function up()
    {
        $WalletModel = new WalletModel ();
        // 数据验证
        if ((!empty ($_POST ['money'])) && (!empty ($_POST ['token']))) {
            $data = $_POST;
            $data ['time'] = date("Y-m-d H:i:s", time() + 28800);//获取当前时间
            $data = $WalletModel->up($data);
        } else {
            $data ['s'] = '0';
            $data ['msg'] = '操作失败，检查登录状态和支付金额';
        }
        echo json_encode($data);
    }

    /**
     *我的钱包，获取对应店铺
     */
    public function get_shops()
    {
        $WalletModel = new WalletModel ();
        $data = $WalletModel->get_shop($_POST['token']);
        echo json_encode($data);
    }

    /**
     * @return mixed
     * 获取当前用户余额
     */
    public function has_balance()
    {
        $arr = DB::table('cp_member')->where('tokenid', $_GET['token'])->select('id', 'shop_id')->get();
        $money = DB::table('cp_balance')->where('userid', $arr[0]->id)->where('shopid', $arr[0]->shop_id)->pluck('balance');
        return $money;
    }
}