<?php namespace App\Http\Controllers\Home;
use App\Models\Home\Wexin as WexinModel;
use App\Models\Home\Content as ContentModel;
use Request;
use Config;
use Log;
use Redirect;
use DB;
use Illuminate\Support\Facades\Session;

/**
 * 微信相关功能
 *
 * @author deng 2016‎年‎8‎月‎31‎日，‏‎20:17:41
 */
class WxController extends Controller
{   
     

    //微信授权
    public function index(){
     $appid= Config::get('app.wechat_appid');
     $secret= Config::get('app.wechat_secret');
     $domain= Config::get('app.domain');
     $scope = "snsapi_userinfo";
         
     $tz_bj = $_GET['tz'];
        if($tz_bj==1){
            if(isset($_GET['shopid'])){
                $shopid=$_GET['shopid'];
                //Session::put('shopid', $shopid);
                //Session::save();
                //$sid=Session::get('shopid');
                $redirect_uri = "http%3a%2f%2f".$domain."%2findex.php%2fwx%3ftz%3d4%26shopid%3d".$shopid."";
                $url="Location: https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$appid."&redirect_uri=".$redirect_uri."&response_type=code&scope=".$scope."&state=STATE#wechat_redirect";
                header($url);
            }else{
                //Session::forget('shopid');
                $redirect_uri = "http%3a%2f%2f".$domain."%2findex.php%2fwx%3ftz%3d4";
                $url="Location: https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$appid."&redirect_uri=".$redirect_uri."&response_type=code&scope=".$scope."&state=STATE#wechat_redirect";
                header($url);
            }
            
        }elseif($tz_bj==2){
            $redirect_uri = "http%3a%2f%2f".$domain."%2findex.php%2fwx%3ftz%3d3";
            $url="Location: https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$appid."&redirect_uri=".$redirect_uri."&response_type=code&scope=".$scope."&state=STATE#wechat_redirect";
            header($url);
        }elseif($tz_bj==3){
            $code = $_GET['code'];
            //获取用户openid
            $http = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$secret."&code=".$code."&grant_type=authorization_code";
            $content = file_get_contents($http);

            $url="http://".$domain."/mui/shop_login.html?openid=".strval($content);
            return redirect($url);
        }elseif($tz_bj==4){
            $code = $_GET['code'];
            
            
            //获取用户openid
            $http = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$secret."&code=".$code."&grant_type=authorization_code";
            $content = file_get_contents($http);
            //log::info($content);die();
            //$oid = strval($content);
            //log::info($oid);die();
            $oid = json_decode($content,true);

            $tk = DB::table('cp_member')->where('openid','=',$oid['openid'])->pluck('tokenid');
            if(isset($tk)){
                if(isset($_GET['shopid'])){
                        $shopid=$_GET['shopid'];
                        $sid = DB::table('cp_shop')->where('shop_token','=',$shopid)->pluck('id');
                        $data = DB::table('cp_member')->where('tokenid','=',$tk)->update(array('shop_id'=>$sid));
                        
                        $url="http://".$domain."/mui/index.html?tk=".$tk;
                        return redirect($url);
                        
                        
                    }else{
                        $url="http://".$domain."/mui/index.html?tk=".$tk;
                        return redirect($url);
                    }
                
            }else{
                $s = '';
                $str = "0123456789abcdefghijklmnopqrstuvwxyz";//输出字符集
                $n = 6;//输出串长度
                $len = strlen($str) - 1;

                for ($i = 0; $i < $n; $i++) {
                    $s .= $str[rand(0, $len)];
                }
                $s = 'xm' . $s;

                $t = '';
                $le = 4;
                $time = (string)time();
                for ($k = 0; $k < $le; $k++) {
                    $t .= $str[rand(0, $len)];
                }

                $t ='yk_'.$t.time();
                $account = $s;

                $da = DB::table('cp_member')->insertGetId(array('account' => $account, 'openid' => $oid['openid'], 'created_at' => $time, 'updated_at' => $time,'tokenid'=>$t));

                if($da){
                    if(isset($_GET['shopid'])){
                        $shopid=$_GET['shopid'];
                        $sid = DB::table('cp_shop')->where('shop_token','=',$shopid)->pluck('id');
                        $data = DB::table('cp_member')->where('tokenid','=',$t)->update(array('shop_id'=>$sid));
                        
                        $url="http://".$domain."/mui/index.html?tk=".$t;
                        return redirect($url);
                        
                        
                    }else{
                        $url="http://".$domain."/mui/index.html?tk=".$t;
                        return redirect($url);
                    }
                    
                }

            }
            

            

        }   
    }

    //判断进入的模式
    public function middle(){
        $domain= Config::get('app.domain');
        if(isset($_GET['shopid'])){
            $shopid=$_GET['shopid'];
            Session::put('shopid', $shopid);
            Session::save();
            $url="http://".$domain."/mui/index.html?shopid=".$shopid;
            return redirect($url);
            
        }else{
            Session::forget('shopid');
            $url="http://".$domain."/mui/index.html";
            return redirect($url);
            
        }
        
    }




