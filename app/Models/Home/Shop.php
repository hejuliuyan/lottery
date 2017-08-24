<?php namespace App\Models\Home;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use DB;
use Log;
/**
 * 店铺相关
 *
 * @author deng 2016‎年‎8‎月‎16‎日，‏‎11:55:38
 */
class Shop extends Model
{
 
	/**
     * 读取门店列表
     */
    public function cphis(){
    	$data = DB::select('select * from cp_hisnum order by date asc');
        return $data;
    }
    
    /**
     * 店铺读取订单信息
     */
    public function shop_order($data){
        $id=$data['shopid'];
        $da = DB::table('cp_shop')->join('cp_order', 'cp_shop.id', '=', 'cp_order.order_shop')->where('cp_shop.shop_token','=',$id)->select('cp_order.id','cp_order.uid','cp_shop.shop_status','cp_order.order_qi','cp_order.order_z','cp_order.order_b','cp_order.order_money','cp_order.user_mobile','cp_order.read_status','cp_order.status','cp_order.order_type','cp_order.type')->orderBy('update_date', 'desc')->get();

        foreach ($da as $key => $value) {
                if($value->type=='01'){
                    $value->new_type='大乐透';
                }elseif($value->type=='02'){
                    $value->new_type='七星彩';
                }elseif($value->type=='03'){
                    $value->new_type='排三';
                }elseif($value->type=='04'){
                    $value->new_type='排五';
                }
            }

        return $da;
    }

    /**
     * 店铺读取待接订单
     */
    public function order_wait($data){
        $id=$data['shopid'];
        $da = DB::table('cp_shop')->join('cp_order', 'cp_shop.id', '=', 'cp_order.order_shop')->where('cp_shop.shop_token','=',$id)->where('status','=','1')->select('cp_order.id','cp_order.uid','cp_shop.shop_status','cp_order.order_qi','cp_order.order_z','cp_order.order_b','cp_order.order_money','cp_order.user_mobile','cp_order.read_status','cp_order.status','cp_order.order_type','cp_order.type')->orderBy('order_date', 'desc')->get();
            foreach ($da as $key => $value) {
                if($value->type=='01'){
                    $value->new_type='大乐透';
                }elseif($value->type=='02'){
                    $value->new_type='七星彩';
                }elseif($value->type=='03'){
                    $value->new_type='排三';
                }elseif($value->type=='04'){
                    $value->new_type='排五';
                }
            }
            if($da){
                return $da;  
           }else{
                return false;
           }
       
    }

    /**
     * 店铺读取派奖订单
     */
    public function pj_wait($data){
        $id=$data['shopid'];
        $da = DB::table('cp_shop')->join('cp_order', 'cp_shop.id', '=', 'cp_order.order_shop')->where('cp_shop.shop_token','=',$id)->where('status','=','6')->where('order_type','=','2')->select('cp_order.id','cp_order.uid','cp_shop.shop_status','cp_order.order_qi','cp_order.order_z','cp_order.order_b','cp_order.order_money','cp_order.user_mobile','cp_order.read_status','cp_order.status','cp_order.order_type','cp_order.type')->orderBy('update_date', 'desc')->get();

            foreach ($da as $key => $value) {
                if($value->type=='01'){
                    $value->new_type='大乐透';
                }elseif($value->type=='02'){
                    $value->new_type='七星彩';
                }elseif($value->type=='03'){
                    $value->new_type='排三';
                }elseif($value->type=='04'){
                    $value->new_type='排五';
                }
            }

            if($da){
                return $da;  
           }else{
                return false;
           }
       
    }




     /**
     * 接单处理
     */
    public function jd_order($data){
        $id=$data['order_id'];
        $da =DB::table('cp_order')->where('id','=',$id)->update(array('read_status'=>0,'update_date'=>time()));
        if($da){
            $d = DB::table('cp_shop')->join('cp_order', 'cp_shop.id', '=', 'cp_order.order_shop')->where('cp_order.id','=',$id)->select('cp_order.id','cp_shop.shop_status','cp_order.order_qi','cp_order.order_z','cp_order.order_b','cp_order.order_money','cp_order.user_mobile','cp_order.read_status','cp_order.type')->get();

               foreach ($d as $key => $value) {
                if($value->type=='01'){
                    $value->new_type='大乐透';
                }elseif($value->type=='02'){
                    $value->new_type='七星彩';
                }elseif($value->type=='03'){
                    $value->new_type='排三';
                }elseif($value->type=='04'){
                    $value->new_type='排五';
                }
            }  

            return $d;
        }
    }

    /**
     * 店铺状态改变
     */
    public function shop_status($data){
        $shop_status=$data['shop_status'];
        $shop_id=$data['shopid'];
        $da =DB::table('cp_shop')->where('shop_token','=',$shop_id)->update(array('shop_status'=>$shop_status));
        if($da){
            return true;
        }else{
            return false;
        }
    }

     /**
     * 出票信息查询
     */
    public function cp_detail($data){
        $id=$data['order_id'];
		
		$da = DB::select('SELECT a.*, FROM_UNIXTIME(a.order_date, "%Y-%m-%d %H:%i:%S")  as times, b.shop_name,b.id as shop_id from cp_order a left join cp_shop b on a.order_shop = b.id where a.id = '.$id);
        //$da =DB::table('cp_order')->where('id','=',$id)->get();
        if($da){
            return $da;
        }else{
            return false;
        }
    }

