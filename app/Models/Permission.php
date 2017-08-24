<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\EntrustPermission;
use DB;

/**
 * Class Permission
 * @package App\Models
 * @task 91
 * @author zhou 2016-7-5 20:45
 */
class Permission extends EntrustPermission
{
    protected $guarded = [];

    /**
     * 权限列表显示
     */
    public function lists()
    {
        $data = DB::table('permissions')->where('pid', '=', '0')->get();
        $arr = DB::table('permissions')->get();
        foreach ($data as $v) {
            foreach ($arr as $val) {
                if ($val->pid == $v->id) {
                    $v->lists[] = $val;
                }
            }
        }
        //error_log(print_r($data,true));
        return $data;
    }

    /**
     * @param $id
     * @return mixed
     * 权限修改
     */
    public function edit($id)
    {
        $data = DB::table('permissions')->where('id', $id)->get();
        return $data;
    }

    /**
     * @param $id
     * @return string
     * 权限删除
     */
    public function del($id)
    {
        $data = DB::table('permissions')->where('pid', $id)->get();
        return empty($data) ? '0' : '1';
    }
}
