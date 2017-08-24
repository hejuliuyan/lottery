<?php 
require 'vendor/autoload.php';
use QL\QueryList;

/**
 * 七星彩定时获取数据
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
		
		
		public function qxc(){
			$sql="select num from cp_draw_result where types='02' and active=1 order by num desc limit 1";
			$query=$this->DB->query($sql);
			$n_qi= $query->fetch_assoc();

			$data=file_get_contents('http://www.lottery.gov.cn/lottery/qxc/Detail.aspx');
			file_put_contents('kj/qxc.html', $data);

			$html = file_get_contents('kj/qxc.html');
			$data = QueryList::Query($html, array('time'=>array('#LabelEventDrawDate','text'),'number' => array('table td span','text'),'num_qi'=>array('#DropDownListEvents option:first','text')))->data;

			$qxc = $data[2]['number'].','.$data[3]['number'].','.$data[4]['number'].','.$data[5]['number'].','.$data[6]['number'].','.$data[7]['number'].','.$data[8]['number'];

			var_dump($qxc);

			$arr=[];
			$str=$data[0]['time'];
			preg_match_all('/\d/',$str,$arr);
			$timer=implode('',$arr[0]);
			$notice_date=strtotime($timer);
			$deadline=$notice_date+60*24*3600;

			$one_cash = $data[10]['number'];
			$two_cash = $data[12]['number'];
			$three_cash = $data[14]['number'];

			if($n_qi['num']<$data[0]['num_qi']){
				$sql="insert into cp_draw_result(name,num,numbers,types,notice_date,deadline,status,zj_status,active) values('七星彩','".$data[0]['num_qi']."','".$qxc."','02','".$notice_date."','".$deadline."','0','0','1')";

				$this->DB->query($sql);

				$id=$this->DB->insert_id;

				$sql_one = "insert into cp_winning_cash(mon_id,level,cash,cash_add,active) values('".$id."','1','".$one_cash."','0','1')";

				$this->DB->query($sql_one);
				

				$sql_two = "insert into cp_winning_cash(mon_id,level,cash,cash_add,active) values('".$id."','2','".$two_cash."','0','1')";

				$this->DB->query($sql_two);


				$sql_three = "insert into cp_winning_cash(mon_id,level,cash,cash_add,active) values('".$id."','3','".$three_cash."','0','1')";

				$this->DB->query($sql_three);




			}

			//echo "<pre>";
			//print_r($data);

		}

		
	}

	$obj = new index();
	$obj->qxc();
	

 ?>