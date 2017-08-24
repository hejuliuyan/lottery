<?php namespace App\Models\Admin;

use App\Models\Admin\Base;
use DB;
use Config;
use Log;

/**
 * 文章表模型
 *
 * @author dang
 */
class Zjcontent extends Base
{

    /**
     * 获取大乐透期数
     *
     * @param array $data 所需要插入的信息
     */
    public function user_send()
    {
        $data = DB::table('cp_draw_result')->where('types', '=', '1')->select('num')->get();
        return $data;
        die();

    }

    /**
     * 获取该期中奖号码
     *
     * @param array $data 所需要插入的信息
     */
    public function zj_num($data)
    {
        $order_qi = $data['order_qi'];
        $order_id = $data['order_id'];
        $type = DB::table('cp_order')->where('id', '=', $order_id)->pluck('type');
        $da = DB::table('cp_draw_result')->where('num', '=', $order_qi)->where('types', '=', $type)->select('numbers', 'types')->get();
        return $da;
        die();

    }

    /**
     * 获取该订单中奖总金额
     *
     * @param array $data 所需要插入的信息
     */
    public function zj_total($data)
    {
        $order_id = $data['order_id'];
        $da = DB::table('cp_order')->where('id', '=', $order_id)->select('win_total')->get();
        foreach ($da as $k => $v) {
            $v->new_money = number_format($v->win_total);
        }
        return $da;
        die();

    }

    /**
     * 店铺派奖银联支付
     *
     * @param array $data 所需要插入的信息
     */
    public function shop_bank($data)
    {
        $order_id = $data['order_id'];
        $ddd = DB::table('cp_order')->where('id', '=', $order_id)->select('win_total', 'uid')->get();

        foreach ($ddd as $k => $vo) {
            $uid = $vo->uid;
            $win_total = $vo->win_total;
        }

        $dt = DB::table('cp_order')->where('id', '=', $order_id)->select('order_shop', 'order_money')->get();

        foreach ($dt as $kk => $val) {
            $shop_type = $val->order_shop;
            $order_money = $val->order_money;
        }


        $shopid = DB::table('cp_shop')->where('id', '=', $shop_type)->pluck('id');

        $userid = DB::table('cp_member')->where('id', '=', $uid)->pluck('id');
        /*DB::beginTransaction();*/

        $dd = DB::table('cp_order')->where('id', '=', $order_id)->update(array('status' => '7'));

        $send = DB::table('cp_member')->join('cp_order', 'cp_member.id', '=', 'cp_order.uid')->where('cp_order.id', '=', $order_id)->select('cp_member.id', 'cp_member.openid')->get();

        $flat_trans_id = '19' . time() . mt_rand(1000, 9999);
        $user_trans_id = '17' . time() . mt_rand(1000, 9999);
        $shop_trans_id = '18' . time() . mt_rand(1000, 9999);
        $document_id = '20' . time() . mt_rand(1000, 9999);
        $opp_account = '21' . time() . mt_rand(1000, 9999);
        //$document_id='1234567890';
        //$trans_account = '00000';
        $trans_date = date('Y-m-d H:i:s', time() + 28800);

        //$user_trans_balance = DB::table('cp_trans_member')->where('trans_account','=',$userid)->orderBy('trans_date','desc')->take(1)->select('trans_balance')->get();

        // $flat_trans_balance = DB::table('cp_trans_flat')->where('trans_account','=','00000')->orderBy('trans_date','desc')->take(1)->select('trans_balance')->get();

        //$shop_trans_balance = DB::table('cp_trans_shop')->where('trans_account','=',$shopid)->orderBy('trans_date','desc')->take(1)->select('trans_balance')->get();
        $user_trans_balance = DB::table('cp_balance_member')->where('id', '=', $userid)->pluck('balance');
        $shop_trans_balance = DB::table('cp_balance_shop')->where('id', '=', $shopid)->pluck('balance');
        $shop_money = DB::table('cp_balance')->where('userid', '=', $userid)->where('shopid', '=', $shopid)->pluck('balance');
        /*if($user_trans_balance){
         foreach($user_trans_balance as $k=>$v){
             $user_trans_balance = $v->trans_balance;
         }

     }else{
         $user_trans_balance=0;

     }*/
        if (!$user_trans_balance) {
            $user_trans_balance = 0;
        }
        if (!$shop_trans_balance) {
            $shop_trans_balance = 0;
        }

        /*if($flat_trans_balance){
            foreach($flat_trans_balance as $k=>$v){
                $flat_trans_balance = $v->trans_balance;
            }


        }else{
            $flat_trans_balance=0;

        }*/

        /*if ($shop_trans_balance) {
            foreach ($shop_trans_balance as $k => $v) {
                $shop_trans_balance = $v->trans_balance;
            }


        } else {
            $shop_trans_balance = 0;

        }*/

        /* $flat_trans_balance = $flat_trans_balance + $win_total;*/
        //$flat = DB::table('cp_trans_flat')->insertGetId(array('trans_id'=>$flat_trans_id,'document_id'=>$document_id,'order_id'=>$data['order_id'],'trans_account'=>$trans_account,'opp_account'=>$opp_account,'trans_title'=>'4','trans_price'=>$win_total,'trans_date'=>$trans_date,'trans_way'=>'0','trans_balance'=>$flat_trans_balance,'trans_result'=>'1'));


        $shop = DB::table('cp_trans_shop')->insertGetId(array('trans_id' => $shop_trans_id, 'document_id' => $flat_trans_id, 'order_id' => $data['order_id'], 'trans_account' => $shopid, 'opp_account' => $userid, 'trans_title' => '3', 'trans_price' => $win_total, 'trans_date' => $trans_date, 'trans_way' => '４', 'trans_balance' => $shop_trans_balance, 'single_balance' => $shop_money, 'trans_result' => '1'));

        /*$user_trans_balance = $user_trans_balance + $win_total;*/
        $user = DB::table('cp_trans_member')->insertGetId(array('trans_id' => $user_trans_id, 'document_id' => $shop_trans_id, 'order_id' => $data['order_id'], 'trans_account' => $userid, 'opp_account' => $shopid, 'trans_title' => '3', 'trans_price' => $win_total, 'trans_date' => $trans_date, 'trans_way' => '４', 'trans_balance' => $user_trans_balance, 'single_balance' => $shop_money, 'trans_result' => '1'));
        DB::table('cp_balance')->where('userid', '=', $userid)->where('shopid', '=', $shopid)->increment('giveprize', $win_total);
        DB::table('cp_balance_member')->where('id', '=', $userid)->increment('winprize', $win_total);
        DB::table('cp_balance_shop')->where('id', '=', $shopid)->increment('giveprize', $win_total);

        if ($shop && $user && $send) {
            /*DB::commit();*/
            return $send;
        } else {
            /*DB::rollback();*/
            return false;
        }

        die();

    }

