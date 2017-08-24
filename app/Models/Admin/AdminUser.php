<?php

namespace App\Models\Admin;

use App\Models\Admin\Base;
use DB;

/**
 * 用户相关联
 *
 * @author zhou 2016-7-8 11:16
 */
class AdminUser extends Base
{

    /**
     * user list show
     *
     * @param array $data
     *            所需要插入的信息
     */
    public function lists()
    {
        $data = DB::table('users')->get();
        return $data;
    }

    /**
     * @param $id
     * @return mixed
     * 用户修改
     */
    public function edit($id)
    {
        $data = DB::table('users')->where('id', $id)->get();
        return $data;
    }

    /**
     * @param $data
     * @return mixed
     * 用户修改
     */
    public function saves($data)
    {
        $res = DB::table('users')->where('id', $data['id'])->pluck('password');
        if ($data ['password'] == $res) {
            $pwd = $data['password'];
        } else {
            $pwd = md5($data ['password']);
        }
        $time = date('Y-m-d H:i:s', time()+28800);
        $data = DB::table('users')->where('id', $data ['id'])->update([
            'name' => $data ['name'],
            'email' => $data ['email'],
            'password' => $pwd,
            'updated_at' => $time,
            'state' => $data ['state']
        ]);
        return $data;
    }

    /**
     * @param $id
     * @return mixed
     * 用户删除
     */
    public function del($id)
    {
        $res = DB::table('users')->where('id', $id)->delete();
        DB::table('role_user')->where('user_id', $id)->delete();
        return $res;
    }

    /**
     * @param $data
     * @return mixed
     * 用户添加
     */
    public function add($data)
    {
        $pwd = md5($data ['password']);
        $time = date('Y-m-d H:i:s', time()+28800);
        $data = DB::table('users')->insert([
            'name' => $data ['name'],
            'email' => $data ['email'],
            'password' => $pwd,
            'updated_at' => $time,
            'created_at' => $time,
            'updated_at' => $time,
            'state' => $data ['state']
        ]);
        return $data;
    }
}
