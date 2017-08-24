<?php

namespace App\Models\Home;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use DB;
use Log;
/**
 * 店铺中心相关
 * @task 85
 * @author zhou 2016-6-29 14:49
 */
class Cashbox extends Model
{

    /**
     * 获取账单记录
     */
    public function lists($data)
    {
        $userid = DB::table('cp_member')->where('mobile',$data['phone'])->pluck('id');
        $id = DB::table('cp_shop')->where('shop_token',$data['token'])->pluck('id');
        $data ['arr'] = DB::table('cp_trans_shop')
            /* ->where ( function ($query) use ($data) {
                if (! empty ( $openid )) {
                    $query->where (  'trans_account',  $openid );
                }
            } ) */

            ->where('opp_account','=',$userid)
            ->where('trans_account', $id)
            ->where('trans_date', '>', $data ['date'])
            ->where(function ($query) use ($data) {
                if (isset ($data ['trans_date']) && is_numeric($data ['trans_date'])) {
                    $query->where('order_id', '>', $data ['trans_date']);
                }
            })->orderBy('id', 'desc')
            /*->orWhere ( 'trans_account', $openid ) */
            ->get();
        //$data ['res'] = DB::table('cp_balance_shop')->where('id', $id)->pluck('balance');
        //$data['res']=DB::table('cp_balance')->where('userid',$userid)->where('shopid',$id)->pluck('balance');
        return $data;
    }
    /**
     * 交易列表详细信息
     */
    public function info($data)
    {
        $data = DB::table('cp_trans_shop')->join('cp_member', 'cp_trans_shop.opp_account', '=', 'cp_member.id')->where('cp_trans_shop.id', $data)->select('cp_trans_shop.*','cp_member.mobile')->get();
        $arr = DB::table('cp_order')->get();
        foreach ($data as $v) {
            foreach ($arr as $val) {
                if ($v->order_id == $val->id) {
                    $v->order_num = $val->order_num;
                }
            }
        }
        return $data;
    }
    /**
     * 我的钱箱提现
     */
    public function wd($data)
    {
        $openid = DB::table('cp_shop')->where('shop_token','=',$data['token'])->pluck('shop_openid');
        /* $res = */
        $old_money = DB::table('cp_trans_flat')->select('trans_balance')->orderBy('trans_date', 'desc')->take(1)->get();
        foreach ($old_money as $k => $val) {
            $o_money = $val->trans_balance;
        }
        if (empty ($o_money)) {
            $data ['s'] = '0';
            $data ['msg'] = '操作失败';
            return $data;
            exit ();
        }
        $trans_id = time() . mt_rand(1000, 9999);
        $num = time() . mt_rand(10, 99);
        DB::beginTransaction();

        $flat_take = DB::table('cp_balance_flat')->get();
        if (!$flat_take) {
            DB::table('cp_balance_flat')->insert([
                'balance' => 0 - $data ['money'],
                'withdraw' => $data ['money']
            ]);
        } else {
            DB::table('cp_balance_flat')->update([
                'balance' => $flat_take[0]->balance - $data ['money'],
                'withdraw' => $data ['money']+$flat_take[0]->withdraw
            ]);
        }

        $res = DB::table('cp_trans_flat')->insert([
            'trans_id' => '19' . $trans_id,
            'document_id' => $num,
            'opp_account' => $openid,
            'trans_account' => '000000',
            'trans_title' => '3',
            'trans_price' => $data ['money'],
            'trans_date' => $data ['time'],
            'trans_way' => '0',
            'trans_balance' => $o_money - $data ['money'],
            'trans_result' => '1'
            /* 'tokenid' => $data ['userid']  */
        ]);

        if (isset ($res)) {
            $old_money_m = DB::table('cp_trans_shop')->select('trans_balance')->where('trans_account', $openid)->orderBy('trans_date', 'desc')->take(1)->get();
            foreach ($old_money_m as $k => $val) {
                $o_money_m = $val->trans_balance;
            }
            if (empty ($o_money_m)) {
                $o_money_m = 0;
            }
            $result = DB::table('cp_balance_shop')->where('openid', '=', $openid)->get();

            /*if(!isset($result[0]->withdraw)||$result[0]->withdraw==null){
                $result[0]->withdraw = 0;
            }*/
            if (!$result) {
                DB::table('cp_balance_shop')->insert([
                    'openid' => $openid,
                    'balance' => $result[0]->balance - $data ['money'],
                    'withdraw' => $data ['money']
                ]);
            } else {
                DB::table('cp_balance_shop')->where('openid', '=', $openid)->update([
                    'balance' => $result[0]->balance - $data ['money'],
                    'withdraw' => $data ['money']+$result[0]->withdraw
                ]);
            }
            $sql = DB::table('cp_trans_shop')->insert([
                'trans_id' => '17' . $trans_id,
                'document_id' => $num,
                /* 'order_id' => '', */
                'opp_account' => '000000',
                'trans_account' => $openid,
                'trans_title' => '4',
                'trans_price' => $data ['money'],
                'trans_date' => $data ['time'],
                'trans_way' => '2',
                'trans_balance' => $o_money_m - $data ['money'],
                'trans_result' => '1'
                /* 'tokenid' => $data ['userid']  */
            ]);
            if (isset ($sql)) {
                DB::commit();
                $res = DB::table('cp_trans_shop')->select('id')->where('trans_account', $openid)->orderBy('id', 'desc')->take(1)->get();
                foreach ($res as $k => $val) {
                    $a = $val->id;
                }
                $data ['res'] = $a;
                $data ['s'] = '1';
                $data ['msg'] = '操作成功';
            } else {
                DB::rollback();
                $data ['s'] = '0';
                $data ['msg'] = '操作失败，请联系客服';
            }
        } else {
            $data ['s'] = '0';
            $data ['msg'] = '操作失败，请重试';
        }
        return $data;
    }
    /**
     * 我的钱箱 充值
     */
    public function up($data)
    {
        $openid = DB::table('cp_shop')->where('shop_token','=',$data['token'])->pluck('shop_openid');
        /* $res = */

        // $uid = DB::select('select id from cp_member where tokenid ='."'".$data['userid']."'");
        $old_money = DB::table('cp_trans_flat')->select('trans_balance')->orderBy('id', 'desc')->take(1)->get();
        // print_r ( $old_money );
        foreach ($old_money as $k => $val) {
            $o_money = $val->trans_balance;
        }
        if (empty ($o_money)) {
            $data ['s'] = '0';
            $data ['msg'] = '操作失败';
            return $data;
            exit ();
        }
        // echo $o_money;
        $trans_id = time() . mt_rand(1000, 9999);
        $num = time() . mt_rand(10, 99);
        DB::beginTransaction();

        $flat_take = DB::table('cp_balance_flat')->get();
        if (!$flat_take) {
            DB::table('cp_balance_flat')->insert([
                'balance' => $data ['money'],
                'receipts' => $data ['money']
            ]);
        } else {
            DB::table('cp_balance_flat')->update([
                'balance' => $flat_take[0]->balance + $data ['money'],
                'receipts' => $data ['money']+$flat_take[0]->receipts
            ]);
        }


        $res = DB::table('cp_trans_flat')->insert([
            'trans_id' => '19' . $trans_id,
            'document_id' => $num,
            'opp_account' => $openid,
            'trans_account' => '000000',
            'trans_title' => '2',
            'trans_price' => $data ['money'],
            'trans_date' => $data ['time'],
            'trans_way' => '0',
            'trans_balance' => $o_money + $data ['money'],
            'trans_result' => '1'
            /* 'tokenid' => $data ['userid']  */
        ]);

        if (isset ($res)) {
            $old_money_m = DB::table('cp_trans_shop')->select('trans_balance')->where('trans_account', $openid)->orderBy('id', 'desc')->take(1)->get();

            foreach ($old_money_m as $k => $val) {
                $o_money_m = $val->trans_balance;
            }
            if (empty ($o_money_m)) {
                $o_money_m = 0;
            }

            $result = DB::table('cp_balance_shop')->where('openid', '=', $openid)->get();

            if (!$result) {
                DB::table('cp_balance_shop')->insert([
                    'openid' => $openid,
                    'balance' => $data ['money'],
                    'receipts' => $data ['money']
                ]);
            } else {
                DB::table('cp_balance_shop')->where('openid', '=', $openid)->update([
                    'balance' => $result[0]->balance + $data ['money'],
                    'receipts' => $data ['money']+$result[0]->receipts
                ]);
            }

            // echo $old_money_m;
            $sql = DB::table('cp_trans_shop')->insert([
                'trans_id' => '17' . $trans_id,
                'document_id' => $num,
                /* 'order_id' => '', */
                'opp_account' => '000000',
                'trans_account' => $openid,
                'trans_title' => '1',
                'trans_price' => $data ['money'],
                'trans_date' => $data ['time'],
                'trans_way' => '2',
                'trans_balance' => $o_money_m + $data ['money'],
                'trans_result' => '1'
                /* 'tokenid' => $data ['userid']  */
            ]);
            // error_log(print_r($sql,true));
            if (isset ($sql)) {
                DB::commit();
                $res = DB::table('cp_trans_shop')->select('id')->where('trans_account', $openid)->orderBy('id', 'desc')->take(1)->get();

                foreach ($res as $k => $val) {
                    /* $o_money_m = $val->trans_balance; */
                    $a = $val->id;
                }
                /* error_log ( print_r ( $a, true ) ); */
                $data ['res'] = $a;
                $data ['s'] = '1';
                $data ['msg'] = '操作成功';
            } else {
                DB::rollback();
                $data ['s'] = '0';
                $data ['msg'] = '操作失败，请联系客服';
            }
        } else {
            $data ['s'] = '0';
            $data ['msg'] = '操作失败，请重试';
        }
        return $data;
    }
    /**
     * 用户追加金额
     */
    public function add($data)
    {
        $shop_id = DB::table('cp_shop')->where('shop_token', '=', $data['token'])->pluck('id');
        $id = $data['uid'];
//        Log::info($id);
        $trans_id = time() . mt_rand(1000, 9999);
        $num = time() . mt_rand(10, 99);
        $shop_money = DB::table('cp_balance')->where('userid', '=', $id)->where('shopid', '=', $shop_id)->pluck('balance');
        //$old_money_m = DB::table('cp_trans_member')->select('trans_balance')->where('trans_account', $id)->orderBy('id', 'desc')->take(1)->get();
        $o_money_m = DB::table('cp_balance_member')->where('id', $id)->pluck('balance');
        $shop_balance = DB::table('cp_balance_shop')->where('id', $shop_id)->pluck('balance');
        if ((empty ($o_money_m)) || (!isset($o_money_m))) {
            $o_money_m = 0;
        }
        $result = DB::table('cp_balance_member')->where('id', '=', $id)->get();

        if (!$result || !isset($result)) {
            DB::table('cp_balance_member')->insert([
                'id' => $id,
                'balance' => $data ['money'],
                'receipts' => $data ['money']
            ]);
        } else {
            DB::table('cp_balance_member')->where('id', '=', $id)->update([
                'balance' => $result[0]->balance + $data ['money'],
                'receipts' => $data ['money'] + $result[0]->receipts
            ]);
        }
        $shop_res = DB::table('cp_balance_shop')->where('id', '=', $shop_id)->get();
        if (!isset($shop_res)||!$shop_res) {
            DB::table('cp_balance_shop')->insert([
                'id' => $shop_id,
                'balance' => $data ['money'],
                'receipts' => $data ['money']
            ]);
        } else {
            DB::table('cp_balance_shop')->where('id', '=', $shop_id)->update([
                'balance' => $shop_res[0]->balance + $data ['money'],
                'receipts' => $data ['money'] + $shop_res[0]->receipts
            ]);
        }
        $is_res = DB::table('cp_balance')->where('userid', '=', $id)->where('shopid', '=', $shop_id)->pluck('balance');
        if ($is_res) {
            DB::table('cp_balance')->where('userid', '=', $id)->where('shopid', '=', $shop_id)->update([
                'balance' => $is_res + $data ['money']
            ]);
        } else {
            DB::table('cp_balance')->insert([
                'userid' => $id,
                'shopid' => $shop_id,
                'balance' => $data ['money']
            ]);
        }
        // echo $old_money_m;
        $sql = DB::table('cp_trans_member')->insert([
            'trans_id' => '17' . $trans_id,
            'document_id' => $num,
            /* 'order_id' => '', */
            'opp_account' => $shop_id,
            'trans_account' => $id,
            'trans_title' => '1',
            'trans_price' => $data ['money'],
            'trans_date' => $data ['time'],
            'trans_way' => '4',
            'single_balance' => $shop_money + $data ['money'],
            'trans_balance' => $o_money_m + $data ['money'],
            'trans_result' => '1'
            /* 'tokenid' => $data ['userid']  */
        ]);
        $shop = DB::table('cp_trans_shop')->insert([
            'trans_id' => '19' . $trans_id,
            'document_id' => $num,
            /* 'order_id' => '', */
            'opp_account' => $id,
            'trans_account' => $shop_id,
            'trans_title' => '5',
            'trans_price' => $data ['money'],
            'trans_date' => $data ['time'],
            'trans_way' => '4',
            'single_balance' => $shop_money + $data ['money'],
            'trans_balance' => $shop_balance + $data ['money'],
            'trans_result' => '1'
        ]);
        if (isset ($sql)) {
            $res = DB::table('cp_trans_member')->select('id')->where('trans_account', $id)->orderBy('id', 'desc')->take(1)->get();
            foreach ($res as $k => $val) {
                $a = $val->id;
            }
            $data ['res'] = $a;
            $data ['s'] = '1';
            $data ['msg'] = '操作成功';
        } else {
            $data ['s'] = '0';
            $data ['msg'] = '操作失败，请联系客服';
        }

        return $data;
    }
}
