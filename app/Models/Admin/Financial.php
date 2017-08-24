<?php

namespace App\Models\Admin;

use App\Models\Admin\Base;
use DB;
use Illuminate\Database\Eloquent\Model;

/**
 * 帐务相关联
 * @task 81
 * @author wang
 */
class Financial extends Base
{

    /**
     *平台帐务
     */
    public function platform_show($data)
    {
        $data = DB::table('cp_trans_flat')->where(function ($query) use ($data) {
            if (!empty ($data ['document_id'])) {
                $query->where('document_id', 'like', '%' . $data ['document_id'] . '%');
            }
        })->where(function ($query) use ($data) {
            if (isset ($data ['order_id']) && is_numeric($data ['order_id'])) {
                $query->where('order_id', '=', $data ['order_id']);
            }
        })->where(function ($query) use ($data) {
            if (isset ($data ['trans_id']) && is_numeric($data ['trans_id'])) {
                $query->where('trans_id', '=', $data ['trans_id']);
            }
        })->where(function ($query) use ($data) {
            if (!empty ($data ['statr_time']) && !empty ($data ['end_time'])) {
                $query->where('trans_date', '>=', $data ['statr_time'])->where('cp_trans_flat' . '.trans_date', '<=', $data ['end_time']);
            } else if (!empty ($data ['statr_time'])) {
                $query->where('trans_date', '>=', $data ['statr_time']);
            } else if (!empty ($data ['end_time'])) {
                $query->where('trans_date', '<=', $data ['end_time']);
            }
        })->orderBy('cp_trans_flat.id', 'desc')->paginate(20);
        // error_log(print_r($data,true));
        /* $data = DB::table ( 'cp_trans_flat' )->get (); */
        /* $data = DB::select ( 'select * from cp_trans_flat as t join cp_member as m on t.opp_account=m.openid order by t.id desc' ); */
        //error_log ( print_r ( $data, true ) );
        $arr_m = DB::table('cp_member')->get();
        $arr_s = DB::table('cp_shop')->get();
        $order = DB::table('cp_order')->get();
        foreach ($data as $val) {
            foreach ($arr_m as $v_m) {
                if ($val->opp_account == $v_m->openid) {
                    $val->opp_name = $v_m->real_name;
                }
            }
            foreach ($arr_s as $v_s) {
                if ($val->opp_account == $v_s->shop_openid) {
                    $val->opp_name = $v_s->shop_name;
                }
            }
        }
        foreach ($order as $v) {
            foreach ($data as $val) {
                if ($v->id == $val->order_id) {
                    $val->order_num = $v->order_num;
                }
            }
        }
        return $data;
    }

    /**
     * 平台账务列表导出
     */
    public function export_platform()
    {
        $data = DB::table('cp_trans_flat')->select('id', 'trans_id', 'trans_account', 'opp_account', 'trans_title', 'trans_price', 'document_id', 'order_id', 'trans_way', 'trans_date', 'trans_balance')->orderBy('id', 'desc')->get();
        //error_log(print_r($data,true));
        $arr_m = DB::table('cp_member')->get();
        $arr_s = DB::table('cp_shop')->get();
        $order = DB::table('cp_order')->get();
        foreach ($data as $val) {
            foreach ($arr_m as $v_m) {
                if ($val->opp_account == $v_m->openid) {
                    $val->opp_account = $v_m->real_name;
                }
            }
            foreach ($arr_s as $v_s) {
                if ($val->opp_account == $v_s->shop_openid) {
                    $val->opp_account = $v_s->shop_name;
                }
            }
        }
        foreach ($order as $v) {
            foreach ($data as $val) {
                if ($v->id == $val->order_id) {
                    $val->order_id = $v->order_num;

                }
            }
        }
        return $data;
    }

    // 个人帐务显示
    public function personal_show($data)
    {
        $data = DB::table('cp_trans_member')->join('cp_member', 'cp_trans_member.trans_account', '=', 'cp_member.id')->where(function ($query) use ($data) {
            if (!empty ($data ['document_id'])) {
                $query->where('cp_trans_member' . '.document_id', 'like', '%' . $data ['document_id'] . '%');
            }
        })->where(function ($query) use ($data) {
            if (isset ($data ['order_id']) && is_numeric($data ['order_id'])) {
                $query->where('cp_trans_member' . '.order_id', '=', $data ['order_id']);
            }
        })->where(function ($query) use ($data) {
            if (isset ($data ['mobile']) && is_numeric($data ['mobile'])) {
                $query->where('cp_member' . '.mobile', '=', $data ['mobile']);
            }
        })->where(function ($query) use ($data) {
            if (!empty ($data ['statr_time']) && !empty ($data ['end_time'])) {
                $query->where('cp_trans_member' . '.trans_date', '>=', $data ['statr_time'])->where('cp_trans_member' . '.trans_date', '<=', $data ['end_time']);
            } else if (!empty ($data ['statr_time'])) {
                $query->where('cp_trans_member' . '.trans_date', '>=', $data ['statr_time']);
            } else if (!empty ($data ['end_time'])) {
                $query->where('cp_trans_member' . '.trans_date', '<=', $data ['end_time']);
            }
        })->orderBy('cp_trans_member.id', 'desc')->paginate(20);
        $arr = DB::table('cp_shop')->get();
        $order = DB::table('cp_order')->get();
        foreach ($data as $val) {
            foreach ($arr as $v) {
                if ($val->opp_account == $v->id) {
                    $val->opp_name = $v->shop_name;
                }
                /*if ($val->opp_account == '000000') {
                    $val->opp_name = '本平台';
                }*/
            }
        }
        foreach ($order as $v) {
            foreach ($data as $val) {
                if ($v->id == $val->order_id) {
                    $val->order_num = $v->order_num;
                }
            }
        }
        return $data;
    }