    //判断前端用户token
    public function token_check(){
        $token=$_POST['token'];
        if(isset($token)){
            $data = DB::table('cp_member')->where('tokenid','=',$token)->select('password','real_name','mobile','idcard_numer','active')->get();
            foreach ($data as $k => $v) {
                $pas=$v->password;
                $r_name=$v->real_name;
                $phone=$v->mobile;
                $idcard=$v->idcard_numer;
                $role=$v->active;
            }

            if(!isset($pas) || !isset($phone)){
                echo 1;
            }else if(!isset($r_name) || !isset($idcard)){
                echo 2;
            }else if($role==1){
                echo 3;
            }
        }else{
            echo json_encode(false);
        }
        
    }

     //判断前端店铺shopid
    public function shopid_check(){
        $shopid=$_POST['shopid'];
        if($shopid){
            $data = DB::table('cp_shop')->where('shop_token','=',$shopid)->select('active')->get();
            foreach ($data as $k => $v) {
                $role=$v->active;
            }

            if($role!=1){
                echo 1;
            }
        }else{
            echo json_encode(false);
        }
        
    }

    //获取token 7200
    public function wx_token(){
        $appid= Config::get('app.wechat_appid');
        $secret= Config::get('app.wechat_secret');
        $domain= Config::get('app.domain');
        //$appid = "wxe71525fd5bf234b2";
        //$secret = "f5181264de5a62e4e627e3d6175dbeba";
        $code = $_GET['code'];
        //获取用户openid
        $http = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$secret."&code=".$code."&grant_type=authorization_code";
        $content = file_get_contents($http);

        /*$wexinModel = new WexinModel();
        $token = $wexinModel->access_token();*/

        return strval($content);
    }

    public function wx_name(){//拿取用户信息
        $wexinModel = new WexinModel();
        $token = $wexinModel->access_token();
        $tid = $_POST['token'];
        $type= $_POST['type'];
        if($type==1){
            $openid = DB::table('cp_member')->where('tokenid','=',$tid)->pluck('openid'); 
        }elseif($type==2){
            $openid = DB::table('cp_shop')->where('shop_token','=',$tid)->pluck('shop_openid'); 
        }
        
        $http = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$token."&openid=".$openid."";
        //$http = "https://api.weixin.qq.com/sns/userinfo?access_token=".$token."&openid=".$_POST['openid']."&lang=zh_CN";
        $content = file_get_contents($http);
        return strval($content);
    }

    //支付模板
    public function send(){
        $appid= Config::get('app.wechat_appid');
        $secret= Config::get('app.wechat_secret');
        $domain= Config::get('app.domain');
        $wexinModel = new WexinModel();
        $token = $wexinModel->access_token();

        if($_POST['muban_id']==1){//支付成功并且推送给店家
            //$openid = $_POST['openid'];
            $openid = DB::table('cp_member')->where('tokenid','=',$_POST['userid'])->pluck('openid');
            $data =' {
                "touser":"'.$openid.'",
                "template_id":"9NhL203oaAvZ0CMmnMZKnYMNlc3s14HGMph0FNt3YHA",
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
            $wexinModel = new WexinModel();
            $data = $wexinModel->index($send,$data);
        }else if($_POST['muban_id']==2){//店家已出票，等待用户确认出票
            $ContentModel = new ContentModel();
            $res= $ContentModel->user_openid($_POST);

            foreach($res as $key => $value){
                $openid = $value->openid;
            }
            /*'.$domain.'./mui/order.html?userid='.$_POST['id'].'&order_id='.$_POST['order_id'].'*/
            //$openid = $res['openid'];
            $data =' {
               "touser":"'.$openid.'",
               "template_id":"WtBtwwwpKOthnt97q-Noxw0lM7wi3YZl1N7UBShH0NA",
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
            $wexinModel = new WexinModel();
            $data = $wexinModel->index($send,$data);
        }else if($_POST['muban_id']==3){//店家已派奖，请查收
            //$openid = $res['openid'];
            $data =' {
               "touser":"'.$_POST['openid'].'",
               "template_id":"b5KExYTJ8l0kq4fbfZz-mofliI7IlfFvpKaOOQIpTlw",
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
            $wexinModel = new WexinModel();
            $data = $wexinModel->index($send,$data);
        }else if($_POST['muban_id']==4){//用户催店铺接单
            //$openid = $res['openid'];
            $data =' {
               "touser":"'.$_POST['openid'].'",
               "template_id":"laGqzZFZDsz4S9uxwZdSfZYYL3apmy8cjDPsAnhnFRA",
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
            $wexinModel = new WexinModel();
            $data = $wexinModel->index($send,$data);
        }else if($_POST['muban_id']==5){//用户催店铺出票
            //$openid = $res['openid'];
            $data =' {
               "touser":"'.$_POST['openid'].'",
               "template_id":"4oW3OnbeetbV9cCz6h8eZgGlrOQMKT1xak9udfbcPuU",
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
            $wexinModel = new WexinModel();
            $data = $wexinModel->index($send,$data);
        }



//      $data = urldecode($data);
//      $send = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$token."";
//      $wexinModel = new WexinModel();
//      $data = $wexinModel->index($send,$data);
        return $data;
    }

