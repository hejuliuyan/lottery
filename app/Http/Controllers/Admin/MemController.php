<?php namespace App\Http\Controllers\Admin;
use App\Models\Admin\Memcontent as MemModel;
use App\Models\Admin\Access as AccessModel;
use Request;
use DB;



/**
 * 会员管理
 * @task 37
 * @author deng 2016-6-30 19：47
 */
class MemController extends Controller
{
	/**
     * 会员管理页面
     */
	public function ad_members(){
		$model = new Memmodel();
		if(isset($_GET['search_phone'])){
			$data=$_GET['search_phone'];
		}else{
			$data='';
		}
		$list = $model->members($data);
        return view('admin.members.index')->with('list',$list);
	}


	/**
     * 会员编辑页面
     */
	public function mem_edit_view(){
		$data['id']=$_GET['id'];
		$model = new Memmodel();
		$res = $model->mem_edit_view($data);
        //error_log(print_r($res,true));
        return view('admin.members.edit')->with('data',$res);
	}

	/**
     * 会员修改
     */
	public function mem_update(){
		$model = new Memmodel();
		$res = $model->mem_update($_POST);
        echo json_encode($res);
	}

	/**
     * 会员检索
     */
	public function mem_search(){
		$model = new Memmodel();
		$res = $model->mem_search($_GET);
        echo json_encode($res);
	}


}