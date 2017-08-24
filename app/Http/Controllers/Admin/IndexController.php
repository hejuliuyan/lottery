<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Login as LoginModel;
use App\Models\Admin\Access as AccessModel;
use Request;
use DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Routing\Redirector;

/**
 * 后台首页
 *
 * @author zhou 2016年7月14号 18:59
 */
class IndexController extends Controller
{
    /**
     * 首页显示
     */
    public function index()
    {
        return view('admin.index.index');
    }

    /**
     * [explain 说明模板编辑]
     * @return [type] [description]
     * author zhou 2016-9-13
     */
    public function explain()
    {
        $data = file_get_contents("../resources/views/admin/help/" . $_GET['type'] . ".tpl");
        return $data;
    }

    /**
     * 说明保存
     * @return mixed
     * author zhou 2016-9-12
     */
    public function explain_edit()
    {
//        return view('admin.index.explain');
        $html = "@extends('admin.public.help_left')
@section('style')
    <style>
        .content {
            /*margin-left: 10%;*/
            margin: 3% 0 0 18%;
            width: 70%;
        }
    </style>
@stop
@section('title1')
@stop
@section('title2')
@stop
@section('content')
    <div class=\"content\">" . $_POST['content'] . "</div>
@stop";
        file_put_contents("../resources/views/admin/help/" . $_POST['type'] . ".tpl", $_POST['content']);
        $state = file_put_contents("../resources/views/admin/help/" . $_POST['type'] . ".blade.php", $html);
        if ($state) {
            $msg['sta'] = '1';
            $msg['msg'] = '操作成功!';
        } else {
            $msg['sta'] = '0';
            $msg['msg'] = '操作失败!';
        }
        return $msg;
    }


}