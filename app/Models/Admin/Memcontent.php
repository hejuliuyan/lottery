<?php namespace App\Models\Admin;

use App\Models\Admin\Base;
use DB;

/**
 * 会员管理
 *
 * @author deng
 */
class Memcontent extends Base
{
    /**
     * 会员管理页面
     */
    public function members($data)
    {
        if ($data) {
            $data = DB::table('cp_member')->where('mobile', '=', $data)->select('id', 'account', 'mobile', 'created_at', 'active')->paginate(8);

            foreach ($data as $k => $v) {
                $v->created_at = date('Y-m-d', $v->created_at);
                if ($v->active == 0) {
                    $v->new_status = '启用';
                } else {
                    $v->new_status = '禁用';
                }
            }

        } else {
            $data = DB::table('cp_member')->select('id', 'account', 'mobile', 'created_at', 'active')->paginate(8);
            foreach ($data as $k => $v) {
                $v->created_at = date('Y-m-d', $v->created_at);
                if ($v->active == 0) {
                    $v->new_status = '启用';
                } else {
                    $v->new_status = '禁用';
                }
            }
        }

        return $data;
    }


    /**
     * 会员修改
     */
    public function mem_update($data)
    {
        $data = DB::table('cp_member')->where('id', '=', $data['id'])->update(array('active' => $data['active']));
        if ($data) {
            return true;
        } else {
            return false;
        }

    }

    /**
     * 会员编辑
     */
    public function mem_edit_view($data)
    {
        $data = DB::table('cp_member')->where('id','=',$data['id'])->get();
        $shop = DB::table('cp_shop')->get();
        foreach ($data as $k => $v) {
            foreach ($shop as $key => $val) {
                if ($v->shop_id == $val->id) {
                    $data[$k]->shop_name = $val->shop_name;
                }
            }
        }
        foreach ($data as $k => $v) {
            $v->created_at = date('Y-m-d', $v->created_at);
            $v->updated_at = date('Y-m-d', $v->updated_at);
            if ($v->active == 0) {
                $v->new_status = '启用';
            } else {
                $v->new_status = '禁用';
            }
        }

        return $data;

    }


    /**
     * 会员检索
     */
    public function mem_search($data)
    {
        if ($data['phone']) {
            $data = DB::table('cp_member')->where('mobile', '=', $data['phone'])->select('id', 'account', 'mobile', 'created_at', 'active')->get();

            foreach ($data as $k => $v) {
                $v->created_at = date('Y-m-d', $v->created_at);
                if ($v->active == 0) {
                    $v->new_status = '启用';
                } else {
                    $v->new_status = '禁用';
                }
            }
        } else {
            $data = DB::table('cp_member')->select('id', 'account', 'mobile', 'created_at', 'active')->paginate(3);
            //error_log(print_r($data,true));

            foreach ($data as $k => $v) {
                $v->created_at = date('Y-m-d', $v->created_at);
                if ($v->active == 0) {
                    $v->new_status = '启用';
                } else {
                    $v->new_status = '禁用';
                }
            }
        }


        if ($data) {
            return $data;
        } else {
            return false;
        }

    }

}