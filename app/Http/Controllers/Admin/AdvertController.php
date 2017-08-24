<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Advertcontent as AdvertModel;
use App\Models\Admin\Access as AccessModel;
use DB;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Redirect, Input, Response;

/**
 * 首页banner图相关
 *
 * @author zhou 2016-6-23 10:17
 */
class AdvertController extends Controller {
	/**
	 * 预览图片信息
	 */
	public function index() {
		$Model = new AdvertModel ();//实例化model类
		$lists = $Model->lists ();//调用model里面方法
		return view ( 'admin.Advert.index' )->with ( 'lists', $lists );
	}
	
	/**
	 * 添加新图片
	 */
	public function add() {
		$file = Input::file ( 'photo' );//接收文件
		$allowed_extensions = [ //文件类型
				"png",
				"jpg",
				"gif" 
		];
        //判断文件类型
		if ($file->getClientOriginalExtension () && ! in_array ( $file->getClientOriginalExtension (), $allowed_extensions )) {
			return [ 
					'error' => 'You may only upload png, jpg or gif.' 
			];
		}
		//文件路径
		$destinationPath = 'admin/uploads/images/';
		$extension = $file->getClientOriginalExtension ();
		$fileName = time () . '.' . $extension;//设置文件名称
		$file->move ( $destinationPath, $fileName );//移动文件
		$Model = new AdvertModel ();
		$res = $Model->add ($fileName);//将文件信息添加进数据库
        echo "<script>location.href='/index.php/advert_pic';</script>";//刷新页面
        /*if ($res) {
            echo "<script>location.href='/index.php/advert_pic';</script>";
        } else {
            echo "<script>location.href='/index.php/advert_pic';</script>";
        }*/
	}

    /**
     * 修改图片信息
     */
    public function save() {
        $Model = new AdvertModel ();
        $data=$_GET;//获取文件信息
//        error_log(print_r($_GET['state'],true));
        //判断文件状态
        if($_GET['state']=='1'){
            $data['state']='0';
        }else{
            $data['state']='1';
        }
        $res = $Model->saves ( $data );//修改文件信息
        if(isset($res)){
            echo  '1';
        }else{
            echo  '0';
        }

    }
	/**
	 * 删除图片
	 */
	public function del() {
		$Model = new AdvertModel ();
		
		$del = $Model->del ( $_GET );//删除图片
		$data = array (
				'status' => 1
				/* 'msg' => '成功',
				'data' => $del,
				'id' => $_GET ['id']  */
		);
		// error_log ( print_r ( $data, true ) );
		echo json_encode ( $data );
		die ();
	}
}