     /**
     * 出票信息查询号码查询
     */
    public function cp_detail_num($data){
        $id=$data['order_id'];
        $da =DB::table('cp_order_detail')->where('order_id','=',$id)->select('numbers')->get();
        $type = DB::table('cp_order')->where('id','=',$id)->pluck('type');
        $tz_type = DB::table('cp_order')->where('id','=',$id)->pluck('tz_type');

        foreach ($da as $key => $value) {
            $value->type = $type;
            if($tz_type || $tz_type==0){
                $value->tz_type = $tz_type;
            }
            
        }
        if($da){
            return $da;
        }else{
            return false;
        }
    }


    /**
     * 订单状态改变
     */
    public function cp_status($data){
        $id=$data['order_id'];
        $status=$data['status'];
        if(isset($data['read_status'])){
             $d =DB::table('cp_order')->where('id','=',$id)->update(array('read_status'=>$data['read_status']));
        }
        $da =DB::table('cp_order')->where('id','=',$id)->update(array('status'=>$status,'update_date'=>time()));
		//DB::table('cp_transaction_book')->where('order_id','=',$id)->update(array('trans_title'=>2));
		if($data['biaoshi']==1){
			
		}else{
			$data = DB::table('cp_transaction_book')->insert(array('order_id' => $data['order_id'], 'trans_date' => time(), 'trans_title' =>2, 'trans_price' => $data['d_money']));
		}
		
		
        if($da){
            return true;
        }else{
            Log::info('订单状态修改出现异常');
            return false;
        }
    }


       /**
     * 判断店铺上下线状态
     */
    public function pd_shop_status($data){
        $id=$data['shopid'];      
        $da =DB::table('cp_shop')->where('shop_token','=',$id)->select('shop_status','verified')->get();
        if($da){
            return $da;        
        }else{
            return false;
        }
    }



    /**
     * 查找最新订单
     */
    public function new_order($data){
        $id=$data['shopid'];
      /*  $time=time()-10;
        $da=DB::table('cp_shop')->join('cp_order','cp_shop.id','=','cp_order.order_shop')->where('cp_shop.token','=',$id)->where('cp_order.status','=','1')->whereBetween('cp_order.order_date', array(time(), $time))->select('cp_order.id','cp_shop.shop_status','cp_order.order_qi','cp_order.order_z','cp_order.order_b','cp_order.order_money','cp_order.user_mobile','cp_order.read_status','cp_order.type')->get();*/
            
        $da = DB::select('select b.id,a.shop_status,b.order_qi, b.order_z,b.order_b,b.order_money,b.user_mobile, b.read_status,b.type from cp_shop as a left join cp_order as b on a.id = b.order_shop where a.shop_token = "'.$id.'" and b.status=1 and order_date>'.time().'-10');

        // $now_time=time();
        // $old_time=$now_time-10;      
        // $da =DB::table('cp_shop')->join('cp_order', 'cp_shop.id', '=', 'cp_order.order_shop')->where('cp_shop.shop_token','=',$id)->where('cp_order.status','=',1)->whereBetween('order_date', array($old_time, $now_time))->select('cp_order.id','cp_shop.shop_status','cp_order.order_qi','cp_order.order_z','cp_order.order_b','cp_order.order_money','cp_order.user_mobile','cp_order.read_status')->get();
        if($da){
            return $da;
        }else{
            return false;
        }
    }

     /**
     * 查找店铺openid
     */
    public function shop_open($data){
        $shop_openid=$data['shop_openid'];
        $shop_token=DB::table('cp_shop')->where('shop_openid','=',$shop_openid)->pluck('shop_token');

        if($shop_token){
            $da =DB::table('cp_shop')->where('shop_openid','=',$shop_openid)->select('id','keeper_mobile','shop_status','shop_token')->get();

        }else{


            $s='';
            $str = "0123456789abcdefghijklmnopqrstuvwxyz";//输出字符集
            $n = 4;//输出串长度
            $len = strlen($str)-1;
            $time=time();

            for($i=0 ; $i<$n; $i++){
                $s .= $str[rand(0,$len)];
            }
            $s=$s.$time;
            $d=DB::table('cp_shop')->where('shop_openid','=',$shop_openid)->update(array('shop_token'=>$s));
            $da =DB::table('cp_shop')->where('shop_openid','=',$shop_openid)->select('id','keeper_mobile','shop_status','shop_token')->get();

           
        }
       

            if($da){
                return $da; 
            }else{
                return false;
            }
         
    }


     /**
     * 改变店铺出票次数
     */
    public function cp_nums($data){
        $id=$data['order_id'];     
        $da =DB::table('cp_order')->where('id','=',$id)->select('order_shop')->get();
		foreach($da as $key => $value){
			$shopid = $value->order_shop;
		}
		$da =DB::table('cp_shop')->where('id','=',$shopid)->increment('shop_cpnum',1);
		
        if($da){
            return true;
        }else{
            Log::info('店铺出票次数修改异常');
            return false;
            
        }
    }

    /**
     * 查找店铺余额
     */
    public function shop_balance($data){
        $id = DB::table('cp_shop')->where('shop_token','=',$data['shopid'])->pluck('id');
        $shop_trans_balance = DB::table('cp_balance_shop')->where('id','=',$id)->select('balance','giveprize')->get();
        $arr=[];
        if($shop_trans_balance){
            foreach($shop_trans_balance as $k=>$v){
                if(isset($v->balance)){
                     $arr['balance'] = $v->balance;
                }else{
                     $arr['balance'] = 0;
                }

                if(isset($v->giveprize)){
                     $arr['giveprize'] = $v->giveprize;
                }else{
                     $arr['giveprize'] = 0;
                }
            }

        }else{
           $arr['giveprize'] = 0;
           $arr['balance'] = 0;
        }
        
         return $arr;
       
    }

}
