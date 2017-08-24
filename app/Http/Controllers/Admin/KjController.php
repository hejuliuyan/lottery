<?php


namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreArticleRequest;
use App\Models\Admin\Kjcontent as KjModel;
use App\Models\Admin\Access as AccessModel;
use Request;
use DB;
use Illuminate\Support\Facades\Validator;

/**
 * 工作流
 *
 * @author wang 2016-6-6 9:17
 *
 */
class KjController extends Controller {
    /**
     * @var array
     * 验证规则
     * @author zhou 2016-7-6 15:19
     */
	private $rules = [ 
			'id' => 'required',
			'name' => 'required',
			'num' => 'required',
			'numbers' => 'required',
			'types' => 'required',
			'notice_date' => 'required|date',
			'deadline' => 'required|date' 
	];
	private $messages = [ 
			'required' => '请填写相应数据',
			'email' => '请输入正确邮箱格式',
			'max' => '长度不合适',
			'date' => '时间格式不正确' 
	];
	
	/**
	 * 开奖结果页面
	 */
	public function index() {
		$Model = new KjModel ();
		$lists = $Model->lists ();
		return view ( 'admin.kaijiang.index' )->with ( 'lists', $lists );
		
		// return view('admin.kaijiang.index')->with('lists',$lists);
		// return view('admin.kaijiang.index',compact('$lists'));
		
		// return view('admin.kaijiang.index', $lists);
		// $manger = new Process();
		// $list = $manger->workflowInfos();
		// $page = $list->setPath('')->appends(Request::all())->render();
		// return view('admin.kaijiang.index');
	}
	
	/**
	 * 添加
	 */
	public function add() {
		return view ( 'admin.kaijiang.add' );
	}
	
	/**
	 * 发布开奖结果
	 */
	public function ad_kjnews() {
		$Model = new KjModel ();
		$kjnews = $Model->ad_kjnews ( $_POST );
		echo json_encode ( $kjnews );
		die ();
	}
	
	/**
	 * 修改
	 */
	public function edit() {
		$Model = new KjModel ();
		$data = $Model->edit ( $_GET );
		$data_lists = $Model->mon_lists ( $_GET );
		return view ( 'admin.kaijiang.edit' )->with ( 'data', $data )->with ( 'data_lists', $data_lists );
	}
	
	/**
	 * 保存
	 */
	public function saves() {
		// $input = $_POST;
		$input = Request::all ();
		// error_log(print_r($input,true));
		// $data = $_POST;
		$validator = Validator::make ( $input, $this->rules, $this->messages );
		// error_log(print_r($validator,true));
		if ($validator->fails ()) {
			/*
			 * $messages = $validator->messages();
			 * return $messages;
			 */
			// error_log(print_r($arr,true));
			return $validator->errors ();
		}
		$Model = new KjModel ();
		$save = $Model->saves ( $_POST );
		// if($save==1)
		// $data = array('status'=>1,'msg'=>'成功','data'=>'');
		// if($save==0)
		// $data = array('status'=>0,'msg'=>'未修改','data'=>'');
		// else
		// $data = array('status'=>2,'msg'=>'成功','data'=>'');
		echo json_encode ( $save );
		die ();
		// return view('admin.kaijiang.index')->with('data',$data);
	}
	
	/**
	 * 删除
	 */
	public function del() {
		$Model = new KjModel ();
		$del = $Model->del ( $_GET );
		$data = array (
				'status' => 1,
				'msg' => '成功',
				'data' => $del 
		);
		echo json_encode ( $data );
		die ();
	}
	
	/**
	 * 检索
	 */
	public function search() {
		$Model = new KjModel ();
		$lists = $Model->search ( $_GET );
		return view ( 'admin.kaijiang.index' )->with ( 'lists', $lists );
	}
	