    /**
     * 店铺派奖余额支付
     *
     * @param array $data 所需要插入的信息
     */
    public function shop_balance_pay($data)
    {
        $order_id = $data['order_id'];
        $ddd = DB::table('cp_order')->where('id', '=', $order_id)->select('win_total', 'uid')->get();

        foreach ($ddd as $k => $vo) {
            $uid = $vo->uid;
            $win_total = $vo->win_total;
        }

        $dt = DB::table('cp_order')->where('id', '=', $order_id)->select('order_shop', 'order_money')->get();

        foreach ($dt as $kk => $val) {
            $shop_type = $val->order_shop;
        }


        $shop_openid = DB::table('cp_shop')->where('id', '=', $shop_type)->pluck('shop_openid');

        $user_openid = DB::table('cp_member')->where('id', '=', $uid)->pluck('openid');
        /*DB::beginTransaction();*/
        $dd = DB::table('cp_order')->where('id', '=', $order_id)->update(array('status' => '7'));

        $send = DB::table('cp_member')->join('cp_order', 'cp_member.id', '=', 'cp_order.uid')->where('cp_order.id', '=', $order_id)->select('cp_member.id', 'cp_member.openid')->get();

        $user_trans_id = '17' . time() . mt_rand(1000, 9999);
        $shop_trans_id = '18' . time() . mt_rand(1000, 9999);

        $document_id = '1234567890';
        $trans_date = date('Y-m-d H:i:s', time() + 28800);

        $user_trans_balance = DB::table('cp_trans_member')->where('trans_account', '=', $user_openid)->orderBy('trans_date', 'desc')->take(1)->select('trans_balance')->get();


        $shop_trans_balance = DB::table('cp_trans_shop')->where('trans_account', '=', $shop_openid)->orderBy('trans_date', 'desc')->take(1)->select('trans_balance')->get();

        if ($user_trans_balance) {
            foreach ($user_trans_balance as $k => $v) {
                $user_trans_balance = $v->trans_balance;
            }

        } else {
            $user_trans_balance = 0;

        }

        if ($shop_trans_balance) {
            foreach ($shop_trans_balance as $k => $v) {
                $shop_trans_balance = $v->trans_balance;
            }


        } else {
            $shop_trans_balance = 0;

        }

        $shop_trans_balance = $shop_trans_balance - $win_total;
        $shop = DB::table('cp_trans_shop')->insertGetId(array('trans_id' => $shop_trans_id, 'document_id' => $shop_trans_id, 'order_id' => $data['order_id'], 'trans_account' => $shop_openid, 'opp_account' => $shop_openid, 'trans_title' => '3', 'trans_price' => $win_total, 'trans_date' => $trans_date, 'trans_way' => '1', 'trans_balance' => $shop_trans_balance, 'trans_result' => '1'));

        $user_trans_balance = $user_trans_balance + $win_total;
        $user = DB::table('cp_trans_member')->insertGetId(array('trans_id' => $user_trans_id, 'document_id' => $shop_trans_id, 'order_id' => $data['order_id'], 'trans_account' => $user_openid, 'opp_account' => $shop_openid, 'trans_title' => '3', 'trans_price' => $win_total, 'trans_date' => $trans_date, 'trans_way' => '1', 'trans_balance' => $user_trans_balance, 'trans_result' => '1'));


        $flat_money = DB::table('cp_balance_flat')->get();
        DB::table('cp_balance_flat')->update([
            'balance' => $flat_money[0]->balance + $data ['money'],
            'receipts' => $data ['money'] + $flat_money[0]->receipts
        ]);
        $member_money = DB::table('cp_balance_shop')->where('openid', '=', $shop_openid)->get();
        if (!$member_money) {
            DB::table('cp_balance_shop')->insert([
                'openid' => $shop_openid,
                'balance' => -$data ['money'],
                'withdraw' => $data ['money']
            ]);
        } else {
            DB::table('cp_balance_shop')->where('openid', '=', $shop_openid)->update([
                'balance' => $member_money[0]->balance - $data ['money'],
                'withdraw' => $data ['money'] + $member_money[0]->withdraw
            ]);
        }


        if ($shop && $user && $send) {
            /*DB::commit();*/
            return $send;
        } else {
            /*DB::rollback();*/
            return false;
        }

        die();

    }

