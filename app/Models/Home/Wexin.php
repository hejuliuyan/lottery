<?php namespace App\Models\Home;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use DB;
use Config;
use Log;
/**
 * 微信授权
 *
 * @author deng  2016‎年‎8‎月‎16‎日，‏‎11:55:38
 */

class Wexin extends Model{

	//微信证书签名
	public function index($url = '', $post_data = array()){
       	$ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); // 从证书中检查SSL加密算法是否存在
	    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
	    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
	    curl_setopt($ch, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
	    curl_setopt($ch, CURLOPT_TIMEOUT, 10); // 设置超时限制防止死循环
	    curl_setopt($ch, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
	    if(!empty($post_data)){
	        curl_setopt($ch, CURLOPT_POST, 1);
	        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	    }
	    $output = curl_exec($ch);
	    curl_close($ch);
	    return $output;
    }
	
	//access_token获取
	public function access_token(){
		$appid= Config::get('app.wechat_appid');
	 	$secret= Config::get('app.wechat_secret');
	 	$domain= Config::get('app.domain');
		//$appid = "wxe71525fd5bf234b2";
		//$select = "f5181264de5a62e4e627e3d6175dbeba";
		//读取本地token
	 	
	 	$file = 'temp/access_token.txt';
	 	if(!file_exists($file)){
	 		$myfile = fopen($file, "wb") or die("Unable to open file!");
	 		fclose($myfile);
	 		Log::debug('[access_token]create file');
	 	}

		$myfile = fopen($file, "r+") or die("Unable to open file!");
		$con = fgets($myfile);
		//fclose($myfile);\
		$isGetFromWX =0;
		if(empty($con)){
			$isGetFromWX = 1;
			Log::debug('[access_token]empty file,isGetFromWX='.$isGetFromWX.'con='.$con);
		}else{
			$arr = explode("\"",$con);
			$token = $arr[3];
			$arr_time = explode("}",$arr[6]);//his_time
			$his_time = $arr_time[1]+7200;
			$time=time();
			if($his_time<time()){
				$isGetFromWX = 2;
				Log::debug('[access_token]empty file,isGetFromWX_time='.$isGetFromWX.'file_time='.$his_time.'now_time='.$time);
			}
		}
		if ($isGetFromWX==2 || $isGetFromWX==1 ) {
			//获取token
			$token = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$secret."";
			$url = file_get_contents($token);
			$url = $url.time();
			fseek($myfile,0);
			fwrite($myfile, $url);
			$con=$url;
			Log::debug('[access_token]get file,con='.$con);
		}
		fclose($myfile);

		$arr = explode("\"",$con);
		$token = $arr[3];
		Log::debug('[access_token]get token,token='.$token);
		return $token;
    }
	
	//微信登录
	public function wxlogin(){
		$sql = DB::table('cp_member')->where('tokenid','=',$_POST['userid'])->get();
		return $sql;
	}

	//增加照片
    public function insert_pic($pname){
        $res = DB::table('cp_order_pic')->insert( ['p_name' => $pname, 'o_id' => $_POST['oid']]);
        return $res;
    }

    //显示照片
    public function show_pic($o_id){
        $arr = DB::table('cp_order_pic')->select('p_name')->where('o_id',$o_id)->get();
        return $arr;
    }

    //代销证照片
     public function lin_pic($pname,$sid){
        $arr = DB::table('cp_shop')->where('shop_token','=',$sid)->update(array('licence_pic'=>$pname));
        return $arr;
    }
}
