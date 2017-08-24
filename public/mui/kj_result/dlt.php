<?php 

/**
 * 大乐透定时获取数据
 *
 * @author deng ‎2016‎年‎8‎月‎24‎日，‏‎17:35:20
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

		public function index(){
			$a=rand(0000,9999);
			$b=rand(0000,9999);

			$sql="select num from cp_draw_result where types='01' and active=1 order by num desc limit 1";
			$query=$this->DB->query($sql);
			$data= $query->fetch_assoc();
			//print_r($data);
			$new_num=$data['num']+1;

			$html=file_get_contents('http://www.ticaidgg.com/wx_interface/tcd/getDetailData.do?r1='.$a.'&r2='.$b.'&eventname='.$new_num.'');
			
			$h=substr($html, 5,-2);
			$hh=json_decode($h,true);
			//echo "<pre>";
			//print_r($hh);

			$number_q=$hh['detail']['DrawContents'][0];
			$number_h=$hh['detail']['DrawContents'][1];
			$number=implode(',', $number_q).'|'.implode(',', $number_h);
			//echo $number;
			$arr=[];
			$str=$hh['detail']['DrawDate'];
			preg_match_all('/\d/',$str,$arr);

			$timer=implode('',$arr[0]);
			$notice_date=strtotime($timer);
			$deadline=$notice_date+60*24*3600;

			$one_cash=$hh['detail']['DrawDetailss'][1];
			$one_add=$hh['detail']['DrawDetailss'][3];
			$two_cash=$hh['detail']['DrawDetailss'][5];
			$two_add=$hh['detail']['DrawDetailss'][7];
			$three_cash=$hh['detail']['DrawDetailss'][9];
			$three_add=$hh['detail']['DrawDetailss'][11];

			//echo $data['num'];
			if($data['num']<$hh['detail']['EventName']){
				//echo 1;
				$sql = "insert into cp_draw_result(name,num,numbers,types,notice_date,deadline,status,zj_status,active) values('大乐透','".$hh['detail']['EventName']."','".$number."','01','".$notice_date."','".$deadline."','0','0','1')";
				$this->DB->query($sql);

				$id=$this->DB->insert_id;

				$sql_one = "insert into cp_winning_cash(mon_id,level,cash,cash_add,active) values('".$id."','1','".$one_cash."','".$one_add."','1')";

				$this->DB->query($sql_one);
				

				$sql_two = "insert into cp_winning_cash(mon_id,level,cash,cash_add,active) values('".$id."','2','".$two_cash."','".$two_add."','1')";

				$this->DB->query($sql_two);


				$sql_three = "insert into cp_winning_cash(mon_id,level,cash,cash_add,active) values('".$id."','3','".$three_cash."','".$three_add."','1')";

				$this->DB->query($sql_three);
				
				
			}
			
			

		}
	}

	$obj = new index();
	$obj->index();
	

 ?>