    /**
     * 获取中奖详情
     *
     * @param array $data 所需要插入的信息
     */
    public function zj_detail($data)
    {
        $order_id = $data['order_id'];
        $type = DB::table('cp_order')->where('id', '=', $order_id)->pluck('type');
        $da = DB::table('cp_order')->join('cp_order_detail', 'cp_order.id', '=', 'cp_order_detail.order_id')->where('cp_order.id', '=', $order_id)->where('cp_order_detail.win', '=', '1')->select('cp_order_detail.id')->get();
        $dd = DB::table('cp_order')->where('id', '=', $order_id)->select('win_total')->get();
        foreach ($dd as $kd => $vvl) {
            $df = number_format($vvl->win_total);
            $new_total = $vvl->win_total;
        }

        if ($type == 1) {
            $one = 0;
            $one_z = 0;
            $two = 0;
            $two_z = 0;
            $three = 0;
            $three_z = 0;
            $four = 0;
            $four_z = 0;
            $five = 0;
            $five_z = 0;
            $six = 0;
            $six_z = 0;
            $res = [];
            foreach ($da as $k => $v) {
                $dt = DB::table('cp_win_detail')->where('odd_id', '=', $v->id)->get();
                foreach ($dt as $kk => $vo) {
                    if ($vo->level == 1) {
                        $one += $vo->win_price;
                        $one_z += $vo->count;
                    }

                    if ($vo->level == 2) {
                        $two += $vo->win_price;
                        $two_z += $vo->count;
                    }

                    if ($vo->level == 3) {
                        $three += $vo->win_price;
                        $three_z += $vo->count;
                    }

                    if ($vo->level == 4) {
                        $four += $vo->win_price;
                        $four_z += $vo->count;
                    }

                    if ($vo->level == 5) {
                        $five += $vo->win_price;
                        $five_z += $vo->count;
                    }

                    if ($vo->level == 6) {
                        $six += $vo->win_price;
                        $six_z += $vo->count;
                    }
                }
            }
            $one = number_format($one);
            $two = number_format($two);
            $three = number_format($three);
            $four = number_format($four);
            $five = number_format($five);
            $six = number_format($six);


            $res = array('one' => array('money' => $one, 'z' => $one_z), 'two' => array('money' => $two, 'z' => $two_z), 'three' => array('money' => $three, 'z' => $three_z), 'four' => array('money' => $four, 'z' => $four_z), 'five' => array('money' => $five, 'z' => $five_z), 'six' => array('money' => $six, 'z' => $six_z), 'total' => $df, 'new_total' => $new_total, 'type' => $type);

        } elseif ($type == 3) {
            $zx = 0;
            $zx_z = 0;
            $z3 = 0;
            $z3_z = 0;
            $z6 = 0;
            $z6_z = 0;
            $zdan = 0;
            $zdan_z = 0;
            $hz_zx=0;
            $hz_zx_z=0;
            $hz_z3=0;
            $hz_z3_z=0;
            $hz_z6=0;
            $hz_z6_z=0;
            $res = [];

            foreach ($da as $k => $v) {
                $dt = DB::table('cp_win_detail')->where('odd_id', '=', $v->id)->get();
                foreach ($dt as $kk => $vo) {
                    if ($vo->level == 0) {
                        $zx += $vo->win_price;
                        $zx_z += $vo->count;
                    }

                    if ($vo->level == 1) {
                        $z3 += $vo->win_price;
                        $z3_z += $vo->count;
                    }

                    if ($vo->level == 2) {
                        $z6 += $vo->win_price;
                        $z6_z += $vo->count;
                    }

                    if ($vo->level == 3) {
                        $zdan += $vo->win_price;
                        $zdan_z += $vo->count;
                    }

                    if ($vo->level == 4) {
                        $hz_zx += $vo->win_price;
                        $hz_zx_z += $vo->count;
                    }

                    if ($vo->level == 5) {
                        $hz_z3 += $vo->win_price;
                        $hz_z3_z += $vo->count;
                    }

                    if ($vo->level == 6) {
                        $hz_z6 += $vo->win_price;
                        $hz_z6_z += $vo->count;
                    }

                }
            }

            $zx = number_format($zx);
            $z3 = number_format($z3);
            $z6 = number_format($z6);
            $zdan = number_format($zdan);
            $hz_zx = number_format($hz_zx);
            $hz_z3 = number_format($hz_z3);
            $hz_z6 = number_format($hz_z6);

            $res = array('zx' => array('money' => $zx, 'z' => $zx_z), 'z3' => array('money' => $z3, 'z' => $z3_z), 'z6' => array('money' => $z6, 'z' => $z6_z), 'zdan' => array('money' => $zdan, 'z' => $zdan_z),'hz_zx' => array('money' => $hz_zx, 'z' => $hz_zx_z), 'hz_z3' => array('money' => $hz_z3, 'z' => $hz_z3_z),'hz_z6' => array('money' => $hz_z6, 'z' => $hz_z6_z),'total' => $df, 'new_total' => $new_total, 'type' => $type);

        } elseif ($type == '04') {
            $zx = 0;
            $zx_z = 0;
            $res = [];

            foreach ($da as $k => $v) {
                $dt = DB::table('cp_win_detail')->where('odd_id', '=', $v->id)->get();
                foreach ($dt as $kk => $vo) {
                    if ($vo->level == 0) {
                        $zx += $vo->win_price;
                        $zx_z += $vo->count;
                    }
                }
            }

            $zx = number_format($zx);

            $res = array('zx' => array('money' => $zx, 'z' => $zx_z), 'total' => $df, 'new_total' => $new_total, 'type' => $type);


        } elseif ($type == '02') {
            $one = 0;
            $one_z = 0;
            $two = 0;
            $two_z = 0;
            $three = 0;
            $three_z = 0;
            $four = 0;
            $four_z = 0;
            $five = 0;
            $five_z = 0;
            $six = 0;
            $six_z = 0;
            $res = [];
            foreach ($da as $k => $v) {
                $dt = DB::table('cp_win_detail')->where('odd_id', '=', $v->id)->get();
                foreach ($dt as $kk => $vo) {
                    if ($vo->level == 1) {
                        $one += $vo->win_price;
                        $one_z += $vo->count;
                    }

                    if ($vo->level == 2) {
                        $two += $vo->win_price;
                        $two_z += $vo->count;
                    }

                    if ($vo->level == 3) {
                        $three += $vo->win_price;
                        $three_z += $vo->count;
                    }

                    if ($vo->level == 4) {
                        $four += $vo->win_price;
                        $four_z += $vo->count;
                    }

                    if ($vo->level == 5) {
                        $five += $vo->win_price;
                        $five_z += $vo->count;
                    }

                    if ($vo->level == 6) {
                        $six += $vo->win_price;
                        $six_z += $vo->count;
                    }
                }
            }
            $one = number_format($one);
            $two = number_format($two);
            $three = number_format($three);
            $four = number_format($four);
            $five = number_format($five);
            $six = number_format($six);


            $res = array('one' => array('money' => $one, 'z' => $one_z), 'two' => array('money' => $two, 'z' => $two_z), 'three' => array('money' => $three, 'z' => $three_z), 'four' => array('money' => $four, 'z' => $four_z), 'five' => array('money' => $five, 'z' => $five_z), 'six' => array('money' => $six, 'z' => $six_z), 'total' => $df, 'new_total' => $new_total, 'type' => $type);
        }
        return $res;
        die();

    }


