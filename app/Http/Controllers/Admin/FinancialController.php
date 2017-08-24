<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Financial as financialModel;
use App\Models\Admin\Access as AccessModel;
use Request;
use DB;
use Illuminate\Pagination\LengthAwarePaginator;
use App\trans_member;
use App\trans_flat;
use Log;

/**
 * 财务管理
 * @task 81
 * @author zhou 2016年6月27号13:52
 */
class FinancialController extends Controller
{
    /**
     * 财务管理
     */
    public function platform_show()
    {
        //判断筛选条件是否为空
        $data ['trans_id'] = (isset ($_GET ['trans_id'])) ? $_GET ['trans_id'] : '';
        $data ['document_id'] = (isset ($_GET ['document_id'])) ? $_GET ['document_id'] : '';
        $data ['order_id'] = (isset ($_GET ['order_id'])) ? $_GET ['order_id'] : '';
        $data ['statr_time'] = (isset ($_GET ['statr_time'])) ? $_GET ['statr_time'] : '';
        $data ['end_time'] = (isset ($_GET ['end_time'])) ? $_GET ['end_time'] : '';
        $Model = new financialModel ();
        $lists = $Model->platform_show($data);//获取财务数据
        $arr = array(
            1 => '用充到账',
            2 => '店充到账',
            3 => '店提到账',
            4 => '店派到账',
            5 => '用提到账',
            6 => '用支到账'
        );
        return view('admin.financial.index')->with('lists', $lists)->with('arr', $arr)->with('where', $data);
    }

    /**
     * 平台帐务导出
     */
    public function export_platform()
    {
        $Model = new financialModel ();
        $data = $Model->export_platform();//获取平台帐务数据
        $name = '平台财务表' . date('Y-m-d H:i:s', time());//设置excel名称
        $arr = array(
            1 => '用充到账',
            2 => '店充到账',
            3 => '店提到账',
            4 => '店派到账',
            5 => '用提到账',
            6 => '用支到账'
        );
        $way = array(
            0 => iconv("UTF-8", "GBK", '银联支付')
        );

        $this->export_ex($data, $name, $arr, $way);//调用导出方法导出
    }

    /**
     * 个人账单管理
     */
    public function personal_show()
    {
        //判断检索条件是否为空
        $data ['mobile'] = (isset ($_GET ['mobile'])) ? $_GET ['mobile'] : '';
        $data ['document_id'] = (isset ($_GET ['document_id'])) ? $_GET ['document_id'] : '';
        $data ['order_id'] = (isset ($_GET ['order_id'])) ? $_GET ['order_id'] : '';
        $data ['statr_time'] = (isset ($_GET ['statr_time'])) ? $_GET ['statr_time'] : '';
        $data ['end_time'] = (isset ($_GET ['end_time'])) ? $_GET ['end_time'] : '';
        $Model = new financialModel ();
        $lists = $Model->personal_show($data);//获取个人账单数据
        // error_log ( print_r ( $lists, true ) );
        $arr = array(
            1 => '用户充值',
            2 => '用户支付',
            3 => '用户兑奖',
            4 => '用户提现',
            5 => '用户退单'
        );
        $way_arr = array(
            0 => '用户划账',
            1 => '店铺划账',
            2 => '平台划账',
            3 => '银联支付',
            4 => '线下支付'
        );
        return view('admin.financial.personal')->with('lists', $lists)->with('arr', $arr)->with('way_arr', $way_arr)->with('where', $data);
    }

    /**
     *  个人财务表导出
     */
    public function export_personal()
    {
        $Model = new financialModel ();
        $data = $Model->export_personal();//获取个人账单数据
        $name = '个人财务表' . date('Y-m-d H:i:s', time());//设置excel名称
        $arr = array(
            1 => '用户充值',
            2 => '用户支付',
            3 => '用户兑奖',
            4 => '用户提现',
            5 => '用户退单'
        );
        $way = array(
            0 => iconv("UTF-8", "GBK", '用户划账'),
            1 => iconv("UTF-8", "GBK", '店铺划账'),
            2 => iconv("UTF-8", "GBK", '平台划账'),
            3 => iconv("UTF-8", "GBK", '银联支付'),
            4 => iconv("UTF-8", "GBK", '线下支付')
        );
        $this->export_ex($data, $name, $arr, $way);//调用导出方法导出
    }

