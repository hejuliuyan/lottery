<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Shopcontent as ShopModel;
use App\Models\Admin\Access as AccessModel;
use Request;
use DB;
use Illuminate\Support\Facades\Validator;
use Route;
use Log;

/**
 * 店铺管理
 * @task 77
 * @author zhou 2016-6-21 15:14
 */
class ShopController extends Controller
{
    /**
     * @var array
     * 验证规则
     */
    private $rules = [
        'shop_name' => 'required',
        'idcard_num' => ['regex:/^[1-9]\d{7}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}$|^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([0-9]|X)$/'],
        'keeper_name' => 'required',
        'keeper_mobile' => ['regex:/^(13[0-9]|14[5|7]|15[0|1|2|3|5|6|7|8|9]|18[0|1|2|3|5|6|7|8|9])\d{8}$/'],
        'shop_account' => 'required',
    ];
    private $messages = [
        'required' => '请填写相应数据',
        'email' => '请输入正确邮箱格式',
        'max' => '长度不合适',
        'regex' => '格式不正确',

    ];

    /**
     * 店铺管理首页
     */
    public function index()
    {
        $res = Route::currentRouteName();
        $Model = new ShopModel ();
        $lists = $Model->lists();
        return view('admin.shop.index')->with('lists', $lists);
    }

    /**
     * 添加店铺
     */
    public function add()
    {
        //输入数据验证
        if (empty ($_GET ['num'])) {
            return 2;
        } else if ($_GET ['num'] > '50') {
            return 3;
        } else {
            $Model = new ShopModel ();
            $num = $_GET ['num'];//生成店铺
            for ($i = 0; $i < $num; $i++) {
                $data = $Model->add();
            }
            return '1';
        }

    }


    /**
     * 修改店铺
     */
    public function edit()
    {
        $Model = new ShopModel ();
        $data = $Model->edit($_GET);
        return view('admin.shop.edit')->with('data', $data);
    }

    /**
     * 保存店铺
     */
    public function saves()
    {
        $data = Request::all();
        $res = DB::table('cp_shop')->where('keeper_mobile', '=', $data['keeper_mobile'])->where('id','<>',$data['id'])->get();//获取店铺信息
        if ($res) {
            return '3';
            exit();
        }
        //验证输入数据
        $validator = Validator::make(
            $data,
            $this->rules,
            $this->messages
        );
        if ($validator->fails()) {
            return $validator->errors();
        }
        $Model = new ShopModel ();
        $url = 'http://api.map.baidu.com/geocoder/v2/?address=' . $_POST['address'] . '&output=json&ak=MLzwcfY4o5ZwkonAFbb5TKQHhteodOVn';
        //修改时间
        $data['updated_at'] = time() + 28800;
        $loca = file_get_contents($url);
        $arr = json_decode($loca, true);
        //修改店铺
        if (isset($arr['result'])) {
            $data['longitude'] = $arr['result']['location']['lng'];
            $data['latitude'] = $arr['result']['location']['lat'];

            $save = $Model->saves($data);
            if ($save) {
                return '1';
            } else {
                return '0';
            }
        } else {
            return '-1';
        }

        die ();

    }

    /**
     * 删除店铺
     */
    public function del()
    {
        $Model = new ShopModel ();

        $del = $Model->del($_GET);
        $data = array(
            'status' => 1,
            'msg' => '成功',
            'data' => $del,
            'id' => $_GET ['id']
        );
        echo json_encode($data);
        die ();
    }

    /**
     * 检索店铺
     */
    public function search()
    {
        $Model = new ShopModel ();
        // 'id',$data[where]
        /*
         * $_POST['where']=$_POST['where']!=''?('id'.','.$_POST['where']):'1=1';
         * $_POST['phone']=$_POST['phone']!=''?('phone'.','.$_POST['phone']):'1=1';
         */
        $lists = $Model->search();
        return view('admin.shop.index')->with('lists', $lists);
    }

    /**
     * @return string
     * 删除代销证
     */
    public function pic_del()
    {
        $Model = new ShopModel ();
        $filePath = 'Uploads/photo/' . $_POST['pic'];//获取图片路径
        //删除图片
        if (file_exists($filePath)) {
            @unlink($filePath);
        }
        $lists = $Model->del_pic($_POST['id']);
        if ($lists) {
            return '1';
        } else {
            return '0';
        }

    }

}