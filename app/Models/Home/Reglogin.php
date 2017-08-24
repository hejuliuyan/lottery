<?php namespace App\Models\Home;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use DB;
use Log;
use Illuminate\Support\Facades\Session;


/**
 * 登录注册
 *
 * @author deng
 */
class Reglogin extends Model
{
    /**
     * 微信接收注册信息
     */
    public function reg_info($data)
    {


        $phone = $data['mobile'];
        $password = md5(md5($data['password']));
        $pid = DB::table('cp_member')->where('mobile', '=', $phone)->pluck('id');


        if ($pid) {
            return false;
        } else {
            $mid = DB::table('cp_member')->where('tokenid','=',$data['token'])->pluck('id');
            $token = substr($data['token'], 3);
            $id = DB::table('cp_member')->where('id','=',$mid)->update(array('mobile' => $phone, 'password' => $password, 'updated_at' => time(), 'tokenid' => $token));

            if ($id) {
                return $token;
            } else {
                return false;
            }
        }


    }

    /**
     * app接收注册信息
     */
    public function reg_app($data)
    {


        $phone = $data['mobile'];
        $password = md5(md5($data['password']));
        $pid = DB::table('cp_member')->where('mobile', '=', $phone)->pluck('id');


        if ($pid) {
            return false;
        } else {
            //$mid = DB::table('cp_member')->where('tokenid','=',$data['token'])->pluck('id');
            $str = "0123456789abcdefghijklmnopqrstuvwxyz";//输出字符集
            $len = strlen($str)-1;
            $t = '';
            $s = '';
            $le = 4;
            $time = (string)time();
            for ($k = 0; $k < $le; $k++) {
                $t.= $str[rand(0, $len)];
            }

            for ($i = 0; $i < 6; $i++) {
                $s.= $str[rand(0, $len)];
            }
            $s = 'xm'.$s;
            $account=$s;

            $token =$t.time();
            //return $token;
            $da = DB::table('cp_member')->insertGetId(array('account' => $account, 'openid' => '', 'created_at' => $time, 'updated_at' => $time,'mobile' => $phone, 'password' => $password,'tokenid' => $token));


            //$id = DB::table('cp_member')->where('id','=',$mid)->update(array('mobile' => $phone, 'password' => $password, 'updated_at' => time(), 'tokenid' => $token));

            if ($da) {
                return $token;
            } else {
                return false;
            }
        }


    }

    /**
     * 接收个人登录信息
     */
    public function login_info($data)
    {
        // $data = DB::select('select * from cp_hisnum where types=1 order by date asc limit 0,10');
        $phone = $data['mobile'];
        $password = md5(md5($data['password']));
        //$openid = $data['openid'];

        $da = DB::table('cp_member')->where('mobile', '=', $phone)->where('password', '=', $password)->get();
        //$openid = DB::table('cp_member')->where('mobile', $phone)->update(array('openid' => $openid));
        if ($da) {
            return $da;
        } else {
            return false;
        }


    }


    /**
     * 接收店铺登录信息
     */
    public function shoplogin_info($data)
    {
        // $data = DB::select('select * from cp_hisnum where types=1 order by date asc limit 0,10');
        $phone = $data['keeper_mobile'];
        $password = md5(md5($data['shop_pwd']));
        $open_id = $data['shop_openid'];

        $opid = DB::table('cp_shop')->where('keeper_mobile', '=', $phone)->where('shop_pwd', '=', $password)->pluck('shop_openid');

        if ($open_id == $opid) {
            $da = DB::table('cp_shop')->where('keeper_mobile', '=', $phone)->where('shop_pwd', '=', $password)->where('active','=','1')->select('id', 'shop_status', 'shop_token', 'keeper_mobile')->get();

            $daa = DB::table('cp_shop')->where('shop_account', '=', $phone)->where('shop_pwd', '=', $password)->where('active','=','1')->select('id', 'shop_status', 'shop_token', 'keeper_mobile')->get();
        } else {

            $d = DB::table('cp_shop')->where('shop_account', '=', $phone)->where('shop_pwd', '=', $password)->update(array('shop_openid' => $open_id));

            $da = DB::table('cp_shop')->where('keeper_mobile', '=', $phone)->where('shop_pwd', '=', $password)->where('active','=','1')->select('id', 'shop_status', 'shop_token', 'keeper_mobile')->get();

            $daa = DB::table('cp_shop')->where('shop_account', '=', $phone)->where('shop_pwd', '=', $password)->where('active','=','1')->select('id', 'shop_status', 'shop_token', 'keeper_mobile')->get();
        }


        /* $dat = DB::table('cp_shop')->where('keeper_mobile', '=', $phone)->where('shop_pwd', '=', $password)->update(array('shop_openid' => $open_id));*/

        if ($da) {
            return $da;
        } elseif ($daa) {
            return $daa;
        } else {
            return false;
        }


    }

