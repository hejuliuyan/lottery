<?php


namespace App\Models\Home;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use DB;
use Log;

/**
 * 信息相关
 *
 * @author deng 2016‎年‎8‎月‎16‎日，‏‎11:55:38
 */
class Content extends Model {
	
	/**
	 * 读取彩票信息
	 */
	public function cphis() {
		$data = DB::select ( 'select * from cp_hisnum order by date asc' );
		return $data;
	}
	/**
	 * 读取大乐透信息
	 */
	public function cpdlt($data) {

		$num_qi = DB::table('cp_types')->where('types','=',$data['type'])->pluck('num_qi');
		$data = DB::table('cp_draw_result')->where('num','<',$num_qi)->where('types','=',$data['type'])->get();

		if($data){
			return $data;
		}else{
			return false;
		}
		
	}
	public function login($data) {
		return $data;
	}
	
	/**
	 * 大乐透开奖时间
	 */
	public function cpdlt_time() {
		$date = date ( 'w' );
		return $date;
	}
	
	/**
	 * 大乐透停售时间
	 */
	public function cpdlt_endtime($da) {
		$data = date ( 'w' );
		$time = time () * 1000;
		$type = $da['type'];

		if($type=='01'){
			if ($data == 0 || $data == 2 || $data == 5) {
				$time = $time + 24 * 3600 * 1000;
				return $time;
			} else if ($data == 4) {
				$time = $time + 24 * 2 * 3600 * 1000;
				return $time;
			} else {
				return $time;
			}

		}elseif($type=='02'){
			if ($data == 1 || $data == 4 || $data == 6) {
				$time = $time + 24 * 3600 * 1000;
				return $time;
			} else if ($data == 3) {
				$time = $time + 24 * 2 * 3600 * 1000;
				return $time;
			} else {
				return $time;
			}
			
		}elseif($type=='03'){
			return $time;
		}elseif($type=='04'){
			return $time;
		}
		
		
	}
	
	/**
	 * 读取用户默认彩店
	 */
	public function info_d($data) {
		$uid = DB::select ( 'select id from cp_member where tokenid =' . "'" . $data ['userid'] . "'" );
		foreach ( $uid as $key => $value ) {
			$uid = $value->id;
		}
		$res = DB::select ( 'select b.* from cp_member a left join cp_shop b on a.shop_id = b.id where a.id = ' . $uid );
		// $sql = DB::select('select shop_id from cp_member where id = '.$_POST['userid']);
		// //var_dump($sql); die();
		// $data = DB::select('select * from `cp_shop` where id = '.$sql['shop_id']);
		return $res;
	}
	
	/**
	 * 用户资料查询
	 */
	public function user_check($data) {
		$tokenid = $data ['tokenid'];
		$da = DB::table ( 'cp_member' )->where ( 'tokenid', '=', $tokenid )->get ();
		return $da;
	}

	/**
	 * 店铺资料查询
	 */
	public function shop_per($data) {
		$tokenid = $data ['tokenid'];
		$da = DB::table ( 'cp_shop' )->where ( 'shop_token', '=', $tokenid )->get ();
		return $da;
	}
	
	/**
	 * 用户openid
	 */
	public function user_openid($data) {
		$da = DB::table ( 'cp_member' )->where ( 'id', '=', $data ['id'] )->get ();
		return $da;
	}
	
	/**
	 * 个人信息插入
	 */
	public function personal($data) {
		$phone = $data ['mobile'];
		$account = $data ['account'];
		$idcard = $data ['idcard_numer'];
		$rname = $data ['real_name'];
		$sql = DB::table ( 'cp_member' )->where ( 'mobile', '=', $phone )->update(array(
				'account' => $account,
				'idcard_numer' => $idcard,
				'real_name' => $rname 
		) );
		if ($sql) {
			return true;
		} else {
            Log::info('个人信息插入异常，请检查');
			return false;
		}
	}

	/**
	 * 店铺信息完善插入
	 */
	public function update_shop_info($data) {
		$phone = DB::table('cp_shop')->where('keeper_mobile','=',$data['mobile'])->whereNotIn('shop_token', array($data['shopid']))->get();
		if($phone){
			return '333';
		}else{
			$sql = DB::table ( 'cp_shop' )->where ( 'shop_token', '=', $data ['shopid'] )->update ( array(
				'shop_name' => $data ['shop_name'],
				'idcard_num' => $data ['idcard_num'],
				'keeper_mobile'=> $data ['mobile'],
				'keeper_name'=>$data ['real_name'],
				'address'=>$data ['address'],
				'licence_num'=>$data ['licence_num']

			));
			if ($sql) {
				return true;
			} else {
				return false; 
			}
		}
		
	}

	//轮播图
	public function pic_lun() {
		$arr = DB::table('cp_shuffling_pic')->where('state', '1')->orderBy('id','desc')->take ( 4 )->get();
		return $arr;
	}
}
