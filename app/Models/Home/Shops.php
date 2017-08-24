<?php namespace App\Models\Home;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use DB;
/**
 * 文章表模型
 *
 * @author wang
 */
class Shops extends Model
{
 
	/**
     * 读取门店列表
     */
    public function lists($data){
    	$uid = DB::select('select id from cp_member where tokenid ='."'".$data['userid']."'");
		foreach($uid as $key => $value){
			$uid = $value->id;
		}
		$sql = DB::select('select shop_id from cp_member where id = '.$uid);
		foreach($sql as $key => $value){
				$shop_id = $value->shop_id;
		}
    	$data = DB::select('select * from cp_shop where shop_status = 1 and id!='.$shop_id.' order by location asc ');
		
		
        return $data;
    }
    


}