    /**
     * APP端店铺登录
     */
    public function shop_login_app($data)
    {
        log::info($data);
        $phone = $data['keeper_mobile'];
        $password = md5(md5($data['shop_pwd']));
        if(isset($data['shop_shopid'])){
            $da = DB::table('cp_shop')->where('shop_token', '=', $data['shop_shopid'])->select('id', 'shop_status', 'shop_token', 'keeper_mobile')->get();
        }else{
            $da = DB::table('cp_shop')->where('keeper_mobile', '=', $phone)->where('shop_pwd', '=', $password)->select('id', 'shop_status', 'shop_token', 'keeper_mobile')->get();
        }
      
        if ($da) {
            return $da;
        } else {
            return false;
        }

    }


    /**
     * 修改密码
     */
    public function update_pass($data)
    {

        //$userid=$data['userid'];
        //$openid = $data['openid'];
        $token = $data['token'];
        $old_pass = md5(md5($data['old_pass']));
        $new_pass = md5(md5($data['new_pass']));
        $ready_pass = md5(md5($data['ready_pass']));
        if ($old_pass==$new_pass) {
            return 4;
        }
        if ($data['type'] == 'person') {
            if ($new_pass != $ready_pass) {
                return 3;
            } else {
                $da = DB::table('cp_member')->where('tokenid', '=', $token)->pluck('password');
                if ($da != $old_pass) {
                    return 2;
                } else {
                    $d = DB::table('cp_member')->where('tokenid', '=', $token)->update(array('password' => $new_pass));

                    if ($d) {
                        return true;
                    } else {
                        return false;
                    }
                }
            }
        } elseif ($data['type'] == 'shop') {
            if ($new_pass != $ready_pass) {
                return 3;
            } else {
                $da = DB::table('cp_shop')->where('shop_token', '=', $token)->pluck('shop_pwd');
                if ($da != $old_pass) {
                    return 2;
                } else {
                    $d = DB::table('cp_shop')->where('shop_token', '=', $token)->update(array('shop_pwd' => $new_pass));

                    if ($d) {
                        return true;
                    } else {
                        return false;
                    }
                }
            }
        }

    }

    /**
     * 身份完善检查
     */
    public function personal_check($data)
    {

        $userid = $data['userid'];
        $da = DB::table('cp_member')->where('tokenid', '=', $userid)->select('real_name', 'idcard_numer', 'account')->get();
        if ($da) {
            return $da;
        } else {
            return false;
        }

    }

    /**
     * 店铺身份完善检查
     */
    public function shop_check($data)
    {

        $shopid = $data['shopid'];
        $da = DB::table('cp_shop')->where('shop_token', '=', $shopid)->select('verified', 'shop_name')->get();
        if ($da) {
            return $da;
        } else {
            return false;
        }

    }