	/**
	 * 金额添加
	 */
	public function mon_saves() {
		$Model = new KjModel ();
		$mon_saves = $Model->mon_saves ( $_POST );
		if ($_POST ['mid'] == 0) {
			$data = array (
					'status' => 1,
					'msg' => '添加成功',
					'data' => $mon_saves 
			);
		} else {
			$data = array (
					'status' => 1,
					'msg' => '修改成功',
					'data' => $mon_saves 
			);
		}
		echo json_encode ( $data );
		die ();
	}
	
	/**
	 * 金额修改
	 */
	public function mon_edit() {
		$Model = new KjModel ();
		$data = $Model->mon_edit ( $_POST );
		$data = array (
				'status' => 1,
				'msg' => '成功',
				'data' => $data 
		);
		echo json_encode ( $data );
		die ();
	}
	
	/**
	 * 金额修改
	 */
	public function mon_lists() {
		$Model = new KjModel ();
		$data = $Model->mon_lists ( $_POST );
		$data = array (
				'status' => 1,
				'msg' => '成功',
				'data' => $data 
		);
		echo json_encode ( $data );
		die ();
	}
	
	/**
	 * 删除
	 */
	public function mon_del() {
		$Model = new KjModel ();
		$data = $Model->mon_del ( $_GET );
		$data = array (
				'status' => 1,
				'msg' => '成功',
				'data' => $data 
		);
		echo json_encode ( $data );
		die ();
	}
	//
	// /**
	// * 增加工作流入库处理
	// *
	// * @access private
	// */
	// private function saveDatasToDatabase()
	// {
	// $data = (array) Request::input('data');
	// $params = new \App\Services\Admin\Workflow\Param\WorkflowSave();
	// $data['addtime'] = time();
	// $params->setAttributes($data);
	// $manager = new Process();
	// if($manager->addWorkflow($params) !== false)
	// {
	// $this->setActionLog();
	// return Js::locate(R('common', 'workflow.index.index'), 'parent');
	// }
	// return Js::error($manager->getErrorMessage());
	// }
	//
	// /**
	// * 编辑工作流
	// *
	// * @access public
	// */
	// public function edit()
	// {
	// if(Request::method() == 'POST') return $this->updateDatasToDatabase();
	// $id = Request::input('id');
	// if( ! $id or ! is_numeric($id)) return Js::error(Lang::get('common.illegal_operation'), true);
	// $manger = new Process();
	// $info = $manger->workflowInfo(['id' => $id]);
	// if(empty($info)) return Js::error(Lang::get('workflow.workflow_not_found'));
	// $formUrl = R('common', 'workflow.index.edit');
	// return view('admin.workflow.add', compact('info', 'formUrl', 'id'));
	// }
	//
	// /**
	// * 编辑工作流入库处理
	// *
	// * @access private
	// */
	// private function updateDatasToDatabase()
	// {
	// $data = Request::input('data');
	// if( ! $data or ! is_array($data)) return Js::error(Lang::get('common.illegal_operation'));
	// $params = new \App\Services\Admin\Workflow\Param\WorkflowSave();
	// $params->setAttributes($data);
	// $manager = new Process();
	// if($manager->editWorkflow($params))
	// {
	// $this->setActionLog();
	// return Js::locate(R('common', 'workflow.index.index'), 'parent');
	// }
	// return Js::error($manager->getErrorMessage());
	// }
	//
	// /**
	// * 删除工作流
	// *
	// * @access public
	// */
	// public function delete()
	// {
	// $id = Request::input('id');
	// if( ! is_array($id))
	// {
	// if( ! $id ) return responseJson(Lang::get('common.action_error'));
	// $id = array($id);
	// }
	// $id = array_map('intval', $id);
	// $manager = new Process();
	// $info = $manager->workflowInfos(['ids' => $id]);
	// if($manager->deleteWorkflow(['ids' => $id]))
	// {
	// $this->setActionLog(['workflowInfo' => $info]);
	// return responseJson(Lang::get('common.action_success'), true);
	// }
	// return responseJson($manager->getErrorMessage());
	// }
}