    /**
     * 中奖结果处理
     *
     * @param array $data 所需要插入的信息
     */

    //task 119 zhougang save 2016/8/11 START
    public function do_zj($data)
    {

        $a = $data['zj_qi'];
        $b = $data['types'];
        //return $data;die();
        if (mb_strlen($b) < 2) {
            $b = '0' . $b;
        }
        $data = DB::table('cp_order')->join('cp_order_detail', 'cp_order.id', '=', 'cp_order_detail.order_id')->where('type', '=', $b)->where('order_qi', '=', $a)->where('cp_order.status', '=', '4')->select('numbers', 'cp_order_detail.id', 'cp_order.add', 'cp_order_detail.order_id', 'cp_order.order_b', 'cp_order.tz_type')->get();

        $zj_num = DB::table('cp_draw_result')->where('types', '=', $b)->where('num', '=', $a)->where('active', '1')->select('numbers', 'status')->get();

        if ($b == 1) {

            $zj_money = DB::table('cp_draw_result')->join('cp_winning_cash', 'cp_draw_result.id', '=', 'cp_winning_cash.mon_id')->where('types', '=', $b)->where('num', '=', $a)->where('cp_draw_result.active', '1')->select('cp_winning_cash.level', 'cp_winning_cash.cash', 'cp_winning_cash.cash_add')->get();

            //判断状态是否处理过
            foreach ($zj_num as $key => $v) {
                $z_num = $v->numbers;
                if ($v->status == 1) {
                    return 'solved';
                    die();
                }
            }

            //判断数据库数据完整性
            if (!$zj_num || !$zj_money || !$data) {
                return 'miss';
                die();
            }

           /* if(!$zj_num){
                return 'zj';
                die();
            }elseif(!$zj_money){
                return 'money';
                die();
            }elseif(!$data){
                return 'data';
                die();
            }*/

            foreach ($zj_money as $ky => $vv) {
                if ($vv->level == 1) {
                    $one_cash = $vv->cash;
                    $one_add = $vv->cash_add;
                }

                if ($vv->level == 2) {
                    $two_cash = $vv->cash;
                    $two_add = $vv->cash_add;
                }

                if ($vv->level == 3) {
                    $three_cash = $vv->cash;
                    $three_add = $vv->cash_add;
                }
            }

            $id_n = [];
            $od_id = [];
            foreach ($data as $k => $val) {

                $res = [];
                $order_b = $val->order_b;
                $num = $val->numbers;
                $id = $val->id;
                $id_n[] = $val->id;
                $add = $val->add;
                $oid = $val->order_id;
                $od_id[] = $val->order_id;
                $res[] = win($num, $z_num);//调用自定义函数win()
                //DB::beginTransaction();
                if ($res[0] == null) {
                    $da = DB::table('cp_order_detail')->where('id', '=', $id)->update(array('win' => '0'));
                    $c = DB::table('cp_order')->where('id', '=', $oid)->update(array('update_date' => time(), 'award' => 2));
                    continue;
                } else {
                    $da = DB::table('cp_order_detail')->where('id', '=', $id)->update(array('win' => '1'));

                    $c = DB::table('cp_order')->where('id', '=', $oid)->update(array('status' => '6', 'update_date' => time(), 'award' => 1));

                    $cc = DB::table('cp_order_log')->insertGetId(array('order_id' => $oid, 'time' => time(), 'd_value' => '订单已中奖', 'order_status' => '06'));

                }

                foreach ($res as $kk => $vo) {
                    if ($vo == null) {
                        continue;
                    }

                    foreach ($vo as $k2 => $vo2) {
                        if ($k2 == 'one') {
                            if ($add == 1) {
                                $win_money = $one_add * $vo2 + $one_cash * $vo2;
                            } else {
                                $win_money = $one_cash * $vo2;
                            }

                            $aa = DB::table('cp_win_detail')->where('id', '=', $id)->insert(array('odd_id' => $id, 'level' => '1', 'add' => $add, 'count' => $vo2, 'win_price' => $win_money));
                        }

                        if ($k2 == 'two') {
                            if ($add == 1) {
                                $win_money = $two_add * $vo2 + $two_cash * $vo2;
                            } else {
                                $win_money = $two_cash * $vo2;
                            }

                            $aa = DB::table('cp_win_detail')->where('id', '=', $id)->insert(array('odd_id' => $id, 'level' => '2', 'add' => $add, 'count' => $vo2, 'win_price' => $win_money));
                        }

                        if ($k2 == 'three') {
                            if ($add == 1) {
                                $win_money = $three_add * $vo2 + $three_cash * $vo2;
                            } else {
                                $win_money = $three_cash * $vo2;
                            }

                            $aa = DB::table('cp_win_detail')->where('id', '=', $id)->insert(array('odd_id' => $id, 'level' => '3', 'add' => $add, 'count' => $vo2, 'win_price' => $win_money));
                        }

                        if ($k2 == 'four') {
                            if ($add == 1) {
                                $win_money = 100 * $vo2 + 200 * $vo2;
                            } else {
                                $win_money = 200 * $vo2;
                            }
                            $aa = DB::table('cp_win_detail')->where('id', '=', $id)->insert(array('odd_id' => $id, 'level' => '4', 'add' => $add, 'count' => $vo2, 'win_price' => $win_money));
                        }

                        if ($k2 == 'five') {
                            if ($add == 1) {
                                $win_money = 5 * $vo2 + 10 * $vo2;
                            } else {
                                $win_money = 10 * $vo2;
                            }
                            $aa = DB::table('cp_win_detail')->where('id', '=', $id)->insert(array('odd_id' => $id, 'level' => '5', 'add' => $add, 'count' => $vo2, 'win_price' => $win_money));
                        }

                        if ($k2 == 'six') {
                            $win_money = 5 * $vo2;
                            $aa = DB::table('cp_win_detail')->where('id', '=', $id)->insert(array('odd_id' => $id, 'level' => '6', 'add' => $add, 'count' => $vo2, 'win_price' => $win_money));
                        }
                    }
                }
            }
        } elseif ($b == 3) {
            //判断状态是否处理过
            foreach ($zj_num as $key => $v) {
                $z_num = $v->numbers;
                if ($v->status == 1) {
                    return 'solved';
                    die();
                }
            }

            //判断数据库数据完整性
            if (!$zj_num || !$data) {
                return 'miss';
                die();
            }

            $id_n = [];
            $od_id = [];
            foreach ($data as $k => $val) {

                $res = [];
                $order_b = $val->order_b;
                $num = $val->numbers;
                $id = $val->id;
                $id_n[] = $val->id;
                $oid = $val->order_id;
                $add = 0;
                $od_id[] = $val->order_id;
                $tz_type = $val->tz_type;
                $res[] = p3_zj($z_num, $num, $tz_type);//调用自定义函数
                if ($res[0] == null) {
                    $da = DB::table('cp_order_detail')->where('id', '=', $id)->update(array('win' => '0'));
                    $c = DB::table('cp_order')->where('id', '=', $oid)->update(array('update_date' => time(), 'award' => 2));
                    continue;
                } else {
                    $da = DB::table('cp_order_detail')->where('id', '=', $id)->update(array('win' => '1'));

                    $c = DB::table('cp_order')->where('id', '=', $oid)->update(array('status' => '6', 'update_date' => time(), 'award' => 1));

                    $cc = DB::table('cp_order_log')->insertGetId(array('order_id' => $oid, 'time' => time(), 'd_value' => '订单已中奖', 'order_status' => '06'));

                }

                foreach ($res as $kk => $vo) {
                    if ($vo == null) {
                        continue;
                    }

                    foreach ($vo as $k2 => $vo2) {
                        if ($k2 == 'zx') {
                            $win_money = $vo2;
                            $aa = DB::table('cp_win_detail')->where('id', '=', $id)->insert(array('odd_id' => $id, 'level' => '0', 'add' => $add, 'count' => 1, 'win_price' => $win_money));
                        }

                        if ($k2 == 'z3') {
                            $win_money = $vo2;
                            $aa = DB::table('cp_win_detail')->where('id', '=', $id)->insert(array('odd_id' => $id, 'level' => '1', 'add' => $add, 'count' => 1, 'win_price' => $win_money));
                        }

                        if ($k2 == 'z6') {
                            $win_money = $vo2;
                            $aa = DB::table('cp_win_detail')->where('id', '=', $id)->insert(array('odd_id' => $id, 'level' => '2', 'add' => $add, 'count' => 1, 'win_price' => $win_money));
                        }

                        if ($k2 == 'zdan') {
                            $win_money = $vo2;
                            $aa = DB::table('cp_win_detail')->where('id', '=', $id)->insert(array('odd_id' => $id, 'level' => '3', 'add' => $add, 'count' => 1, 'win_price' => $win_money));
                        }

                        if ($k2 == 'hz_zx') {
                            $win_money = $vo2;
                            $aa = DB::table('cp_win_detail')->where('id', '=', $id)->insert(array('odd_id' => $id, 'level' => '4', 'add' => $add, 'count' => 1, 'win_price' => $win_money));
                        }

                        if ($k2 == 'hz_z3') {
                            $win_money = $vo2;
                            $aa = DB::table('cp_win_detail')->where('id', '=', $id)->insert(array('odd_id' => $id, 'level' => '5', 'add' => $add, 'count' => 1, 'win_price' => $win_money));
                        }

                        if ($k2 == 'hz_z6') {
                            $win_money = $vo2;
                            $aa = DB::table('cp_win_detail')->where('id', '=', $id)->insert(array('odd_id' => $id, 'level' => '6', 'add' => $add, 'count' => 1, 'win_price' => $win_money));
                        }





                    }
                }
            }
        } elseif ($b == 4) {
            //判断状态是否处理过
             foreach ($zj_num as $key => $v) {
                $z_num = $v->numbers;
                if ($v->status == 1) {
                    return 'solved';
                    die();
                }
            }


            //判断数据库数据完整性
            if (!$zj_num || !$data) {
                return 'miss';
                die();
            }

            $id_n = [];
            $od_id = [];
            foreach ($data as $k => $val) {

                $res = [];
                $order_b = $val->order_b;
                $num = $val->numbers;
                $id = $val->id;
                $id_n[] = $val->id;
                $oid = $val->order_id;
                $add = 0;
                $od_id[] = $val->order_id;
                $tz_type = $val->tz_type;
                $res[] = p5_zj($z_num, $num, $tz_type);//调用自定义函数
                if ($res[0] == null) {
                    $da = DB::table('cp_order_detail')->where('id', '=', $id)->update(array('win' => '0'));
                    $c = DB::table('cp_order')->where('id', '=', $oid)->update(array('update_date' => time(), 'award' => 2));
                    continue;
                } else {
                    $da = DB::table('cp_order_detail')->where('id', '=', $id)->update(array('win' => '1'));

                    $c = DB::table('cp_order')->where('id', '=', $oid)->update(array('status' => '6', 'update_date' => time(), 'award' => 1));

                    $cc = DB::table('cp_order_log')->insertGetId(array('order_id' => $oid, 'time' => time(), 'd_value' => '订单已中奖', 'order_status' => '06'));

                }

                foreach ($res as $kk => $vo) {
                    if ($vo == null) {
                        continue;
                    }

                    foreach ($vo as $k2 => $vo2) {
                        if ($k2 == 'zx') {
                            $win_money = $vo2;
                            $aa = DB::table('cp_win_detail')->where('id', '=', $id)->insert(array('odd_id' => $id, 'level' => '0', 'add' => $add, 'count' => 1, 'win_price' => $win_money));
                        }

                    }
                }
            }
        } elseif ($b == 2) {
            //判断状态是否处理过
            foreach ($zj_num as $key => $v) {
                $z_num = $v->numbers;
                if ($v->status == 1) {
                    return 'solved';
                    die();
                }
            }


            $zj_money = DB::table('cp_draw_result')->join('cp_winning_cash', 'cp_draw_result.id', '=', 'cp_winning_cash.mon_id')->where('types', '=', $b)->where('num', '=', $a)->where('cp_draw_result.active', '1')->where('cp_winning_cash.active', '1')->select('cp_winning_cash.level', 'cp_winning_cash.cash')->get();


            //判断数据库数据完整性
            if (!$zj_num || !$data || !$zj_money) {
                return 'miss';
                die();
            }

            foreach ($zj_money as $ky => $vv) {
                if ($vv->level == 1) {
                    $one_cash = $vv->cash;
                }

                if ($vv->level == 2) {
                    $two_cash = $vv->cash;
                }

            }

            $id_n = [];
            $od_id = [];
            foreach ($data as $k => $val) {

                $res = [];
                $order_b = $val->order_b;
                $num = $val->numbers;
                $id = $val->id;
                $id_n[] = $val->id;
                $oid = $val->order_id;
                $add = 0;
                $od_id[] = $val->order_id;
                $tz_type = $val->tz_type;
                $res[] = qxc($z_num, $num, $tz_type);//调用自定义函数
                if ($res[0] == null) {
                    $da = DB::table('cp_order_detail')->where('id', '=', $id)->update(array('win' => '0'));
                    $c = DB::table('cp_order')->where('id', '=', $oid)->update(array('update_date' => time(), 'award' => 2));
                    continue;
                } else {
                    $da = DB::table('cp_order_detail')->where('id', '=', $id)->update(array('win' => '1'));

                    $c = DB::table('cp_order')->where('id', '=', $oid)->update(array('status' => '6', 'update_date' => time(), 'award' => 1));

                    $cc = DB::table('cp_order_log')->insertGetId(array('order_id' => $oid, 'time' => time(), 'd_value' => '订单已中奖', 'order_status' => '06'));

                }

                foreach ($res as $kk => $vo) {
                    if ($vo == null) {
                        continue;
                    }

                    foreach ($vo as $k2 => $vo2) {
                        if ($k2 == 'one') {
                            $win_money = $one_cash;
                            $aa = DB::table('cp_win_detail')->where('id', '=', $id)->insert(array('odd_id' => $id, 'level' => '1', 'add' => $add, 'count' => 1, 'win_price' => $win_money));
                        }

                        if ($k2 == 'two') {
                            $win_money = $two_cash;
                            $aa = DB::table('cp_win_detail')->where('id', '=', $id)->insert(array('odd_id' => $id, 'level' => '2', 'add' => $add, 'count' => 1, 'win_price' => $win_money));
                        }

                        if ($k2 == 'three') {
                            $win_money = 1800;
                            $aa = DB::table('cp_win_detail')->where('id', '=', $id)->insert(array('odd_id' => $id, 'level' => '3', 'add' => $add, 'count' => 1, 'win_price' => $win_money));
                        }

                        if ($k2 == 'four') {
                            $win_money = 300;
                            $aa = DB::table('cp_win_detail')->where('id', '=', $id)->insert(array('odd_id' => $id, 'level' => '4', 'add' => $add, 'count' => 1, 'win_price' => $win_money));
                        }

                        if ($k2 == 'five') {
                            $win_money = 20;
                            $aa = DB::table('cp_win_detail')->where('id', '=', $id)->insert(array('odd_id' => $id, 'level' => '5', 'add' => $add, 'count' => 1, 'win_price' => $win_money));
                        }

                        if ($k2 == 'six') {
                            $win_money = 5;
                            $aa = DB::table('cp_win_detail')->where('id', '=', $id)->insert(array('odd_id' => $id, 'level' => '6', 'add' => $add, 'count' => 1, 'win_price' => $win_money));
                        }


                    }
                }
            }
        }

        foreach ($id_n as $kkk => $vol) {
            $to_money = DB::table('cp_win_detail')->where('odd_id', '=', $vol)->sum('win_price');

            $re = DB::table('cp_order_detail')->where('id', '=', $vol)->update(array('win_price' => $to_money));

        }

        foreach ($od_id as $kp => $value) {
            $total_money = DB::table('cp_order_detail')->where('order_id', '=', $value)->sum('win_price');
            $total_money = $total_money * $order_b;
            $r = DB::table('cp_order')->where('id', '=', $value)->update(array('win_total' => $total_money));
        }


        $result = DB::table('cp_draw_result')->where('types', '=', $b)->where('num', '=', $a)->where('active', '1')->update(array('status' => 1));

        if ($result) {
            //DB::commit();
            return true;
        } else {
            /* DB::rollback();
             Log::info('中奖结果出来发生异常，sql未执行完成');*/
            return false;

        }


    }
    //task119 zhougang save 2016/8/11 end
    /**
     * 微信授权
     *
     * @param array $data 所需要插入的信息
     */
    public function index($url = '', $post_data = array())
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); // 从证书中检查SSL加密算法是否存在
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
        curl_setopt($ch, CURLOPT_TIMEOUT, 10); // 设置超时限制防止死循环
        curl_setopt($ch, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
        if (!empty($post_data)) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        }
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    //access_token获取
    public function access_token()
    {
        $appid = Config::get('app.wechat_appid');
        $secret = Config::get('app.wechat_secret');
        $domain = Config::get('app.domain');
        //$appid = "wxe71525fd5bf234b2";
        //$select = "f5181264de5a62e4e627e3d6175dbeba";
        //读取本地token

        $file = 'temp/access_token.txt';
        if (!file_exists($file)) {
            $myfile = fopen($file, "wb") or die("Unable to open file!");
            fclose($myfile);
            Log::debug('[access_token]create file');
        }

        $myfile = fopen($file, "r+") or die("Unable to open file!");
        $con = fgets($myfile);
        //fclose($myfile);\
        $isGetFromWX = 0;
        if (empty($con)) {
            $isGetFromWX = 1;
            Log::debug('[access_token]empty file,isGetFromWX=' . $isGetFromWX . 'con=' . $con);
        } else {
            $arr = explode("\"", $con);
            $token = $arr[3];
            $arr_time = explode("}", $arr[6]);//his_time
            $his_time = $arr_time[1] + 7200;
            $time = time();
            if ($his_time < time()) {
                $isGetFromWX = 2;
                Log::debug('[access_token]empty file,isGetFromWX_time=' . $isGetFromWX . 'file_time=' . $his_time . 'now_time=' . $time);
            }
        }
        if ($isGetFromWX == 2 || $isGetFromWX == 1) {
            //获取token
            $token = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $appid . "&secret=" . $secret . "";
            $url = file_get_contents($token);
            $url = $url . time();
            fseek($myfile, 0);
            fwrite($myfile, $url);
            $con = $url;
            Log::debug('[access_token]get file,con=' . $con);
        }
        fclose($myfile);

        $arr = explode("\"", $con);
        $token = $arr[3];
        Log::debug('[access_token]get token,token=' . $token);
        return $token;
    }


}