    /**
     * 投注记录
     */
    public function tz_record($data)
    {
        $skip = $data['skip'];
        $userid = $data['userid'];
        //$openid = $data['openid'];
        $sid=Session::get('shopid');
        if($sid){
            $shopid = DB::table('cp_shop')->where('shop_token','=',$sid)->pluck('id');
            $uid = DB::table('cp_member')->where('tokenid', '=', $userid)->pluck('id');

            $da = DB::table('cp_order')->join('cp_shop', 'cp_order.order_shop', '=', 'cp_shop.id')->where('uid', '=', $uid)->where('cp_shop.id','=',$shopid)->whereNotIn('cp_order.status', array(6, 7))->orderBy('order_date', 'desc')->select('cp_shop.shop_name', 'cp_order.status', 'cp_order.order_qi', 'cp_order.order_date', 'cp_order.order_money', 'cp_order.type', 'cp_order.id', 'cp_order.tz_type', 'cp_order.award')->skip($skip)->take(6)->get();
        }else{
            $uid = DB::table('cp_member')->where('tokenid', '=', $userid)->pluck('id');

            $da = DB::table('cp_order')->join('cp_shop', 'cp_order.order_shop', '=', 'cp_shop.id')->where('uid', '=', $uid)->whereNotIn('cp_order.status', array(6, 7))->orderBy('order_date', 'desc')->select('cp_shop.shop_name', 'cp_order.status', 'cp_order.order_qi', 'cp_order.order_date', 'cp_order.order_money', 'cp_order.type', 'cp_order.id', 'cp_order.tz_type', 'cp_order.award')->skip($skip)->take(6)->get();
        }
       

        foreach ($da as $k => $v) {
            $d = date('Y-m-d H:i:s', $v->order_date + 28800);
            $v->new_time = $d;
            if ($v->type == '01') {
                $v->new_type = '0';
            } elseif ($v->type == '02') {
                $v->new_type = '1';
            } elseif ($v->type == '03') {
                if ($v->tz_type == 0) {
                    $v->new_type = 2;
                } else if ($v->tz_type == 1) {
                    $v->new_type = 3;
                } else if ($v->tz_type == 2) {
                    $v->new_type = 4;
                } else if ($v->tz_type == 3) {
                    $v->new_type = 5;
                }else if ($v->tz_type == 4) {
                    $v->new_type = 7;
                }else if ($v->tz_type == 5) {
                    $v->new_type = 8;
                }else if ($v->tz_type == 6) {
                    $v->new_type = 9;
                }

            } elseif ($v->type == '04') {
                $v->new_type = '6';
            }
        }
        if ($da) {
            return $da;
        } else {
            return false;
        }

    }

    /**
     * 中奖记录
     */
    public function award_record($data)
    {
        $skip = $data['skip'];
        $userid = $data['userid'];
        //$openid = $data['openid'];
        $sid=Session::get('shopid');
        if($sid){
            $uid = DB::table('cp_member')->where('tokenid', '=', $userid)->pluck('id');
            $shopid = DB::table('cp_shop')->where('shop_token','=',$sid)->pluck('id');
            $da = DB::table('cp_order')->join('cp_shop', 'cp_order.order_shop', '=', 'cp_shop.id')->where('uid', '=', $uid)->where('cp_shop.id','=',$shopid)->orderBy('update_date', 'desc')->whereIn('cp_order.status', array(6, 7))->select('cp_shop.shop_name', 'cp_order.status', 'cp_order.order_qi', 'cp_order.order_date', 'cp_order.order_money', 'cp_order.type', 'cp_order.id')->skip($skip)->take(6)->get();
        }else{
            $uid = DB::table('cp_member')->where('tokenid', '=', $userid)->pluck('id');

            $da = DB::table('cp_order')->join('cp_shop', 'cp_order.order_shop', '=', 'cp_shop.id')->where('uid', '=', $uid)->orderBy('update_date', 'desc')->whereIn('cp_order.status', array(6, 7))->select('cp_shop.shop_name', 'cp_order.status', 'cp_order.order_qi', 'cp_order.order_date', 'cp_order.order_money', 'cp_order.type', 'cp_order.id')->skip($skip)->take(6)->get();
        }
        

        foreach ($da as $k => $v) {
            $d = date('Y-m-d H:i:s', $v->order_date + 28800);
            $v->new_time = $d;
        }
        if ($da) {
            return $da;
        } else {
            return false;
        }

    }

