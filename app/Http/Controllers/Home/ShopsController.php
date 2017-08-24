<?php namespace App\Http\Controllers\Home;
use App\Models\Home\Shops as ShopsModel;
use Request;

/**
 * 首页
 *
 * @author wang <775720867@qq.com>
 */
class ShopsController extends Controller
{
    /**
     * 读取彩店列表
     */
    public function lists(){
    	$ShopsModel = new ShopsModel();
		$shoplist['lists'] = $ShopsModel->lists($_POST);
		$data = array('status'=>1,'msg'=>'成功','data'=>$shoplist);
    	echo json_encode($data);
		die();
    }

    

}