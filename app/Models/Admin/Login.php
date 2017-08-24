<?php namespace App\Models\Admin;

use App\Models\Admin\Base;
use DB;
/**
 * 用户登录管理
 */
class Login extends Base
{

    public function login($data){
        $pwd = md5($data['password']);
        $data = DB::table ( 'users' )->where('name',$data['username'])->where('password',$pwd)->get();
        return $data;
    }

}