    /**
     * 保存方案
     */
    public function save_case($data)
    {

        $userid = $data['userid'];
        //$openid = $data['openid'];
        $order_money = $data['order_money'];
        $order_z = $data['order_z'];
        $order_b = $data['order_b'];
        //$order_content = $data['order_content'];
        $add = $data['add'];
        //$save_style = $data['save_style'];
        $save_qi = $data['order_qi'];
        $type = $data['cp_types'];
        $time = time();


        $uid = DB::table('cp_member')->where('tokenid', '=', $userid)->pluck('id');
        if (isset($data['tz_type'])) {
            if ($data['tz_type'] || $data['tz_type'] == 0) {
                $tz_type = $data['tz_type'];

                $da = DB::table('cp_save')->insertGetId(array('uid' => $uid, 'save_qi' => $save_qi, 'save_type' => $type, 'save_z' => $order_z, 'save_b' => $order_b, 'save_money' => $order_money, 'save_time' => $time, 'save_add' => $add, 'save_tz_type' => $tz_type));
            }


        } else {
            $da = DB::table('cp_save')->insertGetId(array('uid' => $uid, 'save_qi' => $save_qi, 'save_type' => $type, 'save_z' => $order_z, 'save_b' => $order_b, 'save_money' => $order_money, 'save_time' => $time, 'save_add' => $add));
        }


        $lists = $data['cp_hm'];
        $lists_n = json_decode($lists);
        //error_log(print_r($lists_n,true));die();
        //$cp_lists = explode("_", $lists);
        foreach ($lists_n as $value) {
            if (isset($value->dlt_types)) {
                $sql = DB::table('cp_save_detail')->insertGetId(array('sid' => $da, 'num' => "" . $value->num . "", 'zs_num' => "" . $value->z . "", 'c_types' => "" . $value->dlt_types . ""));
            } elseif (isset($value->types)) {
                $sql = DB::table('cp_save_detail')->insertGetId(array('sid' => $da, 'num' => "" . $value->num . "", 'zs_num' => "" . $value->z . "", 'c_types' => "" . $value->types . ""));
            } else {
                $sql = DB::table('cp_save_detail')->insertGetId(array('sid' => $da, 'num' => "" . $value->num . "", 'zs_num' => "" . $value->z . ""));

            }


        }

        if ($da) {
            return $da;
        } else {
            return false;
        }

    }


