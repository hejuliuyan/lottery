<?php namespace App\Http\Controllers\Home;
use Request;
use DB;
use QL\QueryList;

/**
 * 首页
 *
 * @author wang <775720867@qq.com>
 */
class KjController extends Controller
{
    /**
     * 七星彩开奖结果
     */
    public function qxc(){
	    $n_qi = DB::table('cp_draw_result')->where('types','=','02')->where('active','=','1')->orderBy('num','desc')->take(1)->pluck('num');

        $data=file_get_contents('http://www.lottery.gov.cn/lottery/qxc/Detail.aspx');
        //log::info(file_put_contents('mui/kj/qxc.html', $data));
        file_put_contents('mui/kj/qxc.html', $data);

        $html = file_get_contents('mui/kj/qxc.html');
        $data = QueryList::Query($html, array('time'=>array('#LabelEventDrawDate','text'),'number' => array('table td span','text'),'num_qi'=>array('#DropDownListEvents option:first','text')))->data;

        $qxc = $data[2]['number'].','.$data[3]['number'].','.$data[4]['number'].','.$data[5]['number'].','.$data[6]['number'].','.$data[7]['number'].','.$data[8]['number'];

        
        //log::info($qxc);
        //log::info('lalalaalall');
        $arr=[];
        $str=$data[0]['time'];
        preg_match_all('/\d/',$str,$arr);
        $timer=implode('',$arr[0]);
        $notice_date=strtotime($timer);
        $deadline=$notice_date+60*24*3600;

        $one_cash = $data[10]['number'];
        $two_cash = $data[12]['number'];
        $three_cash = $data[14]['number'];

        if($n_qi<$data[0]['num_qi']){
           
            $id = DB::table('cp_draw_result')->insertGetId(array('name'=>'七星彩','num'=>$data[0]['num_qi'],'numbers'=>$qxc,'types'=>'02','notice_date'=>$notice_date,'deadline'=>$deadline,'status'=>'0','zj_status'=>'0','active'=>'1'));

           
            $sql_one = DB::table('cp_winning_cash')->insertGetId(array('mon_id'=>$id,'level'=>'1','cash'=>$one_cash,'cash_add'=>'0','active'=>'1'));
            
           

            $sql_two = DB::table('cp_winning_cash')->insertGetId(array('mon_id'=>$id,'level'=>'2','cash'=>$two_cash,'cash_add'=>'0','active'=>'1'));

            $sql_three = DB::table('cp_winning_cash')->insertGetId(array('mon_id'=>$id,'level'=>'3','cash'=>$three_cash,'cash_add'=>'0','active'=>'1'));


        }
    }

    

}