    //微信签名jdk
    public function jdk(){
        $appid= Config::get('app.wechat_appid');
        $secret= Config::get('app.wechat_secret');
        $domain= Config::get('app.domain');
        //$url=json_encode($_POST['url'],true);
       // echo $url;
        $url=$_POST['url'];
        $wexinModel = new WexinModel();
        $token = $wexinModel->access_token();
        $http="https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=".$token."&type=jsapi";

        $content = file_get_contents($http);
        $arr = explode("\"",$content);
        $time = strtotime("now");
            $str = null;
            $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
            $max = strlen($strPol)-1;

            for($i=0;$i<16;$i++){
             $str.=$strPol[rand(0,$max)];//rand($min,$max)生成介于min和max两个数之间的一个随机整数
            }

            $noncestr = $str;
        $ticket = $arr[9];
        $jiami = "jsapi_ticket=".$ticket."&noncestr=".$noncestr."&timestamp=".$time."&url=".$url;
        //$jiami = "jsapi_ticket=".$ticket."&noncestr=Wm3WZYTPz0wzxxxS&timestamp=".$time."&url=http://test.foodietech.cn/";
        $data = array('time'=>$time,'noncestr'=>$noncestr,'data'=>sha1($jiami),'http'=>$http,'url'=>$url);
        echo json_encode($data);
        die();

    }

    //微信登录
    public function wxlogin(){
        $wexinModel = new WexinModel();
        $wxlogin = $wexinModel->wxlogin($_POST);
        $data = array('status'=>1,'msg'=>'成功','data'=>$wxlogin);
        echo json_encode($data);
        die();

    }


    //微信上传
    public function wx_upload(){
        $o_id=json_encode($_POST['oid'],true);
       // echo $o_id;
        if(empty($o_id)){
            return false;
        }else{
            //echo $o_id;
            $pid = json_encode($_POST['mid'],true);
            $str2 = substr($pid,1,-1);
            $wexinModel = new WexinModel();
            $token = $wexinModel->access_token();
            $dy = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$token.'&media_id='.$str2;
           // mkdir("./Uploads/User_cert/1.txt", 0777, true);
            //echo $dy;
            $pic_path=time().rand(1000,9999).'.jpg';
            $targetName = '../public/Uploads/photo/'.$pic_path;
            $ch = curl_init($dy); // 初始化
            $fp = fopen($targetName, 'wb'); // 打开写入
            curl_setopt($ch, CURLOPT_FILE, $fp); // 设置输出文件的位置，值是一个资源类型
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_exec($ch);
            curl_close($ch);
            fclose($fp);
            $res = $wexinModel->insert_pic($pic_path);
            if(isset($res)){
                echo '1';
            }else{
                echo '0';
            }

        }
    }

      /**
     * 安卓拍照
     */
    public function pic_upload()
    {
         //return '1';die();
        $img = base64_decode($_POST['pic']);
        //echo $img;die();
        // Log::info($img);
        $pic_path = time().rand(1000, 9999).'.jpg';
        //Log::info($pic_path);
        file_put_contents('../public/Uploads/photo/'.$pic_path, $img);
        $res = DB::table('cp_order_pic')->insert( ['p_name' => $pic_path, 'o_id' => $_POST['oid']]);

        if ($res) {
            echo '1';
        } else {
            echo '0';
        }


    }
        //代销证上传
        public function wx_upload_licence(){
        $shopid=json_encode($_POST['shopid'],true);
        $sid=$_POST['shopid'];
       // echo $o_id;
        if(empty($shopid)){
            return false;
        }else{
            //echo $o_id;
            $pid = json_encode($_POST['mid'],true);
            $str2 = substr($pid,1,-1);
            $wexinModel = new WexinModel();
            $token = $wexinModel->access_token();
            $dy = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$token.'&media_id='.$str2;
           // mkdir("./Uploads/User_cert/1.txt", 0777, true);
            //echo $dy;
            $pic_path=time().rand(1000,9999).'.jpg';
            $targetName = '../public/Uploads/photo/'.$pic_path;
            $ch = curl_init($dy); // 初始化
            $fp = fopen($targetName, 'wb'); // 打开写入
            curl_setopt($ch, CURLOPT_FILE, $fp); // 设置输出文件的位置，值是一个资源类型
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_exec($ch);
            curl_close($ch);
            fclose($fp);
            $res = $wexinModel->lin_pic($pic_path,$sid);
            if(isset($res)){
                echo '1';
            }else{
                echo '0';
            }

        }



    }

    //显示照片
    public function show_pic(){
        $o_id=$_GET['oid'];
        if(!empty($o_id)){
            $wexinModel = new WexinModel();
            $arr = $wexinModel->show_pic($o_id);
            echo json_encode($arr);
        }
    }




}