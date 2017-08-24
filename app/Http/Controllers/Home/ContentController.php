<?php namespace App\Http\Controllers\Home;
use App\Models\Home\Content as ContentModel;
use Request;
use Illuminate\Support\Facades\Validator;

/**
 * 
 *
 * @author deng 2016‎年‎8‎月‎16‎日，‏‎11:55:37
 */
class ContentController extends Controller
{
	//店铺验证规则
	private $shop_rules = [
		'shop_name' => 'required',
		'idcard_num' => ['regex:/^[1-9]\d{7}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}$|^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([0-9]|X)$/'],
		'keeper_name' => 'required',
		'keeper_mobile' => ['regex:/^(13[0-9]|14[5|7]|15[0|1|2|3|5|6|7|8|9]|18[0|1|2|3|5|6|7|8|9])\d{8}$/'],
		'address'=>['regex:/^[\w\u4E00-\u9FA5\uF900-\uFA2D]{1,10}$/'],
		'licence_num'=>['regex:/^[0-9]+$/'],
	];
	private $shop_messages = [
		'required' => '请填写相应数据',
		'regex'=> '格式不正确',

	];
	//个人信息验证规则
	private $personal_rules = [
		'account' => ['regex:/^[\w\u4E00-\u9FA5\uF900-\uFA2D]{1,10}$/'],
		'idcard_numer' => ['regex:/^[1-9]\d{7}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}$|^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([0-9]|X)$/'],
		'real_name' => ['regex:/^[\u4e00-\u9fa5]{0,4}$/'],
		'mobile' => 'required',
	];
	private $personal_messages = [
		'regex'=> '格式不正确',

	];
    /**
     * 完善个人信息的用户名检查
     */
    public function user(){
    	$ContentModel = new ContentModel();
		$res= $ContentModel->user_check($_POST);
		echo json_encode($res);
	}

    /**
     * 完善店铺信息的用户名检查
     */
    public function shop_per(){
        $ContentModel = new ContentModel();
        $res= $ContentModel->shop_per($_POST);
        echo json_encode($res);
    }

	/**
     * 完善个人信息
     */
    public function personal(){
		/*$input = Request::all ();
        $validator = Validator::make ( $input, $this->personal_rules, $this->personal_messages );
        if ($validator->fails ()) {
            
            return false;
        }*/
    	$ContentModel = new ContentModel();
		$res= $ContentModel->personal($_POST);	
		echo json_encode($res);
	}

    /**
     * 完善店铺信息
     */
    public function update_shop_info(){
		/*$input = Request::all ();
        $validator = Validator::make ( $input, $this->shop_rules, $this->shop_messages );
        if ($validator->fails ()) {
           
            return false;
        }*/
        $ContentModel = new ContentModel();
        $res= $ContentModel->update_shop_info($_POST);  
        echo json_encode($res);
    }
	
	/**
     * 完善个人信息
     */
    public function info_d(){
    	$ContentModel = new ContentModel();
		$res= $ContentModel->info_d($_POST);	
		$data = array('status'=>1,'msg'=>'成功','data'=>$res);
    	echo json_encode($data);
		die();
	}



    

}
