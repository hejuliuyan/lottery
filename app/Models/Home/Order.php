<?php namespace App\Models\Home;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use DB;
use Log;
use Illuminate\Support\Facades\Session;

/**
 * 订单相关
 *
 * @author deng 2016‎年‎8‎月‎19‎日，‏‎11:25:36
 */
class Order extends Model
{

    /**
     * 生成订单
     */
    public function order($data)
    {
        $uid = DB::select('select id from cp_member where tokenid =' . "'" . $data['userid'] . "'");
        foreach ($uid as $key => $value) {
            $uid = $value->id;
        }

        $order_num = time() . $uid . mt_rand(1000, 9999);
        $sql = DB::table('cp_order')->insertGetId(array('uid' => $uid, 'order_num' => $order_num, 'order_qi' => $data['order_qi'], 'order_date' => time(), 'order_money' => $data['order_money'], 'order_z' => $data['order_z'], 'order_b' => $data['order_b'], 'type' => $data['type'], 'user_mobile' => $data['user_mobile'], 'add' => $data['add'], 'order_type' => $data['type_id'], 'order_shop' => $data['shop_id'], 'update_date' => time()));

        $order_id = DB::table('cp_order')->where('order_num', $order_num)->pluck('id');

        $lists = json_decode($data['cp_hm']);
        //$cp_lists = explode("_",$lists);
        foreach ($lists as $value) {
            if (isset($value->dlt_types)) {
                $sql = DB::table('cp_order_detail')->insertGetId(array('order_id' => $order_id, 'numbers' => "" . $value->num . "", 'c_types' => "" . $value->dlt_types . "", 'num_z' => "" . $value->z . ""));
            } elseif (isset($value->types)) {
                $sql = DB::table('cp_order_detail')->insertGetId(array('order_id' => $order_id, 'numbers' => "" . $value->num . "", 'c_types' => "" . $value->types . "", 'num_z' => "" . $value->z . ""));
            } else {
                $sql = DB::table('cp_order_detail')->insertGetId(array('order_id' => $order_id, 'numbers' => "" . $value->num . "", 'num_z' => "" . $value->z . ""));
            }


        }
        return $order_id;
    }

    /**
     * 排三插入订单投注方式
     */
    public function order_tz_type($data)
    {
        $da = DB::table('cp_order')->where('id', '=', $data['order_id'])->update(array('tz_type' => $data['tz_type']));
        if ($da) {
            return true;
        } else {
            return false;
        }

    }

    /**
     * 读取订单信息
     */
    public function order_detail($data)
    {
        $uid = DB::select('select id from cp_member where tokenid =' . "'" . $data['userid'] . "'");
        foreach ($uid as $key => $value) {
            $uid = $value->id;
        }
        $data = DB::select('select * from cp_order where uid =' . $uid . ' and id = ' . $data['order_id']);
        return $data;
    }

    /**
     * 修改订单信息
     */
    public function updorder($data)
    {
        $sql = DB::table('cp_order')->where('id', $data['order_id'])->get();
        foreach ($sql as $key => $value) {
//			$status = $value->pay_status;
            $orderid = $value->id;
        }
        $data = DB::table('cp_order')->where('id', $data['order_id'])->update(array('order_type' => $data['type_id'], 'order_shop' => $data['shop_id']));
        $data = $orderid;
        if (!$data) {
            Log::info('修改订单信息异常');
        }
        return $data;
    }


    /**
     * 把用户的订单日志写到库里
     */
    public function orderlog($data)
    {
        $data = DB::table('cp_order_log')->insert(array('order_id' => $data['order_id'], 'time' => time(), 'd_value' => $data['d_value'], 'order_status' => $data['order_status']));
        return $data;
    }

    /**
     * 把订单日志读取出来
     */
    public function odetail_log($data)
    {
        //$sql = DB::table('cp_order_log')->where('order_id', $data['order_id'])->get();
        $sql = DB::select('select from_unixtime(time) as time,d_value,order_id,order_status from cp_order_log where order_id = ' . $data['order_id']);
        return $sql;
    }