    /**
     * 查询保存方案
     */
    public function save_search($data)
    {
        $skip = $data['skip'];
        $userid = $data['userid'];
        //$openid = $data['openid'];
        $cp_type = $data['cp_type'];
        $s_time = $data['s_time'];
        $uid = DB::table('cp_member')->where('tokenid', '=', $userid)->pluck('id');

        if ($cp_type == '00') {
            if ($s_time == 'desc') {
                $da = DB::table('cp_save')->orderBy('save_time', 'desc')->where('uid', '=', $uid)->where('active','1')->skip($skip)->take(7)->get();
            } else {
                $da = DB::table('cp_save')->orderBy('save_time', 'asc')->where('uid', '=', $uid)->where('active','1')->skip($skip)->take(7)->get();
            }

        } else {
            if ($s_time == 'desc') {
                $da = DB::table('cp_save')->orderBy('save_time', 'desc')->where('uid', '=', $uid)->where('save_type', '=', $cp_type)->where('active','1')->skip($skip)->take(7)->get();
            } else {
                $da = DB::table('cp_save')->orderBy('save_time', 'asc')->where('uid', '=', $uid)->where('save_type', '=', $cp_type)->where('active','1')->skip($skip)->take(7)->get();
            }

        }


        $wk = array('星期天', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六');
        foreach ($da as $k => $v) {
            $week = date('w', $v->save_time + 28800);
            $d = date('Y-m-d', $v->save_time + 28800);
            $v->new_time = $d . '&nbsp;&nbsp;' . $wk[$week];
            if ($v->save_type == '01') {
                $v->new_type = '0';
            } elseif ($v->save_type == '02') {
                $v->new_type = '1';
            } elseif ($v->save_type == '03') {
                if ($v->save_tz_type == 0) {
                    $v->new_type = 2;
                } else if ($v->save_tz_type == 1) {
                    $v->new_type = 3;
                } else if ($v->save_tz_type == 2) {
                    $v->new_type = 4;
                } else if ($v->save_tz_type == 3) {
                    $v->new_type = 5;
                }else if ($v->save_tz_type == 4) {
                    $v->new_type = 7;
                }else if ($v->save_tz_type == 5) {
                    $v->new_type = 8;
                }else if ($v->save_tz_type == 6) {
                    $v->new_type = 9;
                }

            } elseif ($v->save_type == '04') {
                $v->new_type = '6';
            }
        }
        if ($da) {
            return $da;
        } else {
            return false;
        }

    }

    /**
     * 方案详情
     */
    public function save_detail($data)
    {

        $id = $data['id'];

        $da = DB::table('cp_save')->join('cp_save_detail', 'cp_save.id', '=', 'cp_save_detail.sid')->where('cp_save.id', '=', $id)->select('cp_save.save_type', 'cp_save.save_z', 'cp_save.save_b', 'cp_save.save_money', 'cp_save.save_add', 'cp_save.save_tz_type', 'cp_save_detail.num', 'cp_save_detail.zs_num', 'cp_save_detail.c_types')->get();
        foreach ($da as $k => $v) {
            if ($v->save_type == '01') {
                $v->new_type = '0';
            } elseif ($v->save_type == '02') {
                $v->new_type = '1';
            } elseif ($v->save_type == '03') {
                if ($v->save_tz_type == 0) {
                    $v->new_type = 2;
                } else if ($v->save_tz_type == 1) {
                    $v->new_type = 3;
                } else if ($v->save_tz_type == 2) {
                    $v->new_type = 4;
                } else if ($v->save_tz_type == 3) {
                    $v->new_type = 5;
                }else if ($v->save_tz_type == 4) {
                    $v->new_type = 7;
                }else if ($v->save_tz_type == 5) {
                    $v->new_type = 8;
                }else if ($v->save_tz_type == 6) {
                    $v->new_type = 9;
                }

            } elseif ($v->save_type == '04') {
                $v->new_type = '6';
            }
        }

        if ($da) {
            return $da;
        } else {
            return false;
        }

    }

    /**
     * 方案删除
     */
    public function save_del($data)
    {

        $id = $data['id'];
        $da = DB::table('cp_save')->where('id', '=', $id)->update(['active'=>'0']);
        $dd = DB::table('cp_save_detail')->where('sid', '=', $id)->update(['active'=>'0']);


        if ($da && $dd) {
            return true;
        } else {
            Log::info('方案删除出现异常');
            return false;
        }

    }

    /**
     * 方案详情号码
     */
    public function save_detail_num($data)
    {

        $id = $data['id'];
        $type = DB::table('cp_save')->where('id', '=', $id)->pluck('save_type');
        $tz_type = DB::table('cp_save')->where('id', '=', $id)->pluck('save_tz_type');
        $da = DB::table('cp_save_detail')->where('sid', '=', $id)->select('num')->get();

        foreach ($da as $key => $value) {
            $value->type = $type;
            if ($tz_type || $tz_type == 0) {
                $value->tz_type = $tz_type;
            }

        }
        if ($da) {
            return $da;
        } else {
            return false;
        }

    }

    /**
     * 计算可下拉次数
     */
    public function save_total($data)
    {

        $userid = $data['userid'];

        //$openid = $data['openid'];
        $type = $data['type'];
        if (isset($data['cp_type'])) {
            $cp_type = $data['cp_type'];
        }

        $uid = DB::table('cp_member')->where('tokenid', '=', $userid)->pluck('id');

        if ($type == 'save') {
            if ($cp_type == '00') {
                $da = DB::table('cp_save')->where('uid', '=', $uid)->count();
            } else {
                if ($data['cp_type']) {
                    $cp_type = $data['cp_type'];
                    $da = DB::table('cp_save')->where('save_type', '=', $cp_type)->where('uid', '=', $uid)->count();
                }

            }

            $da = ceil($da / 7);
        } else if ($type == 'tz') {
            $da = DB::table('cp_order')->where('uid', '=', $uid)->count();
            $da = ceil($da / 6);
        } else if ($type == 'zj') {
            $da = DB::table('cp_order')->where('uid', '=', $uid)->whereIn('status', array(6, 7))->count();
            $da = ceil($da / 6);
        }


        if ($da) {
            return $da;
        } else {
            return false;
        }

    }

    //获取支付密码
    public function is_pay_psd($data)
    {
        $res = DB::table('cp_member')->where('tokenid', '=', $data['userid'])->pluck('pay_psd');
        return $res;
    }

    /**
     * 支付密码新建
     */
    public function pay_add($data)
    {

        $openid = DB::table('cp_shop')->where('shop_token', '=', $data['token'])->pluck('shop_openid');
        $mem_openid = DB::table('cp_member')->where('tokenid', '=', $data['token'])->pluck('openid');
        $s = '';
        $str = "0123456789abcdefghijklmnopqrstuvwxyz";//输出字符集
        $n = 6;//输出串长度
        $len = strlen($str) - 1;

        for ($i = 0; $i < $n; $i++) {
            $s .= $str[rand(0, $len)];
        }
        $s = 'xm' . $s;

        $t = '';
        $le = 4;
        $time = (string)time();
        for ($k = 0; $k < $le; $k++) {
            $t .= $str[rand(0, $len)];
        }

        if ($data['type'] == 'mem') {
            $phone = $data['mobile'];
            $password = md5(md5($data['password']));
            $account = $s;
            $pid = DB::table('cp_member')->where('mobile', '=', $phone)->where('openid', '=', $mem_openid)->pluck('pay_psd');

            if ($pid) {
                return false;
            } else {
                $id = DB::table('cp_member')->where('mobile', '=', $phone)->where('openid', '=', $mem_openid)->update(array('pay_psd' => $password, 'updated_at' => $time));
                $userid = DB::table('cp_member')->where('mobile', '=', $phone)->pluck('id');

                $userid = (string)$userid;


                $t = "" . $t . $time . $userid . "";
                // $da = DB::table('cp_member')->where('mobile', '=', $phone)->update(array('tokenid' => $t));


                if ($id) {
                    return $t;
                } else {
                    return false;
                }
            }
        } elseif ($data['type'] == 'shop') {
            $phone = $data['mobile'];
            $password = md5(md5($data['password']));
            $account = $s;
            $pid = DB::table('cp_shop')->where('keeper_mobile', '=', $phone)->where('shop_openid', '=', $openid)->pluck('pay_psd');

            if ($pid) {
                return false;
            } else {
                $id = DB::table('cp_shop')->where('keeper_mobile', '=', $phone)->where('shop_openid', '=', $openid)->update(array('pay_psd' => $password, 'updated_at' => $time));
                $userid = DB::table('cp_shop')->where('keeper_mobile', '=', $phone)->pluck('id');

                $userid = (string)$userid;


                $t = "" . $t . $time . $userid . "";
                // $da = DB::table('cp_member')->where('mobile', '=', $phone)->update(array('tokenid' => $t));


                if ($id) {
                    return $t;
                } else {
                    return false;
                }
            }
        }


    }

    public function pay_saves($data)
    {
        //$userid=$data['userid'];
        $token = $data['token'];
        $old_pass = md5(md5($data['old_pass']));
        $new_pass = md5(md5($data['new_pass']));
        $ready_pass = md5(md5($data['ready_pass']));

        if ($data['type'] == 'person') {
            if ($new_pass != $ready_pass) {
                return '1';
            } else {
                $da = DB::table('cp_member')->where('tokenid', '=', $token)->pluck('pay_psd');
                if ($da != $old_pass) {
                    return 2;
                } else {
                    $d = DB::table('cp_member')->where('tokenid', '=', $token)->update(array('pay_psd' => $new_pass));

                    if ($d) {
                        return '3';
                    } else {
                        return '4';
                    }
                }
            }
        } elseif ($data['type'] == 'shop') {

            if ($new_pass != $ready_pass) {
                return 1;
            } else {
                $da = DB::table('cp_shop')->where('shop_token', '=', $token)->pluck('pay_psd');
                if ($da != $old_pass) {
                    return 2;
                } else {
                    $d = DB::table('cp_shop')->where('shop_token', '=', $token)->update(array('pay_psd' => $new_pass));

                    if ($d) {
                        return '3';
                    } else {
                        return '4';
                    }
                }
            }
        }

    }

    /**
     * 用户支付验证
     */
    public function do_pay($data)
    {
        $openid = DB::table('cp_member')->where('tokenid', '=', $data['token'])->pluck('openid');
        $psd = md5(md5($data['psd']));
        $is_pwd = DB::table('cp_member')->where('openid', '=', $openid)->pluck('pay_psd');
        if (!isset($is_pwd) || empty($is_pwd) || $is_pwd == null) {
            return '3';
            exit();
        }
        $res = DB::table('cp_member')->where('openid', '=', $openid)->where('pay_psd', '=', $psd)->get();
        if ($res) {
            return '1';
        } else {
            return '2';
        }
    }

    /**
     * 获取电话号码
     */
    public function get_phone($data)
    {
        $phone = DB::table('cp_member')->where('tokenid', '=', $data['token'])->pluck('mobile');
        return $phone;
    }

    /**
     * 查看我的店铺
     */
    public function myshop($data)
    {
        if(isset($data['token'])){
             $shopid = DB::table('cp_member')->where('tokenid', '=', $data['token'])->pluck('shop_id');
         }elseif(isset($data['shopid'])){
            $shopid =$data['shopid'];
         }
       
        $myshop = DB::table('cp_shop')->where('id','=',$shopid)->select('shop_name','keeper_mobile','address','shop_level','shop_token')->get();
        if($myshop){
            return $myshop;
        }else{
            return false;
        }
    }

    /**
     * 设置我的彩店
     */
    public function set_shop($data)
    {
        $data = DB::table('cp_member')->where('tokenid','=',$data['token'])->update(array('shop_id'=>$data['shopid']));
        if($data){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 扫描绑定我的彩店
     */
    public function update_shop($data)
    {
        $shopid = DB::table('cp_shop')->where('shop_token','=',$data['shopid'])->pluck('id');
        $data = DB::table('cp_member')->where('tokenid','=',$data['token'])->update(array('shop_id'=>$shopid));
        if($data){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 显示默认店铺
     */
    public function mr_shop($data)
    {
        

        $shopid = DB::table('cp_member')->where('tokenid','=',$data['token'])->pluck('shop_id');
        if(!$shopid || $shopid==0){
            return false;
        }else{
            $sid=Session::get('shopid');
            log::info($sid);
            if($sid!=''){
                $token=$sid;
                $bj=1;
                $data = DB::table('cp_shop')->where('shop_token','=',$token)->select('shop_name','id')->get();
            }else{
                $token=$data['token'];
                $bj=2;
                $data = DB::table('cp_shop')->where('id','=',$shopid)->select('shop_name','id')->get();
            }

            

            foreach ($data as $k => $v) {
                $v->bj=$bj;
            }

            if($data){
                return $data;
            }else{
                return false;
            }

        }

        
    }

    /**
     * session店铺
     */
    public function session_shop($data)
    {
        
            Session::put('shopid', $data['shopid']);
            Session::save();
            $sid = DB::table('cp_shop')->where('shop_token','=',$data['shopid'])->pluck('id');
            $data = DB::table('cp_member')->where('tokenid','=',$data['token'])->update(array('shop_id'=>$sid));
            if($data){
                return true;
            }else{
                return false;
            }

        
    }

     /**
     * 用户端检索彩店
     */
    public function pd_shop_search()
    {
        
            $sid=Session::get('shopid');
            if($sid){
                return true;
            }else{
                return false;
            }

        
    }

    /**
     * 首页标题
     */
    public function index_title()
    {
            
            $shopid=Session::get('shopid');
            if($shopid){
                $data = DB::table('cp_shop')->where('shop_token','=',$shopid)->select('shop_name')->get();
                return $data;
            }else{
                return false;
            }

        
    }

    


     /**
     * 用户个人中心余额查询
     */
    public function search_user_balance($data)
    {
            
            $shopid=Session::get('shopid');
            $uid = DB::table('cp_member')->where('tokenid','=',$data['token'])->pluck('id');
            $shop_id = DB::table('cp_shop')->where('shop_token','=',$shopid)->pluck('id');
            if($shopid){
                $user_balance = DB::table('cp_balance')->where('userid','=',$uid)->where('shopid','=',$shop_id)->select('balance','giveprize')->get();
                $arr=[];
                 if ($user_balance) {
                    foreach ($user_balance as $k => $v) {
                        if (isset($v->balance)) {
                            $arr['balance'] = $v->balance;
                        } else {
                            $arr['balance'] = 0;
                        }

                        if (isset($v->giveprize)) {
                            $arr['giveprize'] = $v->giveprize;
                        } else {
                            $arr['giveprize'] = 0;
                        }

                    }

                } else {
                    $arr['balance'] = 0;
                    $arr['giveprize'] = 0;

                }

               
            }else{
                $user_balance = DB::table('cp_balance_member')->where('id','=',$uid)->select('balance','winprize')->get();
                $arr = [];
                if ($user_balance) {
                    foreach ($user_balance as $k => $v) {
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

                }
            }

             return $arr;

        
    }


    /**
     * 搜索店铺
     */
    public function search_shop($data)
    {
        if($data['shop_info']==''){
            $data = DB::table('cp_shop')->get();
        }else{
            $data = DB::table('cp_shop')->where('shop_name', 'like','%'.$data['shop_info'].'%')->orWhere('address', 'like','%'.$data['shop_info'].'%')->get();
        }
       
        if($data){
            return $data;
        }else{
            return false;
        }

        
    }

    /**
     * 显示选择店铺
     */
    public function c_shop($data)
    {
        $shopid = DB::table('cp_member')->where('tokenid','=',$data['token'])->pluck('shop_id');

        if($shopid==$data['shopid']){
             $data = DB::table('cp_shop')->where('id','=',$data['shopid'])->select('shop_name')->get();
             foreach ($data as $k => $val) {
                 $val->mr_shop=1;
             }
        }else{
            $data = DB::table('cp_shop')->where('id','=',$data['shopid'])->select('shop_name')->get(); 
             foreach ($data as $k => $val) {
                 $val->mr_shop=0;
             }
        }
       

            if($data){
                return $data;
            }else{
                return false;
            }

        
    }


    /**
     * 商铺支付验证
     */
    public function dosp_pay($data)
    {
        $openid = DB::table('cp_shop')->where('shop_token', '=', $data['token'])->pluck('shop_openid');
        $psd = md5(md5($data['psd']));
        $is_pwd = DB::table('cp_shop')->where('shop_openid', '=', $openid)->pluck('pay_psd');
        if (!isset($is_pwd) || empty($is_pwd) || $is_pwd == null) {
            return '3';
            exit();
        }

        $res = DB::table('cp_shop')->where('shop_openid', '=', $openid)->where('pay_psd', '=', $psd)->get();
        if ($res) {
            return '1';
        } else {
            return '2';
        }
    }


    public function has_pay_psd($data)
    {
        if ($data['type'] == 'person') {
            $res = DB::table('cp_member')->where('tokenid', '=', $data['token'])->pluck('pay_psd');
        } else {
            $res = DB::table('cp_shop')->where('shop_token', '=', $data['token'])->pluck('pay_psd');
        }
        log::INFO($res);
        if ($res) {
            return 'ok';
        } else {
            return 'no';
        }
    }
}
