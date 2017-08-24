<?php 

	function p3_zj($zj_num,$tz_num,$tz_type){
		$zj_arr=explode(',',$zj_num);
		$x=[];
		if (count($zj_arr) != count(array_unique($zj_arr))) {   
		   	$zj_type=1;  
		}else{
			$zj_type=2; 
		}

		if($tz_type==0){
			$arr=[];
			$brr=[];
			$crr=[];
			$drr=[];
			$arr=explode('|', $tz_num);
			if(strpos($arr[0],',')==false){
				if($zj_arr[0]==$arr[0]){
					$bw=true;
				}else{
					$bw=false;
				}
			}elseif(strpos($arr[0],',')>-1){
				$brr=explode(',',$arr[0]);
				$bw=in_array($zj_arr[0],$brr);
			}

			if(strpos($arr[1],',')==false){
				if($zj_arr[1]==$arr[1]){
					$sw=true;
				}else{
					$sw=false;
				}
			}elseif(strpos($arr[1],',')>-1){
				$crr=explode(',',$arr[1]);
				$sw=in_array($zj_arr[1],$crr);
			}

			if(strpos($arr[2],',')==false){
				if($zj_arr[2]==$arr[2]){
					$gw=true;
				}else{
					$gw=false;
				}
			}elseif(strpos($arr[2],',')>-1){
				$drr=explode(',',$arr[2]);
				$gw=in_array($zj_arr[2],$drr);
			}

			if($bw && $sw && $gw){
				$x['zx']=1024;
				return $x;
			}


		}elseif($tz_type==1){
			if($zj_type==1){
				$arr=[];
				$brr=[];
				$crr=[];
				$drr=[];
				$err=[];
				$arr=array_unique($zj_arr);
				//var_dump($arr);
				if(strpos($tz_num,';')==false){
					$brr=explode(',', $tz_num);
					$z3=count(array_intersect($arr,$brr));
					if($z3==2){
						$x['z3']=346;
						return $x;
					}
				}elseif(strpos($tz_num,';')>-1){
					$brr=explode(';', $tz_num);
					$crr=array_pop($brr);
					if(strlen($crr)>1){
						$drr=explode(',',$crr);
						$z3_n=count(array_intersect($drr,$arr));
					}else{
						$drr[]=$crr;
						$z3_n=count(array_intersect($drr,$arr));
					}
					$dan=count($brr);
					$n_dan=count($drr);
					$z3_dan=count(array_intersect($brr,$arr));
					
					if($dan==$z3_dan && $z3_n>0){
						$x['z3']=346;
						return $x;
					}

				}
			}
		}elseif($tz_type==2){
			if($zj_type==2){
				$arr=[];
				$brr=[];
				$crr=[];
				$drr=[];
				$err=[];
				$arr=explode(',',$zj_num);
				if(strpos($tz_num,';')==false){
					$brr=explode(',', $tz_num);
					$z6=count(array_intersect($arr,$brr));
					if($z6==3){
						$x['z6']=173;
						return $x;
					}
				}elseif(strpos($tz_num,';')>-1){
					$brr=explode(';', $tz_num);
					$crr=array_pop($brr);
					if(strlen($crr)>1){
						$drr=explode(',',$crr);
						$z6_n=count(array_intersect($drr,$arr));
					}else{
						$drr[]=$crr;
						$z6_n=count(array_intersect($drr,$arr));
					}
					$dan=count($brr);
					$n_dan=count($drr);
					$z6_dan=count(array_intersect($brr,$arr));
					
					if($dan==2){
						if($dan==$z6_dan && $z6_n==1){
							$x['z6']=173;
							return $x;
						}
					}elseif($dan==1){
						if($dan==$z6_dan && $z6_n==2){
							$x['z6']=173;
							return $x;
						}
					}
					

				}
			}
		}elseif($tz_type==3){
			if($zj_type==2){
				$arr=[];
				$brr=[];
				$crr=[];
				$drr=[];
				$err=[];
				$arr=explode(',',$zj_num);
				if(strpos($tz_num,';')==false){
					$brr=explode(',', $tz_num);
					$zt=count(array_intersect($arr,$brr));
					if($zt==3){
						$x['zdan']=1024;
						return $x;
					}
				}elseif(strpos($tz_num,';')>-1){
					$brr=explode(';', $tz_num);
					$crr=array_pop($brr);
					if(strlen($crr)>1){
						$drr=explode(',',$crr);
						$zt_n=count(array_intersect($drr,$arr));
					}else{
						$drr[]=$crr;
						$zt_n=count(array_intersect($drr,$arr));
					}
					$dan=count($brr);
					$n_dan=count($drr);
					$zt_dan=count(array_intersect($brr,$arr));
					
					if($dan==2){
						if($dan==$zt_dan && $zt_n==1){
							$x['zdan']=1024;
							return $x;
						}
					}elseif($dan==1){
						if($dan==$zt_dan && $zt_n==2){
							$x['zdan']=1024;
							return $x;
						}
					}
				}
			}

		}elseif($tz_type==4){
				$arr=[];
				$brr=[];
				$crr=[];
				$drr=[];
				$err=[];
				$arr=explode(',',$zj_num);

				$arr_sum=array_sum($arr);
				if($arr_sum<10){
					$arr_sum='0'.$arr_sum;
				}
				$brr=explode(',', $tz_num);
				if(in_array($arr_sum,$brr)){
					$x['hz_zx']=1024;
					return $x;
				}

		}elseif($tz_type==5){
			if($zj_type==1){
				$arr=[];
				$brr=[];
				$crr=[];
				$drr=[];
				$err=[];
				$arr=explode(',',$zj_num);

				$arr_sum=array_sum($arr);
				if($arr_sum<10){
					$arr_sum='0'.$arr_sum;
				}
				$brr=explode(',', $tz_num);
				if(in_array($arr_sum,$brr)){
					$x['hz_z3']=346;
					return $x;
				}
			}
				

		}elseif($tz_type==6){
			if($zj_type==2){
				$arr=[];
				$brr=[];
				$crr=[];
				$drr=[];
				$err=[];
				$arr=explode(',',$zj_num);

				$arr_sum=array_sum($arr);
				if($arr_sum<10){
					$arr_sum='0'.$arr_sum;
				}
				$brr=explode(',', $tz_num);
				if(in_array($arr_sum,$brr)){
					$x['hz_z6']=173;
					return $x;
				}
			}
				
		}

	}


	function p5_zj($zj_num,$tz_num,$tz_type){
		$zj_arr=explode(',',$zj_num);
		$x=[];
		$arr=[];
		$brr=[];
		$crr=[];
		$drr=[];
		$err=[];
		$grr=[];
		$arr=explode('|', $tz_num);
		if(strpos($arr[0],',')==false){
			if($zj_arr[0]==$arr[0]){
				$ww=true;
			}else{
				$ww=false;
			}
		}elseif(strpos($arr[0],',')>-1){
			$brr=explode(',',$arr[0]);
			$ww=in_array($zj_arr[0],$brr);
		}

		if(strpos($arr[1],',')==false){
			if($zj_arr[1]==$arr[1]){
				$qw=true;
			}else{
				$qw=false;
			}
		}elseif(strpos($arr[1],',')>-1){
			$crr=explode(',',$arr[1]);
			$qw=in_array($zj_arr[1],$crr);
		}

		if(strpos($arr[2],',')==false){
			if($zj_arr[2]==$arr[2]){
				$bw=true;
			}else{
				$bw=false;
			}
		}elseif(strpos($arr[2],',')>-1){
			$drr=explode(',',$arr[2]);
			$bw=in_array($zj_arr[2],$drr);
		}

		if(strpos($arr[3],',')==false){
			if($zj_arr[3]==$arr[3]){
				$sw=true;
			}else{
				$sw=false;
			}
		}elseif(strpos($arr[3],',')>-1){
			$err=explode(',',$arr[3]);
			$sw=in_array($zj_arr[3],$err);
		}

		if(strpos($arr[4],',')==false){
			if($zj_arr[4]==$arr[4]){
				$gw=true;
			}else{
				$gw=false;
			}
		}elseif(strpos($arr[4],',')>-1){
			$grr=explode(',',$arr[4]);
			$gw=in_array($zj_arr[4],$grr);
		}



		if($ww && $qw && $bw && $sw && $gw){
			$x['zx']=100000;
			return $x;
		}
	}


	function qxc($zj_num,$tz_num,$tz_type){
		$zj_arr=explode(',',$zj_num);
		$x=[];
		$arr=[];
		$brr=[];
		$crr=[];
		$drr=[];
		$err=[];
		$grr=[];
		$frr=[];
		$hrr=[];
		$arr=explode('|', $tz_num);
		if(strpos($arr[0],',')==false){
			if($zj_arr[0]==$arr[0]){
				$one=true;
			}else{
				$one=false;
			}
		}elseif(strpos($arr[0],',')>-1){
			$brr=explode(',',$arr[0]);
			$one=in_array($zj_arr[0],$brr);
		}

		if(strpos($arr[1],',')==false){
			if($zj_arr[1]==$arr[1]){
				$two=true;
			}else{
				$two=false;
			}
		}elseif(strpos($arr[1],',')>-1){
			$crr=explode(',',$arr[1]);
			$two=in_array($zj_arr[1],$crr);
		}

		if(strpos($arr[2],',')==false){
			if($zj_arr[2]==$arr[2]){
				$three=true;
			}else{
				$three=false;
			}
		}elseif(strpos($arr[2],',')>-1){
			$drr=explode(',',$arr[2]);
			$bw=in_array($zj_arr[2],$drr);
		}

		if(strpos($arr[3],',')==false){
			if($zj_arr[3]==$arr[3]){
				$four=true;
			}else{
				$four=false;
			}
		}elseif(strpos($arr[3],',')>-1){
			$err=explode(',',$arr[3]);
			$four=in_array($zj_arr[3],$err);
		}

		if(strpos($arr[4],',')==false){
			if($zj_arr[4]==$arr[4]){
				$five=true;
			}else{
				$five=false;
			}
		}elseif(strpos($arr[4],',')>-1){
			$grr=explode(',',$arr[4]);
			$five=in_array($zj_arr[4],$grr);
		}

		if(strpos($arr[5],',')==false){
			if($zj_arr[5]==$arr[5]){
				$six=true;
			}else{
				$six=false;
			}
		}elseif(strpos($arr[5],',')>-1){
			$frr=explode(',',$arr[5]);
			$six=in_array($zj_arr[5],$frr);
		}

		if(strpos($arr[6],',')==false){
			if($zj_arr[6]==$arr[6]){
				$seven=true;
			}else{
				$seven=false;
			}
		}elseif(strpos($arr[6],',')>-1){
			$hrr=explode(',',$arr[6]);
			$seven=in_array($zj_arr[6],$hrr);
		}

		if($one && $two && $three && $four && $five && $six && $seven){
			$x['one']=1;
			return $x;
		}elseif(($one && $two && $three && $four && $five && $six) || ($two && $three && $four && $five && $six && $seven)){
			$x['two']=2;
			return $x;
		}elseif(($one && $two && $three && $four && $five) || ($two && $three && $four && $five && $six) || ($three && $four && $five && $six && $seven)){
			$x['three']=3;
			return $x;
		}elseif(($one && $two && $three && $four) || ($two && $three && $four && $five) || ($three && $four && $five && $six) || ($four && $five && $six && $seven)){
			$x['four']=4;
			return $x;
		}elseif(($one && $two && $three) || ($two && $three && $four) || ($three && $four && $five) || ($four && $five && $six) || ($five && $six && $seven)){
			$x['five']=5;
			return $x;
		}elseif(($one && $two) || ($two && $three) || ($three && $four) || ($four && $five) || ($five && $six) || ($six && $seven)){
			$x['six']=6;
			return $x;
		}



	}


 ?>