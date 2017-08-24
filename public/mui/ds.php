<?php

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
			$date=date('w');
			if($date==1 || $date==3 || $date==6){
				$sql="update cp_types set num_qi=num_qi+1 where types='01'";
				$this->DB->query($sql);
			}

			if($date==0 || $date==2 || $date==5){
				$sql="update cp_types set num_qi=num_qi+1 where types='02'";
				$this->DB->query($sql);
			}
			
			$sql="update cp_types set num_qi=num_qi+1 where types='03'";
			$this->DB->query($sql);

			$sql="update cp_types set num_qi=num_qi+1 where types='04'";
			$this->DB->query($sql);

		}
	}

	$obj = new index();
	$obj->index();
?>