    // 个人帐务导出
    public function export_personal()
    {
        $data = DB::table('cp_trans_member')
            ->select('id', 'trans_id', 'trans_account', 'opp_account', 'trans_title', 'trans_price', 'document_id',  'trans_way', 'trans_date', 'trans_balance')
            ->orderBy('cp_trans_member.id', 'desc')->get();
        //error_log(print_r($data, true));
        $arr = DB::table('cp_shop')->get();
        $order = DB::table('cp_order')->get();
        $member = DB::table('cp_member')->get();
        foreach ($data as $val) {

            foreach ($arr as $v) {
                if ($val->opp_account == $v->id) {
                    $val->opp_account = $v->shop_name;
                }
                /*if ($val->opp_account == '000000') {
                    $val->opp_account = '本平台';
                }*/
            }
        }
        /*foreach ($order as $v) {
            foreach ($data as $val) {
                if ($v->id == $val->order_id) {
                    $val->order_id = $v->order_num;
                }
            }
        }*/
        foreach ($data as $k => $v) {
            foreach ($member as $key => $val) {
                if ($v->trans_account == $val->id) {
                    $v->trans_account = $val->real_name;
                }
            }
        }
        //error_log(print_r($data,true));
        return $data;
    }

    // 店铺帐务显示
    public function shop_money($data)
    {
        $data = DB::table('cp_trans_shop')->join('cp_shop', 'cp_trans_shop.trans_account', '=', 'cp_shop.id')->select('cp_trans_shop.*', 'cp_shop.shop_name', 'cp_shop.keeper_mobile')->where(function ($query) use ($data) {
            if (!empty ($data ['document_id'])) {
                $query->where('cp_trans_shop' . '.document_id', 'like', '%' . $data ['document_id'] . '%');
            }
        })->where(function ($query) use ($data) {
            if (isset ($data ['order_id']) && is_numeric($data ['order_id'])) {
                $query->where('cp_trans_shop' . '.order_id', '=', $data ['order_id']);
            }
        })->where(function ($query) use ($data) {
            if (isset ($data ['keeper_mobile']) && is_numeric($data ['keeper_mobile'])) {
                $query->where('cp_shop' . '.keeper_mobile', '=', $data ['keeper_mobile']);
            }
        })->where(function ($query) use ($data) {
            if (!empty ($data ['statr_time']) && !empty ($data ['end_time'])) {
                $query->where('cp_trans_shop' . '.trans_date', '>=', $data ['statr_time'])->where('cp_trans_shop' . '.trans_date', '<=', $data ['end_time']);
            } else if (!empty ($data ['statr_time'])) {
                $query->where('cp_trans_shop' . '.trans_date', '>=', $data ['statr_time']);
            } else if (!empty ($data ['end_time'])) {
                $query->where('cp_trans_shop' . '.trans_date', '<=', $data ['end_time']);
            }
        })->orderBy('cp_trans_shop.id', 'desc')->paginate(20);
        $arr = DB::table('cp_member')->get();
        $order = DB::table('cp_order')->get();
        foreach ($data as $val) {
            foreach ($arr as $v) {
                if ($val->opp_account == $v->id) {
                    $val->opp_name = $v->real_name;
                }
                /*if ($val->opp_account == '000000') {
                    $val->opp_name = '本平台';
                }*/
            }
        }
        /*foreach ($order as $v) {
            foreach ($data as $val) {
                if ($v->id == $val->order_id) {
                    $val->order_num = $v->order_num;
                }
            }
        }*/
        return $data;
    }

    // 店铺帐务导出
    public function export_shop()
    {
        $data = DB::table('cp_trans_shop')
            ->select('id', 'trans_id', 'trans_account', 'opp_account', 'trans_title', 'trans_price', 'document_id', 'trans_way', 'trans_date', 'trans_balance')->orderBy('cp_trans_shop.id', 'desc')->get();
        $arr = DB::table('cp_member')->get();
        //$order = DB::table('cp_order')->get();
        $shop = DB::table('cp_shop')->get();
        foreach ($data as $val) {
            foreach ($arr as $v) {
                if ($val->opp_account == $v->id) {
                    $val->opp_account = $v->real_name;
                }

            }
        }
        /*foreach ($order as $v) {
            foreach ($data as $val) {
                if ($v->id == $val->order_id) {
                    $val->order_id = $v->order_num;
                }
            }
        }*/
        foreach ($data as $k => $v) {
            foreach ($shop as $key => $val) {
                if ($v->trans_account == $val->id) {
                    $v->trans_account = $val->keeper_name;
                }
            }
        }
        return $data;
    }

    /**
     * 平台账户一览
    */
    public function flat_show()
    {
        $data = DB::table('cp_balance_flat')->get();
        return $data;
    }

    /**
     * 个人账户一览
     */
    public function member_show($id)
    {
        $data = DB::table('cp_balance_member')->join('cp_member', 'cp_balance_member.id', '=', 'cp_member.id')->where('cp_member.id','=',$id)->get();
        return $data;
    }
    /**
     * 商铺账户一览
     */
    public function shop_show($id)
    {
        $data = DB::table('cp_balance_shop')->join('cp_shop', 'cp_balance_shop.id', '=', 'cp_shop.id')->where('cp_shop.id','=',$id)->get();
        return $data;
    }

}