    /**
     *
     *  店铺帐务列表
     */
    public function shop_money()
    {
        //判断检索条件是否为空
        $data ['keeper_mobile'] = (isset ($_GET ['keeper_mobile'])) ? $_GET ['keeper_mobile'] : '';
        $data ['document_id'] = (isset ($_GET ['document_id'])) ? $_GET ['document_id'] : '';
        $data ['order_id'] = (isset ($_GET ['order_id'])) ? $_GET ['order_id'] : '';
        $data ['statr_time'] = (isset ($_GET ['statr_time'])) ? $_GET ['statr_time'] : '';
        $data ['end_time'] = (isset ($_GET ['end_time'])) ? $_GET ['end_time'] : '';
        $Model = new financialModel ();
        $lists = $Model->shop_money($data);//获取店铺帐务数据
        $arr = array(
            1 => '店铺充值',
            2 => '店铺收款',
            3 => '店铺派奖',
            4 => '店铺提现',
            5 => '用充到账'
        );
        $way_arr = array(
            0 => '用户划账',
            1 => '店铺划账',
            2 => '平台划账',
            3 => '银联支付',
            4 => '线下支付'
        );
        return view('admin.financial.shop_money')->with('lists', $lists)->with('arr', $arr)->with('way_arr', $way_arr)->with('where', $data);
    }

    /**
     * 店铺财务表导出
     */
    public function export_shop()
    {
        $Model = new financialModel ();
        $data = $Model->export_shop();//获取店铺帐务数据
        $name = '店铺财务表' . date('Y-m-d H:i:s', time());//设置excel名称
        $arr = array(
            1 => '店铺充值',
            2 => '店铺收款',
            3 => '店铺派奖',
            4 => '店铺提现',
            5 => '用充到账'
        );
        $way = array(
            0 => iconv("UTF-8", "GBK", '用户划账'),
            1 => iconv("UTF-8", "GBK", '店铺划账'),
            2 => iconv("UTF-8", "GBK", '平台划账'),
            3 => iconv("UTF-8", "GBK", '银联支付'),
            4 => iconv("UTF-8", "GBK", '线下支付')
        );
        $this->export_ex($data, $name, $arr, $way);//调用导出方法导出
    }

    /**
     *  导出表格
     */
    public function export_ex($data, $name, $arr, $way)
    {
        header("Content-type:application/octet-stream");
        header("Accept-Ranges:bytes");
        header("Content-type:application/vnd.ms-excel;charset=GBK");
        header("Content-Disposition:attachment;filename=" . $name . ".xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        $title = array(
            'id',
            '帐务号',
            '帐户名',
            '对方账户',
            '交易科目',
            '交易金额',
            '交易单号',
            '交易方式',
            '交易日期',
            '账户余额'
        );

        foreach ($title as $k => $t_arr) {
            $title[$k] = iconv("UTF-8", "GBK", $t_arr);
        }
        foreach ($data as $k => $data_arr) {
            foreach ($data_arr as $key => $v) {
                $data[$k]->$key = iconv("UTF-8", "GBK", $v);
            }
        }
        foreach ($arr as $k => $v) {
            $arr[$k] = iconv("UTF-8", "GBK", $v);
        }
        //iconv("UTF-8", "GBK", );
        foreach ($title as $val) {
            echo $val . "\t";
        }

        echo "\n";
        foreach ($data as $vals) {
            foreach ($vals as $k => $v) {
                if ($k == 'trans_title') {
                    echo $arr [$v] . "\t";
                } else if ($k == 'trans_way') {
                    echo $way[$v] . "\t";;
                } else {
                    echo $v . "\t";
                }
            }
            echo "\n";
        }
        exit ();
    }


    /**
     * 平台账户一览
     */
    public function flat_show()
    {
        $Model = new financialModel ();
        $data = $Model->flat_show();//获取平台账户数据
        return view('admin.Accounts.index')->with('data', $data);

    }

    /**
     * 个人账户一览
     */
    public function member_show()
    {
        $Model = new financialModel ();
        $data = $Model->member_show($_GET['id']);//获取个人账户数据
        return view('admin.Accounts.index')->with('data', $data)->with('type', 'member');
    }

    /**
     * 商铺账户一览
     */
    public function shop_show()
    {
        $Model = new financialModel ();
        $data = $Model->shop_show($_GET['id']);//获取商铺帐务数据
        return view('admin.Accounts.index')->with('data', $data)->with('type', 'shop');
    }


}