    /**
     * 银联支付
     */
    public function order_bank($data)
    {
        $flat_trans_id = '19' . time() . mt_rand(1000, 9999);
        $user_trans_id = '17' . time() . mt_rand(1000, 9999);
        $document_id = '20' . time() . mt_rand(1000, 9999);
        //$trans_account = '00000';
        $trans_date = date('Y-m-d H:i:s', time() + 28800);
        $id = DB::table('cp_member')->where('tokenid', '=', $data['userid'])->pluck('id');
        $user_trans_balance = DB::table('cp_trans_member')->where('trans_account', '=', $id)->orderBy('trans_date', 'desc')->take(1)->select('trans_balance')->get();

        $shopid = DB::table('cp_member')->where('tokenid', '=', $data['userid'])->pluck('shop_id');
        $flat_trans_balance = DB::table('cp_trans_flat')->where('trans_account', '=', '00000')->orderBy('trans_date', 'desc')->take(1)->select('trans_balance')->get();
        if ($user_trans_balance) {
            foreach ($user_trans_balance as $k => $v) {
                $user_trans_balance = $v->trans_balance;
            }

        } else {
            $user_trans_balance = 0;

        }

        /*if ($flat_trans_balance) {
            foreach ($flat_trans_balance as $k => $v) {
                $flat_trans_balance = $v->trans_balance;
            }


        } else {
            $flat_trans_balance = 0;

        }*/


        /* $flat_trans_balance = $flat_trans_balance + $data['money'];
         $d = DB::table('cp_trans_flat')->insert(array('trans_id' => $flat_trans_id, 'document_id' => $document_id, 'order_id' => $data['order_id'], 'trans_account' => $trans_account, 'opp_account' => '1234567890', 'trans_title' => '6', 'trans_price' => $data['money'], 'trans_date' => $trans_date, 'trans_way' => '0', 'trans_balance' => $flat_trans_balance, 'trans_result' => '1'));*/

        $shop_balance = DB::table('cp_balance_shop')->where('id', '=', $shopid)->pluck('balance');
        if (!isset($shop_balance) || empty($shop_balance)) {
            $shop_balance = '0';
        }

        $d = DB::table('cp_trans_shop')->insert(array('trans_id' => $flat_trans_id, 'document_id' => $flat_trans_id, 'order_id' => $data['order_id'], 'trans_account' => $shopid, 'opp_account' => $id, 'trans_title' => '2', 'trans_price' => $data['money'], 'trans_date' => $trans_date, 'trans_way' => '3', 'trans_balance' => $shop_balance, 'trans_result' => '1'));

        $dd = DB::table('cp_trans_member')->insert(array('trans_id' => $user_trans_id, 'document_id' => $flat_trans_id, 'order_id' => $data['order_id'], 'trans_account' => $id, 'opp_account' => $shopid, 'trans_title' => '2', 'trans_price' => $data['money'], 'trans_date' => $trans_date, 'trans_way' => '3', 'trans_balance' => $user_trans_balance, 'trans_result' => '1'));


        if ($d && $dd) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 余额支付
     */
    public function order_balance($data)
    {


        /*$user_trans_id = '17' . time() . mt_rand(1000, 9999);
        $shop_trans_id = '19' . time() . mt_rand(1000, 9999);
        $document_id = '1234567890';
        $trans_account = '00000';
        $trans_date = date('Y-m-d H:i:s', time() + 28800);*/
        $id = DB::table('cp_member')->where('tokenid', '=', $data['userid'])->pluck('id');
        /*if (!isset($data['select_shop']) || empty($data['select_shop'])||$data['select_shop']=='') {
            $data['select_shop'] = DB::table('cp_member')->where('id', '=', $id)->pluck('shop_id');
        }*/
        // Log::info($data);
        //$user_trans_balance = DB::table('cp_trans_member')->where('trans_account', '=', $id)->orderBy('trans_date', 'desc')->take(1)->select('trans_balance')->get();

        /*if ($user_trans_balance) {
            foreach ($user_trans_balance as $k => $v) {
                $user_trans_balance = $v->trans_balance;
            }


        } else {
            $user_trans_balance = 0;

        }*/
        //$result = DB::table('cp_balance')->where('userid','=', $id)->where('shopid','=', $data['select_shop'])->increment('freeze_balance', $data['money']);
        $result = DB::table('cp_balance')->where('userid', '=', $id)->where('shopid', '=', $data['select_shop'])->increment('freeze_balance',$data['money']);


        /*Log::info($result);
        Log::info($data);*/
        /*$flat_money = DB::table('cp_balance_flat')->get();
        DB::table('cp_balance_flat')->update([
            'balance' => $flat_money[0]->balance + $data ['money'],
            'receipts' => $data ['money'] + $flat_money[0]->receipts
        ]);*/
        /*$shop_balance = DB::table('cp_balance_shop')->where('id', '=', $data['select_shop'])->pluck('balance');

        $aa = DB::table('cp_trans_shop')->insert(array('trans_id' => $shop_trans_id, 'document_id' => $shop_trans_id, 'order_id' => $data['order_id'], 'trans_account' => $data['select_shop'], 'opp_account' => $id, 'trans_title' => '2', 'trans_price' => $data['money'], 'trans_date' => $trans_date, 'trans_way' => '0', 'trans_balance' => $shop_balance, 'trans_result' => '0'));

        $member_money = DB::table('cp_balance_member')->where('id', '=', $id)->get();
        if (!$member_money) {
            DB::table('cp_balance_member')->insert([
                'id' => $id,
                'balance' => -$data ['money'],
                'withdraw' => $data ['money']
            ]);
        } else {
            DB::table('cp_balance_member')->where('id', '=', $id)->update([
                'balance' => $member_money[0]->balance - $data ['money'],
                'withdraw' => $data ['money'] + $member_money[0]->withdraw
            ]);
        }
        $is_res = DB::table('cp_balance')->where('userid', '=', $id)->where('shopid', '=', $data['select_shop'])->pluck('balance');
        if ($is_res) {
            DB::table('cp_balance')->where('userid', '=', $id)->where('shopid', '=', $data['select_shop'])->update([
                'balance' => $is_res - $data ['money']
            ]);
        } else {
            DB::table('cp_balance')->insert([
                'userid' => $id,
                'shopid' => $data['select_shop'],
                'balance' => -$data ['money']
            ]);
        }
        $user_trans_balance = $user_trans_balance - $data['money'];
        $dd = DB::table('cp_trans_member')->insert(array('trans_id' => $user_trans_id, 'document_id' => $user_trans_id, 'order_id' => $data['order_id'], 'trans_account' => $id, 'opp_account' => $data['select_shop'], 'trans_title' => '2', 'trans_price' => $data['money'], 'trans_date' => $trans_date, 'trans_way' => '0', 'trans_balance' => $user_trans_balance, 'trans_result' => '0'));*/

        return true;
        /*if ($dd) {
            return true;
        } else {
            return false;
        }*/
    }

    /**
     * 获取当期彩票的期数
     */
    public function cp_qi($data)
    {
        $data = DB::table('cp_types')->where('types', '=', $data['types'])->pluck('num_qi');
        return $data;
    }

    /**
     * 用户退单
     */
    public function out_order($data)
    {
        $da = DB::table('cp_order')->where('id', '=', $data['order_id'])->update(array('active' => '1', 'status' => '5'));
        $userid = DB::table('cp_member')->where('tokenid', '=', $data['userid'])->pluck('id');
        $money = DB::table('cp_order')->where('id', '=', $data['order_id'])->select('order_money', 'order_shop')->get();
        DB::table('cp_balance')->where('userid', $userid)->where('shopid', $money[0]->order_shop)->decrement('freeze_balance', $money[0]->order_money);
        return true;
        /*$user_trans_id = '17' . time() . mt_rand(1000, 9999);
        $document_id = DB::table('cp_trans_member')->where('order_id', '=', $data['order_id'])->where('trans_title', '=', '2')->pluck('trans_id');
        $trans_account = '00000';
        $trans_date = date('Y-m-d H:i:s', time() + 28800);
        $user_trans_balance = DB::table('cp_trans_member')->where('trans_account', '=', $openid)->orderBy('trans_date', 'desc')->take(1)->select('trans_balance')->get();

        if ($user_trans_balance) {
            foreach ($user_trans_balance as $k => $v) {
                $user_trans_balance = $v->trans_balance;
            }


        } else {
            $user_trans_balance = 0;

        }

        $user_trans_balance = $user_trans_balance + $money;
        $dd = DB::table('cp_trans_member')->insertGetId(array('trans_id' => $user_trans_id, 'document_id' => $document_id, 'order_id' => $data['order_id'], 'trans_account' => $openid, 'opp_account' => $openid, 'trans_title' => '5', 'trans_price' => $money, 'trans_date' => $trans_date, 'trans_way' => '2', 'trans_balance' => $user_trans_balance, 'trans_result' => '1'));


        $member_money = DB::table('cp_balance_member')->where('openid', '=', $openid)->get();
        if (!$member_money) {
            DB::table('cp_balance_member')->insert([
                'openid' => $openid,
                'balance' => $data ['money'],
                'receipts' => $data ['money']
            ]);
        } else {
            DB::table('cp_balance_member')->where('openid', '=', $openid)->update([
                'balance' => $member_money[0]->balance + $data ['money'],
                'receipts' => $data ['money'] + $member_money[0]->receipts
            ]);
        }

        if ($dd) {
            return true;
        } else {
            return false;
        }*/

    }

    /**
     * 查找店铺openid
     */
    public function shop_search($data)
    {
        $data = DB::table('cp_order')->join('cp_shop', 'cp_order.order_shop', '=', 'cp_shop.id')->where('cp_order.id', '=', $data['order_id'])->select('cp_shop.shop_openid')->get();
        if ($data) {
            return $data;
        } else {
            return false;
        }
    }

    /**
     * 查找店铺电话
     */
    public function shop_phone($data)
    {
        $data = DB::table('cp_order')->join('cp_shop', 'cp_order.order_shop', '=', 'cp_shop.id')->where('cp_order.id', '=', $data['order_id'])->select('cp_shop.keeper_mobile')->get();
        if ($data) {
            return $data;
        } else {
            return false;
        }
    }

    /**
     * 查找用户余额
     */
    public function user_balance($data)
    {
        $userid = DB::table('cp_member')->where('tokenid', '=', $data['token'])->pluck('id');
        /*$user_trans_balance = DB::table('cp_balance_member')->where('id', '=', $id)->select('balance', 'winprize')->get();
        $arr = [];
        if ($user_trans_balance) {
            foreach ($user_trans_balance as $k => $v) {
                if (isset($v->balance)) {
                    $arr['balance'] = $v->balance;
                } else {
                    $arr['balance'] = 0;
                }

                if (isset($v->winprize)) {
                    $arr['winprize'] = $v->winprize;
                } else {
                    $arr['winprize'] = 0;
                }

            }

        } else {
            $arr['balance'] = 0;
            $arr['winprize'] = 0;

        }*/
        $money_arr = DB::table('cp_balance')->where('userid', '=', $userid)->where('shopid', '=', $data['shopid'])->select('balance', 'freeze_balance')->get();
        if (!$money_arr) {
            $arr['balance'] = '0';
        } else {
            $arr['balance'] = $money_arr[0]->balance - $money_arr[0]->freeze_balance;
            if (!$arr['balance'] || $arr['balance'] <= 0) {
                $arr['balance'] = '0';
            }
        }
        return $arr;

    }

    /**
     * 支付成功页面
     */
    public function order_yes($data)
    {
        $da = DB::table('cp_trans_member')->where('order_id', '=', $data['order_id'])->where('trans_title', '=', '2')->select('document_id', 'trans_price', 'trans_date')->get();

        $d = DB::table('cp_order')->where('id', '=', $data['order_id'])->pluck('order_num');

        foreach ($da as $k => $v) {
            $v->order_num = $d;
        }

        if ($da) {
            return $da;
        } else {
            return false;
        }


    }

    /**
     * 退单成功页面
     */
    public function order_no($data)
    {
        $da = DB::table('cp_trans_member')->where('order_id', '=', $data['order_id'])->where('trans_title', '=', '5')->select('document_id', 'trans_price', 'trans_date')->get();

        $d = DB::table('cp_order')->where('id', '=', $data['order_id'])->pluck('order_num');

        foreach ($da as $k => $v) {
            $v->order_num = $d;
        }

        if ($da) {
            return $da;
        } else {
            return false;
        }


    }

    /**
     * 派奖成功页面
     */
    public function order_paj($data)
    {
        $da = DB::table('cp_trans_shop')->where('order_id', '=', $data['order_id'])->where('trans_title', '=', '3')->select('document_id', 'trans_price', 'trans_date')->get();

        $d = DB::table('cp_order')->where('id', '=', $data['order_id'])->pluck('order_num');

        foreach ($da as $k => $v) {
            $v->order_num = $d;
        }

        if ($da) {
            return $da;
        } else {
            return false;
        }


    }

    /**
     * 订单状态检查
     */
    public function order_check($data)
    {
        $da = DB::table('cp_order')->where('id', '=', $data['order_id'])->pluck('status');

        if ($da) {
            return $da;
        } else {
            return false;
        }


    }

    /**
     * 搜索订单号
     */
    public function serach_orderid($data)
    {

        $shopid = DB::table('cp_shop')->where('shop_token', '=', $data['shopid'])->pluck('id');
        $da = DB::table('cp_order')->where('order_num', '=', $data['order_num'])->where('order_shop', '=', $shopid)->pluck('id');

        if ($da) {
            return $da;
        } else {
            return false;
        }


    }

    /**
     * 重新下单
     */
    public function order_reset($data)
    {
        $da = DB::table('cp_order')->join('cp_order_detail', 'cp_order.id', '=', 'cp_order_detail.order_id')->where('cp_order.id', '=', $data['order_id'])->get();


        if ($da) {
            return $da;
        } else {
            return false;
        }


    }

    /**
     * 出票入库
     */
    public function cp_rk($data)
    {

        $user_trans_id = '17' . time() . mt_rand(1000, 9999);
        $document_id = '20' . time() . mt_rand(1000, 9999);
        $shop_trans_id = '18' . time() . mt_rand(1000, 9999);
        //$order = DB::table('cp_order')->where('id','=',$data['order_id'])->get();
        /*$document_id = DB::table('cp_trans_member')->where('order_id', '=', $data['order_id'])->where('trans_title', '=', '2')->pluck('trans_id');
        $trans_account = '00000';*/
        $trans_date = date('Y-m-d H:i:s', time() + 28800);

        $dt = DB::table('cp_order')->where('id', '=', $data['order_id'])->select('order_shop', 'order_money', 'uid')->get();

        foreach ($dt as $kk => $val) {
            $shop_type = $val->order_shop;
            $order_money = $val->order_money;
            $userid = $val->uid;
        }

        $member_money = DB::table('cp_balance_member')->where('id', '=', $userid)->get();
        /*if (!$member_money) {
            DB::table('cp_balance_member')->insert([
                'id' => $userid,
                'balance' => -$order_money,
                'withdraw' => $data ['money']
            ]);
        } else {
            DB::table('cp_balance_member')->where('id', '=', $userid)->update([
                'balance' => $member_money[0]->balance - $order_money,
                'withdraw' => $order_money + $member_money[0]->withdraw
            ]);
        }*/

        //$shop_openid = DB::table('cp_shop')->where('id', '=', $shop_type)->pluck('shop_openid');

        //$shop_trans_balance = DB::table('cp_trans_shop')->where('trans_account', '=', $shop_type)->orderBy('trans_date', 'desc')->take(1)->select('trans_balance')->get();
        $shop_trans_balance = DB::table('cp_balance_shop')->where('id', '=', $shop_type)->pluck('balance');
        $user_balance = DB::table('cp_balance_member')->where('id', '=', $userid)->pluck('balance');
        $shop_money = DB::table('cp_balance')->where('userid', '=', $userid)->where('shopid', '=', $shop_type)->pluck('balance');
        /*if ($shop_trans_balance) {
            foreach ($shop_trans_balance as $k => $v) {
                $shop_trans_balance = $v->trans_balance;
            }


        } else {
            $shop_trans_balance = 0;

        }*/
        if (!$shop_trans_balance) {
            $shop_trans_balance = 0;
        }
        if (!$user_balance) {
            $user_balance = 0;
        }
        DB::table('cp_balance')->where('userid', '=', $userid)->where('shopid', '=', $shop_type)->decrement('balance', $order_money);
        DB::table('cp_balance')->where('userid', '=', $userid)->where('shopid', '=', $shop_type)->decrement('freeze_balance', $order_money);
        //$d = DB::table('cp_trans_shop')->insert(array('trans_id' => $flat_trans_id, 'document_id' => $flat_trans_id, 'order_id' => $data['order_id'], 'trans_account' => $shopid, 'opp_account' => $id, 'trans_title' => '2', 'trans_price' => $data['money'], 'trans_date' => $trans_date, 'trans_way' => '3', 'trans_balance' => $shop_balance, 'trans_result' => '1'));

        $d = DB::table('cp_trans_member')->insert(array('trans_id' => $user_trans_id, 'document_id' => $user_trans_id, 'order_id' => $data['order_id'], 'trans_account' => $userid, 'opp_account' => $shop_type, 'trans_title' => '2', 'trans_price' => $order_money, 'trans_date' => $trans_date, 'trans_way' => '4', 'trans_balance' => $user_balance - $order_money, 'single_balance' => $shop_money - $order_money, 'trans_result' => '1'));


        /*$shop_trans_balance = $shop_trans_balance + $order_money;*/
        $dd = DB::table('cp_trans_shop')->insertGetId(array('trans_id' => $shop_trans_id, 'document_id' => $shop_trans_id, 'order_id' => $data['order_id'], 'trans_account' => $shop_type, 'opp_account' => $userid, 'trans_title' => '2', 'trans_price' => $order_money, 'trans_date' => $trans_date, 'trans_way' => '4', 'trans_balance' => $shop_trans_balance - $order_money, 'single_balance' => $shop_money - $order_money, 'trans_result' => '1'));

        DB::table('cp_balance_shop')->where('id', '=', $shop_type)->decrement('balance', $order_money);
        DB::table('cp_balance_shop')->where('id', '=', $shop_type)->increment('withdraw', $order_money);
        DB::table('cp_balance_member')->where('id', '=', $userid)->decrement('balance', $order_money);
        DB::table('cp_balance_member')->where('id', '=', $userid)->increment('withdraw', $order_money);

        if ($dd) {
            return true;
        } else {
            return false;
        }


    }

    /**
     * 再来一单
     */
    public function order_more($data)
    {
        $da = DB::table('cp_order')->where('id', '=', $data['order_id'])->get();
        $type = DB::table('cp_order')->where('id', '=', $data['order_id'])->pluck('type');
        if ($type == '03') {
            $tz_type = DB::table('cp_order')->where('id', '=', $data['order_id'])->pluck('tz_type');
        }
        $num = DB::table('cp_order_detail')->where('order_id', '=', $data['order_id'])->get();
        $time = time();
        foreach ($da as $k => $v) {
            $uid = $v->uid;
            $order_type = $v->order_type;
            $order_shop = $v->order_shop;
            $order_money = $v->order_money;
            $user_mobile = $v->user_mobile;
            $type = $v->type;
            $add = $v->add;
            $order_z = $v->order_z;
            $order_b = $v->order_b;
        }
        $order_num = $time . $uid . mt_rand(1000, 9999);
        $order_qi = DB::table('cp_types')->where('types', '=', $type)->pluck('num_qi');


        if (isset($tz_type)) {
            $dd = DB::table('cp_order')->insertGetId(array('uid' => $uid, 'order_num' => $order_num, 'order_qi' => $order_qi, 'order_date' => $time, 'order_type' => $order_type, 'order_shop' => $order_shop, 'status' => 0, 'order_money' => $order_money, 'user_mobile' => $user_mobile, 'read_status' => 1, 'type' => $type, 'add' => $add, 'order_z' => $order_z, 'order_b' => $order_b, 'win_total' => 0, 'active' => 0, 'tz_type' => $tz_type, 'update_date' => $time));
        } else {
            $dd = DB::table('cp_order')->insertGetId(array('uid' => $uid, 'order_num' => $order_num, 'order_qi' => $order_qi, 'order_date' => $time, 'order_type' => $order_type, 'order_shop' => $order_shop, 'status' => 0, 'order_money' => $order_money, 'user_mobile' => $user_mobile, 'read_status' => 1, 'type' => $type, 'add' => $add, 'order_z' => $order_z, 'order_b' => $order_b, 'win_total' => 0, 'active' => 0, 'update_date' => $time));
        }


        foreach ($num as $kk => $val) {
            $numm = DB::table('cp_order_detail')->insertGetId(array('order_id' => $dd, 'numbers' => $val->numbers, 'win' => 0, 'win_price' => 0));
        }

        $order_log = DB::table('cp_order_log')->insertGetId(array('order_id' => $dd, 'time' => $time, 'd_value' => '订单已提交', 'order_status' => '00'));


        if ($dd) {
            return $dd;
        } else {
            return false;
        }


    }

}
