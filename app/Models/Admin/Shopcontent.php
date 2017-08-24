<?php


namespace App\Models\Admin;

use App\Models\Admin\Base;
use DB;
use Log;

/**
 * 开奖结果相关联
 *
 * @author wang
 */
class Shopcontent extends Base
{

    /**
     * 获取开奖结果列表
     *
     * @param array $data
     *            所需要插入的信息
     */
    public function lists()
    {
        $data = DB::table('cp_shop')->get();
        return $data;

    }

    /*
     *
     * 添加
     *
     */
    public function add()
    {
        $str = null;
        $strPol = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen($strPol) - 1;
        for ($i = 0; $i < 7; $i++) {
            $str .= $strPol [rand(0, $max)]; // rand($min,$max)生成介于min和max两个数之间的一个随机整数
        }
        $c_time = time() + 28800;
        $pwd = md5(md5($str));
        $tok = $str . time();
        $data = DB::table('cp_shop')->insert([
            'shop_account' => $str,
            'shop_pwd' => $pwd,
            'created_at' => $c_time,
            'shop_openid' => $tok,
            'shop_token' => $tok,
            'verified' => 'N',
            'margin_paid' => 'N'
        ]);
        if (!$data) {
            Log::info('后台店铺添加部分出现异常');
        }
        // return $data;
        // return $this->create($data);
    }

    /**
     * 读取信息
     *
     * @param array $data
     *            所需要插入的信息
     */
    public function edit($data)
    {
        $users = DB::table('cp_shop')->where('id', $data ['id'])->get();
        // $users = DB::select('select id, name, num, numbers, types, from_unixtime(notice_date) as notice_date, from_unixtime(deadline) as deadline from cp_draw_result where id ='.$data['id'].'' );
        return $users;

    }

    /**
     * 修改信息
     */
    public function saves($data)
    {
        $res = DB::table('cp_shop')->where('id', $data['id'])->update([
            'shop_name' => $data['shop_name'],
            'idcard_num' => $data['idcard_num'],
            'keeper_name' => $data['keeper_name'],
            'keeper_mobile' => $data['keeper_mobile'],
            'shop_account' => $data['shop_account'],
            'updated_at' => $data['updated_at'],
            'shop_cpnum' => $data['shop_cpnum'],
            'address' => $data['address'],
            'active' => $data['active'],
            'longitude' => $data['longitude'],
            'latitude' => $data['latitude'],
            'verified' => $data['verified'],
            'margin_paid' => $data['margin_paid'],
            'shop_level' => $data['shop_level']
        ]);
        return $res;
    }

    /**
     * 删除信息
     */
    public function del($data)
    {
        $users = DB::table('cp_shop')->where('id', $data ['id'])->delete();
        if (!$users) {
            Log::info('后台店铺删除出现异常，sql执行错误，查看cp_shop表数据是否异常');
        }
        return $users;
    }
    /**
     * 检索信息
     */
    public function search()
    {
        $data = DB::table('cp_shop')->where('id', $_POST['where'])->orWhere('keeper_mobile', $_POST['phone'])->get();
        // $data = DB::select('select * from cp_shop where id = '.$data['where'].' order by id desc');
        return $data;
    }

    /**
     * @param $id
     * @return mixed
     * 删除文件
     */
    public function del_pic($id)
    {
        $data = DB::table('cp_shop')->where('id', $id)->update([
            'licence_pic' => ''
        ]);
        return $data;
    }


}
