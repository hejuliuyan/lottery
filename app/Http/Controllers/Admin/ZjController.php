<?php namespace App\Http\Controllers\Admin;
use App\Models\Admin\Zjcontent as ZjModel;
use App\Models\Admin\Access as AccessModel;
use Request;
use DB;



/**
 * 中奖处理相关
 *
 * @author deng  2016‎年‎8‎月‎16‎日，‏‎11:55:37
 */
class ZjController extends Controller
{
	/**
     * 中奖结果处理页面
     */
    public function index()
    {
    	$Model = new ZjModel();
        return view('admin.award.index');
		
		
    }

    /**
     * 中奖结果处理
     */
    public function do_zj()
    {   
        $Model = new ZjModel();
        $data = $Model->do_zj($_POST);
        echo json_encode($data);
                
    }

    /**
     * 中奖用户推送
     */
    public function zj_send()
    {   
        $wexinModel = new ZjModel();
        $token = $wexinModel->access_token();
        $zj_qi=$_POST['zj_qi'];
        $types=$_POST['types'];

        if (mb_strlen($types) < 2) {
            $types = '0' . $types;
        }

        $tx_status = DB::table('cp_draw_result')->where('types','=',$types)->where('num','=',$zj_qi)->select('zj_status')->get();

        //echo json_encode($types);die();

        $da = DB::table('cp_order')->join('cp_order_detail','cp_order.id','=','cp_order_detail.order_id')->where('type','=',$types)->where('order_qi','=',$zj_qi)->where('cp_order_detail.win','=','1')->select('cp_order.uid','cp_order.id')->get();
        $res=[];
        $re=[];
        $openid=[];



            //判断状态是否处理过
            foreach($tx_status as $key=>$value){
                if($value->zj_status==1){
                    $tx='solved';
                    echo json_encode($tx);
                    die();
                }
            }


            foreach($da as $k=>$val){
                $res[]=$val->uid;
                $re[]=$val->id;
            }


            $uid=array_unique($res);
            $odid=array_unique($re);
            

            foreach($uid as $kd=>$v){
                $openid[]= DB::table('cp_member')->where('id','=',$v)->select('openid')->get();
            }

            //echo json_encode($openid);die();
    
            foreach($odid as $ki=>$vol){
                $dc = DB::table('cp_order_log')->insert(array('order_id' => $vol, 'time' => time(), 'd_value' =>'彩票已中奖', 'order_status' => '06'));
            }
            
            foreach ($openid as $key => $value) {
                foreach($value as $ky=>$voll){
                    $op=$voll->openid;
                    $data =' {
                    "touser":"'.$op.'",
                    "template_id":"lw7hRqq11-IDWC5WQWtdOkd8svQj_bCb4GFHI9faxGc",
                    "url":"",           
                    "data":{
                           "first": {
                               "value":"恭喜你购买成功！",
                               "color":"#173177"
                           },
                           "keynote1":{
                               "value":"巧克力",
                               "color":"#173177"
                           },
                           "keynote2": {
                               "value":"39.8元",
                               "color":"#173177"
                           },
                           "keynote3": {
                               "value":"2014年9月22日",
                               "color":"#173177"
                           },
                           "remark":{
                               "value":"欢迎再次购买！",
                               "color":"#173177"
                           }
                   }
                }';
                $data = urldecode($data);
                $send = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$token."";
                $data = $wexinModel->index($send,$data);
                }
            }
              
        $result = DB::table('cp_draw_result')->where('types','=',$types)->where('num','=',$zj_qi)->update(array('zj_status'=>1));

        if($result){
            echo json_encode(true);
        }else{
            echo json_encode(false);
        }
    }


    /**
     * 获取该期中奖号码
     */
    public function zj_num()
    {   
        $Model = new ZjModel();
        $data = $Model->zj_num($_POST);
        echo json_encode($data);
                
    }

     /**
     * 获取该期中奖详情
     */
    public function zj_detail()
    {   
        $Model = new ZjModel();
        $data = $Model->zj_detail($_POST);

        echo json_encode($data);
                
    }

    /**
     * 获取该期中奖总金额
     */
    public function zj_total()
    {   
        $Model = new ZjModel();
        $data = $Model->zj_total($_POST);
        echo json_encode($data);
                
    }

    /**
     * 店铺派奖银联支付
     */
    public function shop_bank()
    {   
        $Model = new ZjModel();
        $data = $Model->shop_bank($_POST);
        echo json_encode($data);
                
    }

    /**
     * 店铺派奖余额支付
     */
    public function shop_balance_pay()
    {   
        $Model = new ZjModel();
        $data = $Model->shop_balance_pay($_POST);
        echo json_encode($data);
                
    }

}