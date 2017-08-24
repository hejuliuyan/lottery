<?php 
require 'vendor/autoload.php';
use QL\QueryList;

/**
 * 排三排五定时获取数据
 *
 * @author deng ‎2016‎年‎8‎月‎23‎日，‏‎16:50:17
 */
	Class index {
		public function __construct(){
			$this->DB = new mysqli('114.215.192.73','bcuser','bctechpass2016','caipiao');
			if(mysqli_connect_errno()){
				echo '数据库连接错误，错误信息:'.mysqli_connect_error();
				exit();
			}

			$this->DB->set_charset('uft8');

		}


		public function p3_p5(){

			$sql="select num from cp_draw_result where types='03' and active=1 order by num desc limit 1";
			$query=$this->DB->query($sql);
			$n_qi= $query->fetch_assoc();
			

			$data=file_get_contents('http://www.lottery.gov.cn/lottery/pls/Detail.aspx');
			file_put_contents('kj/pls.html', $data);

			$html = file_get_contents('kj/pls.html');
			$data = QueryList::Query($html, array('time'=>array('#LabelEventDrawDate','text'),'number' => array('table td span font','text'),'num_qi'=>array('#DropDownListEvents option:first','text')))->data;

			$p3 = $data[0]['number'].','.$data[1]['number'].','.$data[2]['number'];
			$p5 = $data[3]['number'].','.$data[4]['number'].','.$data[5]['number'].','.$data[6]['number'].','.$data[7]['number'];

			$arr=[];
			$str=$data[0]['time'];
			preg_match_all('/\d/',$str,$arr);
			$timer=implode('',$arr[0]);
			$notice_date=strtotime($timer);
			$deadline=$notice_date+60*24*3600;
 

			if($n_qi['num']<$data[0]['num_qi']){
				$sql_p3="insert into cp_draw_result(name,num,numbers,types,notice_date,deadline,status,zj_status,active) values('排列三','".$data[0]['num_qi']."','".$p3."','03','".$notice_date."','".$deadline."','0','0','1')";
				$this->DB->query($sql_p3);

				$sql_p5="insert into cp_draw_result(name,num,numbers,types,notice_date,deadline,status,zj_status,active) values('排列五','".$data[0]['num_qi']."','".$p5."','04','".$notice_date."','".$deadline."','0','0','1')";
				$this->DB->query($sql_p5);


			}

			//echo "<pre>";
			//print_r($data);
			//var_dump($p3);
			//var_dump($p5);

		}


		

		
	}

	$obj = new index();
	$obj->p3_p5();
	

 ?>