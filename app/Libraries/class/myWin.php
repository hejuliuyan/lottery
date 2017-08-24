<?php 


/***********中奖投注标记****************************/
/*
*$e  投注号码
*$zj 中奖号码
*
*有以下几种形式
*$e='06,15,23,22,14|03,09';//单注
*$e='06,15,23,24,13,14|03,09';//前区复式
*$e='06,15,23,24,13,14|03,09,11';//后区复式
*$e='03;12;20,28,29,31|04;03,11';//双胆
*$e='12,16,25,28,30|04;03,11';//蓝胆
*$e='04;12;20,28,29,31|03,11';//红胆
*
*$zj='06,15,23,24,13|03,09'; //中奖号码
*
*/
/*+++++++++++++++++++++++++++++++++++++++++++++*/
		//需要用到的排列组合计算	
			function su($m,$n){
					 $a=1;
					 $b=1;
					 $c=1;
				if($m==$n){
					return 1;
				}else{
					for($i=$m;$i>0;$i--){
						 $a*=$i;
					}

					for($j=$n;$j>0;$j--){
						 $b*=$j;
					}

					for($k=$n-$m;$k>0;$k--){
						$c*=$k;
					}

						$su=$b/($a*$c);
					return $su;
				}
												
			}
/*+++++++++++++++++++++++++++++++++++++++++++++*/
/*$e='06;15;23,24,13,19,21|03;09,01';//前区复式

$zj='06,15,23,24,13|03,09'; //中奖号码

echo "<pre>";
print_r(win($e,$zj));
*/
//中奖标记函数
function win($e,$zj){
				
		//中奖号码和投注号码进行处理
		$arr=explode('|', $e);
		$zjj=explode('|',$zj);
		$zjj_q=explode(',',$zjj[0]);
		$zjj_h=explode(',', $zjj[1]); 
			

	 //无胆情况
	 if(strpos($arr[0],';')==false && strpos($arr[1],';')==false){
	 			$x=[];								
	 			$brr=explode(',',$arr[0]);
	 			$crr=explode(',',$arr[1]);
	 			$first=count(array_intersect($zjj_q,$brr));
		 		$last=count(array_intersect($zjj_h,$crr));

	 			//单注
	 			if(count($brr)==5 && count($crr)==2){
		 			if($first==5 && $last==2){
		 				$x['one']=1;
		 				//echo '中了一等奖';
		 				return $x;
		 			}elseif($first==5 && $last==1){
		 				$x['two']=1;
		 				//echo '中了二等奖';
		 				return $x;
		 			}elseif(($first==5 && $last==0) || ($first==4 && $last==2)){
		 				$x['three']=1;
		 				//echo '中了三等奖';
		 				return $x;
		 			}elseif(($first==4 && $last==1) || ($first==3 && $last==2)){
		 				$x['four']=1;
		 				//echo '中了四等奖';
		 				return $x;
		 			}elseif(($first==4 && $last==0) || ($first==3 && $last==1) || ($first==2 && $last==2)){
		 				$x['five']=1;
		 				//echo '中了五等奖';
		 				return $x;
		 			}elseif(($first==3 && $last==0) || ($first==1 && $last==2) || ($first==2 && $last==1) || ($first==0 && $last==2)){
		 				$x['six']=1;
		 				//echo '中了六等奖';
		 				return $x;
		 			}

		 		//前区复式
	 			}elseif(count($brr)>5 && count($crr)==2){
		 				if($first==5 && $last==2){
			 				$one='中了一等奖';
			 				$x['one']=1;
			 				//echo $one;
			 				//echo '<br>';


		 					$e=su(4,5)*su(1,(count($brr)-5));
		 					$x['three']=$e;
		 					//echo '中了三等奖'.'('.$e.'次)';	
		 					//echo '<br>';
			 				
				 				
				 			if(count($brr)>6){
			 					$h=su(3,5)*su(2,(count($brr)-5));
			 					$x['four']=$h;
			 					//echo '中了四等奖'.'('.$h.'次)';
			 					//echo '<br>';
								
				 			}

			 				if(count($brr)>7){
			 					$r=su(2,5)*su(3,(count($brr)-5));
			 					$x['five']=$r;
			 					//echo '中了五等奖'.'('.$r.'次)';
			 					//echo '<br>';

			 				}

							if(count($brr)==9){
			 					$u=su(1,5)*su(4,(count($brr)-5));
			 					$x['six']=$u;
			 					//echo '中了六等奖'.'('.$u.'次)';
			 				}

			 				if(count($brr)>9){
			 					$u=su(1,5)*su(4,(count($brr)-5));
			 					$w=su(5,(count($brr)-5));
			 					$uw=$u+$w;

			 					$x['six']=$uw;
			 					//echo '中了六等奖'.'('.$uw.'次)';
			 				}

			 					return $x;

			 			}elseif($first==5 && $last==1){
			 				$x['two']=1;
			 				//echo '中了二等奖';
			 				//echo '<br>';

			 				$j=su(4,5)*su(1,(count($brr)-5));
			 				$x['four']=$j;
			 				//echo '中了四等奖'.'('.$j.'次)';
			 				//echo '<br>';


			 				if(count($brr)>6){
			 					$k=su(3,5)*su(2,(count($crr)-5));
			 					$x['five']=$k;
			 					//echo '中了五等奖'.'('.$k.'次)';
			 					//echo '<br>';

			 				}

			 				if(count($brr)>7){
			 					$k=su(2,5)*su(3,(count($crr)-5));
			 					$x['six']=$k;
			 					//echo '中了六等奖'.'('.$k.'次)';
			 					//echo '<br>';

			 				}

			 				return $x;

			 			}

			 			if(($first==5 && $last==0)){
			 				$x['three']=1;
			 				/*echo '中了三等奖';
			 				echo '<br>';
											*/
			 				$j=su(4,5)*su(1,(count($brr)-5));
			 				$x['five']=$j;

			 			/*	echo '中了五等奖'.'('.$j.'次)';
			 				echo '<br>';*/


			 				if(count($brr)>6){
			 					$k=su(3,5)*su(2,(count($crr)-5));
			 					$x['six']=$k;
			 					/*echo '中了六等奖'.'('.$k.'次)';
			 					echo '<br>';*/

			 				}

			 				return $x;



			 			}elseif(($first==4 && $last==2)){
			 				$c=count($brr)-4;			 			
			 				$three=su(1,$c);
			 				$x['three']=$three;

			 				
			 				/*echo '中了三等奖'.'('.$three.'次)';
			 				echo '<br>';*/

		 				
		 				    $h=su(3,4)*su(2,(count($brr)-4));
		 				    $x['four']=$h;
		 				 	/*echo '中了四等奖'.'('.$h.'次)';
		 					echo '<br>';*/

		 					if(count($brr)>6){
		 						$k=su(2,4)*su(3,(count($brr)-4));
		 						 $x['five']=$k;
		 						/*echo '中了五等奖'.'('.$k.'次)';
		 						echo '<br>';*/
		 					}

		 					if(count($brr)==8){
		 						$v=su(1,4)*su(4,(count($brr)-4));
		 						$x['six']=$v;
		 						/*echo '中了六等奖'.'('.$v.'次)';
		 						echo '<br>';*/

		 					}
		 					if(count($brr)>8){
		 						$v=su(1,4)*su(4,(count($brr)-4));
		 						$k=su(5,(count($brr)-4));
		 						$vk=$v+$k;

		 						$x['six']=$vk;
		 						/*echo '中了六等奖'.'('.$vk.'次)';
		 						echo '<br>';*/
		 					}
			 				 
			 				 return $x;

			 			}

			 			if($first==4 && $last==1){
			 				$c=count($brr)-4;			 			
			 				$four=su(1,$c);
			 				$x['four']=$four;
			 				/*echo '中了四等奖'.'('.$four.'次)';
			 				echo '<br>';*/

			 				if(count($brr)>5){
			 					$k=su(3,4)*su(2,(count($brr)-4));
			 					$x['five']=$k;
			 					/*echo '中了五等奖'.'('.$k.'次)';
			 					echo '<br>';*/

			 				}

			 				if(count($brr)>6){
			 					$v=su(2,4)*su(3,(count($brr)-4));
			 					$x['six']=$v;
			 					/*echo '中了六等奖'.'('.$v.'次)';
			 					echo '<br>';*/
			 				}
			 				 return $x;



			 			}elseif(($first==3 && $last==2)){
			 				$c=count($brr)-3;			 			
			 				$four=su(2,$c);
			 				$x['four']=$four;
			 				/*echo '中了四等奖'.'('.$four.'次)';*/

			 				if(count($brr)>5){
		 						$k=su(2,3)*su(3,(count($brr)-3));
		 						$x['five']=$k;
		 						/*echo '中了五等奖'.'('.$k.'次)';
		 						echo '<br>';*/
		 					}

		 					if(count($brr)==7){
		 						$v=su(1,3)*su(4,(count($brr)-3));
		 						$x['six']=$v;
		 						/*echo '中了六等奖'.'('.$v.'次)';
		 						echo '<br>';*/

		 					}
		 					if(count($brr)>7){
		 						$v=su(1,3)*su(4,(count($brr)-3));
		 						$k=su(5,(count($brr)-3));
		 						$vk=$v+$k;

		 						$x['six']=$vk;
		 						/*echo '中了六等奖'.'('.$vk.'次)';
		 						echo '<br>';*/
		 					}

		 					return $x;
			 			}

			 			if($first==4 && $last==0){
			 				$c=count($brr)-4;			 			
			 				$five=su(1,$c);
			 				$x['five']=$five;
			 				/*echo '中了五等奖'.'('.$five.'次)';
			 				echo '<br>';*/

			 				$d=su(3,4)*su(2,(count($brr)-4));
			 				$x['six']=$d;
			 				/*echo '中了六等奖'.'('.$d.'次)';
		 					echo '<br>';*/
		 					return $x;
			 			}elseif($first==3 && $last==1){
			 				$c=count($brr)-3;			 			
			 				$five=su(2,$c);
			 				$x['five']=$five;
			 				/*echo '中了五等奖'.'('.$five.'次)';
			 				echo '<br>';*/

			 				$d=su(2,3)*su(3,(count($brr)-3));
			 				$x['six']=$d;
			 				/*echo '中了六等奖'.'('.$d.'次)';*/
			 				return $x;
			 			}elseif($first==2 && $last==2){
			 				$c=count($brr)-2;			 			
			 				$five=su(3,$c);
			 				$x['five']=$five;
			 				/*echo '中了五等奖'.'('.$five.'次)';
			 				echo '<br>';*/

			 				if(count($brr)==6){
		 						$v=su(1,2)*su(4,(count($brr)-2));
		 						$x['six']=$v;
		 						/*echo '中了六等奖'.'('.$v.'次)';
		 						echo '<br>';*/

		 					}
		 					if(count($brr)>6){
		 						$v=su(1,2)*su(4,(count($brr)-2));
		 						$k=su(5,(count($brr)-2));
		 						$vk=$v+$k;
		 						$x['six']=$vk;
		 						/*echo '中了六等奖'.'('.$vk.'次)';
		 						echo '<br>';*/
		 					}

		 					return $x;

			 			}

			 			if($first==3 && $last==0){
			 				$c=count($brr)-3;			 			
			 				$six=su(2,$c);
			 				$x['six']=$six;
			 				//echo '中了六等奖'.'('.$six.'次)';
			 				return $x;
			 			}elseif($first==1 && $last==2){
			 				$c=count($brr)-1;			 			
			 				$six=su(4,$c);

			 				$d=su(5,(count($brr)-1));
			 				$dd=$six+$d;
			 				$x['six']=$dd;
			 				//echo '中了六等奖'.'('.$dd.'次)';

			 				return $x;
			 			}elseif($first==2 && $last==1){
			 				$c=count($brr)-2;			 			
			 				$six=su(3,$c);
			 				$x['six']=$six;
			 				//echo '中了六等奖'.'('.$six.'次)';
			 				return $x;
			 			}elseif($first==0 && $last==2){
			 				$c=count($brr)-0;			 			
			 				$six=su(5,$c);
			 				$x['six']=$six;
			 				//echo '中了六等奖'.'('.$six.'次)';
			 				return $x;
			 			}
			 			
	 			//后区复式		
				}elseif(count($brr)==5 && count($crr)>2){

		 				if($first==5 && $last==2){
		 					$x['one']=1;
			 				/*echo '中了一等奖';
			 				echo '<br>';*/
									
			 				$d=2*su(1,(count($crr)-2));
			 				$x['two']=$d;
			 				/*echo '中了二等奖'.'('.$d.'次)';
			 				echo '<br>';*/

			 				if(count($crr)>3){
			 					$e=su(2,(count($crr)-2));
			 					$x['three']=$e;
			 					/*echo '中了三等奖'.'('.$e.'次)';
			 					echo '<br>';*/
			 				}
			 				return $x;
			 			}elseif($first==5 && $last==1){
			 				$c=count($crr)-1;			 			
			 				$two=su(1,$c);
			 				$x['two']=$two;
			 				/*echo '中了二等奖'.'('.$two.'次)';
			 				echo '<br>';*/

		 					$e=su(2,(count($crr)-1));
		 					$x['three']=$e;
		 					/*echo '中了三等奖'.'('.$e.'次)';
		 					echo '<br>';*/
			 				return $x;

			 			}elseif($first==5 && $last==0){
			 				$c=count($crr)-0;			 			
			 				$three=su(2,$c);
			 				$x['three']=$three;
			 			/*	echo '中了三等奖'.'('.$three.'次)';*/
			 				return $x;
			 			}elseif($first==4 && $last==2){		
			 				$x['three']=1;	 						 				
			 				/*echo '中了三等奖';
			 				echo '<br>';*/

			 				$c=2*su(1,(count($crr)-2));
			 				$x['four']=$c;
			 				/*echo '中了四等奖'.'('.$c.'次)';
			 				echo '<br>';*/

			 				if(count($crr)>3){
				 				$d=su(2,(count($crr)-2));
				 				$x['five']=$d;
			 				 	/*echo '中了五等奖'.'('.$d.'次)';
			 					echo '<br>';*/
			 				}

			 					return $x;
			 			}elseif($first==4 && $last==1){
			 				$c=count($crr)-1;			 			
			 				$four=su(1,$c);
			 				$x['four']=$four;
			 				/*echo '中了四等奖'.'('.$four.'次)';
			 				echo '<br>';*/

			 				if(count($crr)>2){
			 				 	$d=su(2,(count($crr)-1));
			 				 	$x['five']=$d;
			 				 	/*echo '中了五等奖'.'('.$d.'次)';
			 					echo '<br>';*/
			 				}
			 					return $x;
			 			}elseif($first==3 && $last==2){
			 				$x['four']=1;
			 				/*echo '中了四等奖';
			 				echo '<br>';*/

			 				$c=2*su(1,count($crr)-2);
			 				$x['five']=$c;
			 				/*echo '中了五等奖'.'('.$c.'次)';
			 				echo '<br>';*/

			 				if(count($crr)>3){
			 				 	$d=su(2,(count($crr)-2));
			 				 	$x['six']=$d;
			 				 	/*echo '中了六等奖'.'('.$d.'次)';
			 					echo '<br>';*/
			 				}
			 					return $x;
			 			}elseif($first==4 && $last==0){
			 				$c=count($crr)-0;			 			
			 				$five=su(2,$c);
			 				$x['five']=$five;
			 				/*echo '中了五等奖'.'('.$five.'次)';*/
			 				return $x;
			 			}elseif($first==3 && $last==1){
			 				$c=count($crr)-1;			 			
			 				$five=su(1,$c);
			 				$x['five']=$five;
			 			/*	echo '中了五等奖'.'('.$five.'次)';
			 				echo '<br>';*/

			 				if(count($crr)>3){
			 				 	$d=su(2,(count($crr)-2));
			 				 	$x['six']=$d;
			 				 	/*echo '中了六等奖'.'('.$d.'次)';
			 					echo '<br>';*/
			 				}

			 				return $x;
			 			}elseif($first==2 && $last==2){
			 				$x['five']=1;
			 				//echo '中了五等奖';

			 				$j=2*su(1,(count($crr)-2));
			 				$x['six']=$j;
			 				//echo '中了六等奖'.'('.$j.'次)';
			 				//echo '<br>';
			 				return $x;
			 			}elseif($first==3 && $last==0){
			 				$c=count($crr)-0;			 			
			 				$six=su(2,$c);
			 				$x['six']=$six;
			 				//echo '中了六等奖'.'('.$six.'次)';
			 				return $x;
			 			}elseif($first==1 && $last==2){
			 				$x['six']=1;
			 				//echo '中了六等奖';
			 				return $x;
			 			}elseif($first==2 && $last==1){
			 				$c=count($crr)-1;			 			
			 				$six=su(1,$c);
			 				$x['six']=$six;
			 				//echo '中了六等奖'.'('.$six.'次)';
			 				return $x;
			 			}elseif($first==0 && $last==2){
			 				$x['six']=1;
			 				//echo '中了六等奖';
			 				return $x;
			 			}
				 //双区复式			
				}elseif(count($brr)>5 && count($crr)>2){

		 				if($first==5 && $last==2){
		 					$x['one']=1;
		 					/*$one='中了一等奖';
			 				echo $one;
			 				echo '<br>';*/

			 				$c=count($crr)-2;
			 				$tt=su(1,$c)*2;
			 				$x['two']=$tt;
			 				//echo '中了二等奖'.'('.$tt.'次)';
			 				//echo '<br>';
		 				
		 					$e=su(4,5)*su(1,(count($brr)-5));
		 					$x['three']=$e;
		 					//echo '中了三等奖'.'('.$e.'次)';	
		 					//echo '<br>';
			 				
			 				if(count($crr)>3){
			 					$e=su(4,5)*su(1,(count($brr)-5));
			 					$d=count($crr)-2;
			 					$td=su(2,$d)+$e;
			 					$x['three']=$td;
			 					//echo '中了三等奖'.'('.$td.'次)';
			 					//echo '<br>';
			 				}


			 				if(count($brr)==6){
			 					$f=su(4,5)*su(1,(count($brr)-5));
			 					$g=su(1,count($crr)-2)*2;
			 					$ff=$f*$g;
			 					$x['four']=$ff;
			 					// echo '中了四等奖'.'('.$ff.'次)';
			 					// echo '<br>';
				 			}
				 				
				 			if(count($brr)>6){
			 					$f=su(4,5)*su(1,(count($brr)-5));
			 					$g=su(1,count($crr)-2)*2;
			 					$ff=$f*$g;
			 					$h=su(3,5)*su(2,(count($brr)-5))+$ff;
			 					$x['four']=$h;
			 					// echo '中了四等奖'.'('.$h.'次)';
			 					// echo '<br>';
									
				 			}

			 				if(count($brr)==7){
				 					$p=su(3,5)*su(2,(count($brr)-5));
				 					$q=2*su(1,(count($crr)-2));
				 					$pp=$p*$q;
				 					$x['five']=$pp;
				 					// echo '中了五等奖'.'('.$pp.'次)';
				 					// echo '<br>';
			 				}

			 				if(count($brr)>7 && count($crr)==3){
				 					$p=su(3,5)*su(2,(count($brr)-5));
				 					$q=2*su(1,(count($crr)-2));
				 					$pp=$p*$q;

				 					$r=su(2,5)*su(3,(count($brr)-5));
				 					$rr=$pp+$r;
				 					$x['five']=$rr;

				 					// echo '中了五等奖'.'('.$rr.'次)';
				 					// echo '<br>';

			 				}elseif(count($brr)>7 && count($crr)>3){
				 					$j=su(4,5)*su(1,(count($brr)-5));
					 				$d=count($crr)-2;
				 					$td=su(2,$d);
				 					$tdd=$j*$td;

				 					$p=su(3,5)*su(2,(count($brr)-5));
				 					$q=2*su(1,(count($crr)-2));
				 					$pp=$p*$q;

				 					$r=su(2,5)*su(3,(count($brr)-5));
				 					$rr=$pp+$r+$tdd;
				 					$x['five']=$rr;
				 					//echo '中了五等奖'.'('.$rr.'次)';
				 					//echo '<br>';

			 				}

			 				if(count($brr)>6 && count($crr)>3){
				 					$s=su(3,5)*su(2,(count($brr)-5));
				 					$ss=su(2,count($crr)-2);
				 					$sss=$s*$ss;
				 					$x['six']=$sss;
				 					//echo '中了六等奖'.'('.$sss.'次)';
			 				}elseif(count($brr)>7 && count($crr)==3){
				 					$v=su(2,5)*su(3,(count($brr)-5));
				 					$vv=2*su(1,(count($crr)-2));
				 					$vvv=$v*$vv;
				 					$x['six']=$vvv;
				 					//echo '中了六等奖'.'('.$vvv.'次)';
			 				}elseif(count($brr)>7 && count($crr)>3){
				 					$s=su(3,5)*su(2,(count($brr)-5));
				 					$ss=su(2,count($crr)-2);
				 					$sss=$s*$ss;

				 					$v=su(2,5)*su(3,(count($brr)-5));
				 					$vv=2*su(1,(count($crr)-2));
				 					$vvv=$v*$vv;

				 					$sv=$sss+$vvv;
				 					$x['six']=$sv;
				 					//echo '中了六等奖'.'('.$sv.'次)';
			 				}elseif(count($brr)>8 && count($crr)==3){
				 					$v=su(2,5)*su(3,(count($brr)-5));
				 					$vv=2*su(1,(count($crr)-2));
				 					$vvv=$v*$vv;

				 					$u=su(1,5)*su(4,(count($brr)-5));
				 					$vu=$vvv+$u;
				 					$x['six']=$vu;
				 					//echo '中了六等奖'.'('.$vu.'次)';
			 				}elseif(count($brr)>8 && count($crr)>3){
				 					$s=su(3,5)*su(2,(count($brr)-5));
				 					$ss=su(2,count($crr)-2);
				 					$sss=$s*$ss;

				 					$v=su(2,5)*su(3,(count($brr)-5));
				 					$vv=2*su(1,(count($crr)-2));
				 					$vvv=$v*$vv;

				 					$u=su(1,5)*su(4,(count($brr)-5));
				 					$vu=$vvv+$u+$sss;
				 					$x['six']=$vu;
				 					//echo '中了六等奖'.'('.$vu.'次)';
			 				}elseif(count($brr)>9 && count($crr)==3){
				 					$v=su(2,5)*su(3,(count($brr)-5));
				 					$vv=2*su(1,(count($crr)-2));
				 					$vvv=$v*$vv;

				 					$u=su(1,5)*su(4,(count($brr)-5));
				 					
				 					$w=su(5,(count($brr)-5));
				 					$ww=$vvv+$u+$w;
				 					$x['six']=$ww;
				 					//echo '中了六等奖'.'('.$ww.'次)';
			 				}elseif(count($brr)>9 && count($crr)>3){
				 					$s=su(3,5)*su(2,(count($brr)-5));
				 					$ss=su(2,count($crr)-2);
				 					$sss=$s*$ss;

				 					$v=su(2,5)*su(3,(count($brr)-5));
				 					$vv=2*su(1,(count($crr)-2));
				 					$vvv=$v*$vv;

				 					$u=su(1,5)*su(4,(count($brr)-5));
				 					
				 					$w=su(5,(count($brr)-5));
				 					$ww=$vvv+$u+$w+$sss;
				 					$x['six']=$ww;
				 					//echo '中了六等奖'.'('.$ww.'次)';
			 				}
			 					return $x;
			 				

						}elseif($first==5 && $last==1){
			 				$c=count($crr)-1;			 			
			 				$two=su(1,$c);
			 				$x['two']=$two;
			 				//echo '中了二等奖'.'('.$two.'次)';
			 				//echo '<br>';

		 					$d=count($crr)-1;
		 					$td=su(2,$d);
		 					$x['three']=$td;
		 					//echo '中了三等奖'.'('.$td.'次)';
		 					//echo '<br>';

			 				$e=su(4,5)*su(1,(count($brr)-5));
			 				$ee=su(1,(count($crr)-1));
			 				$eee=$e*$ee;
			 				$x['four']=$eee;
			 				//echo '中了四等奖'.'('.$eee.'次)';
			 				//echo '<br>';

			 				if(count($brr)==6){
								$f=su(4,5)*su(1,(count($brr)-5));
				 				$ff=su(2,(count($crr)-1));
				 				$fff=$f*$ff;
				 				$x['five']=$fff;
				 				//echo '中了五等奖'.'('.$fff.'次)';
				 				//echo '<br>';

			 				}elseif(count($brr)>6){
			 					$g=su(3,5)*su(2,(count($brr)-5));
			 					$gg=su(1,(count($crr)-1));
			 					$ggg=$g*$gg;

				 				$f=su(4,5)*su(1,(count($brr)-5));
				 				$ff=su(2,(count($crr)-1));
				 				$fff=$f*$ff;

				 				$fg=$ggg+$fff;
				 				$x['five']=$fg;
			 					//echo '中了五等奖'.'('.$fg.'次)';
			 					//echo '<br>';

			 				}

			 				if(count($brr)>6){
				 					$s=su(3,5)*su(2,(count($brr)-5));
				 					$ss=su(2,count($crr)-1);
				 					$sss=$s*$ss;
				 					$x['six']=$sss;
				 					//echo '中了六等奖'.'('.$sss.'次)';
				 					//echo '<br>';

			 				}elseif(count($brr)>7){
				 					$s=su(3,5)*su(2,(count($brr)-5));
				 					$ss=su(2,count($crr)-1);
				 					$sss=$s*$ss;

				 					$v=su(2,5)*su(3,(count($brr)-5));
				 					$vv=su(1,(count($crr)-1));
				 					$vvv=$v*$vv;

				 					$sv=$sss+$vvv;
				 					$x['six']=$sv;
				 					//echo '中了六等奖'.'('.$sv.'次)';
				 					//echo '<br>';
			 				}

			 					return $x;
				 		}elseif($first==5 && $last==0){

		 					$td=su(2,count($crr));
		 					$x['three']=$td;
		 					//echo '中了三等奖'.'('.$td.'次)';
		 					//echo '<br>';


		 					$s=su(4,5)*su(1,(count($brr)-5));
		 					$ss=su(2,count($crr));
		 					$sss=$s*$ss;
		 					$x['five']=$sss;
		 					//echo '中了五等奖'.'('.$sss.'次)';
		 					//echo '<br>';


		 					if(count($brr)>6){
		 						$v=su(3,5)*su(2,(count($brr)-5));
		 						$vv=su(2,count($crr));
		 						$vvv=$v*$vv;
		 						$x['six']=$vvv;
		 						//echo '中了六等奖'.'('.$vvv.'次)';
		 						//echo '<br>';
		 					}

		 					return $x;
				 		}elseif($first==4 && $last==2){
				 				
			 					$j=su(1,(count($brr)-4));
			 					$x['three']=$j;
			 					//echo '中了三等奖'.'('.$j.'次)'; 
			 					//echo '<br>';

			 				if(count($brr)==6){
				 					$f=su(1,(count($brr)-4));
				 					$g=su(1,count($crr)-2)*2;
				 					$ff=$f*$g;
				 					$x['four']=$ff;
				 					//echo '中了四等奖'.'('.$ff.'次)';
				 					//echo '<br>';
				 				}
				 				
				 			if(count($brr)>6){
				 					$f=su(1,(count($brr)-4));
				 					$g=su(1,count($crr)-2)*2;
				 					$ff=$f*$g;
				 					$h=su(3,4)*su(2,(count($brr)-4))+$ff;
				 					$x['four']=$h;
				 					//echo '中了四等奖'.'('.$h.'次)';
				 					//echo '<br>';
									
				 				}



							if(count($brr)==6){
				 					$p=su(3,4)*su(2,(count($brr)-4));
				 					$q=2*su(1,(count($crr)-2));
				 					$pp=$p*$q;
				 					$x['five']=$pp;
				 					//echo '中了五等奖'.'('.$pp.'次)';
				 					//echo '<br>';
			 				}

			 				if(count($brr)>6 && count($crr)==3){
				 					$p=su(3,4)*su(2,(count($brr)-4));
				 					$q=2*su(1,(count($crr)-2));
				 					$pp=$p*$q;

				 					$r=su(2,4)*su(3,(count($brr)-4));
				 					$rr=$pp+$r;
				 					$x['five']=$rr;
				 					//echo '中了五等奖'.'('.$rr.'次)';
				 					//echo '<br>';

			 				}elseif(count($brr)>6 && count($crr)>3){
					 				$d=su(1,(count($brr)-4));
				 					$dd=su(2,(count($crr)-2));
				 					$ddd=$d*$dd;

				 					$p=su(3,4)*su(2,(count($brr)-4));
				 					$q=2*su(1,(count($crr)-2));
				 					$pp=$p*$q;

				 					$r=su(2,4)*su(3,(count($brr)-4));
				 					$rr=$pp+$r+$tdd;
				 					$x['five']=$rr;
				 					//echo '中了五等奖'.'('.$rr.'次)';
				 					//echo '<br>';

			 				}

			 				if(count($brr)==6 && count($crr)>3){
			 					$n=su(3,4)*su(2,(count($brr)-4));
			 					$nn=su(2,(count($crr)-2));
			 					$nnn=$n*$nn;
			 					$x['six']=$nnn;
			 					//echo '中了六等奖'.'('.$nnn.'次)';

			 				}

			 				if(count($brr)>6 && count($crr)==3){
		 						$v=su(2,4)*su(3,(count($brr)-4));
			 					$vv=2*su(1,(count($crr)-2));
			 					$vvv=$v*$vv;
			 					$x['six']=$vvv;
			 					//echo '中了六等奖'.'('.$vvv.'次)';
			 					//echo '<br>';
			 				}
	

			 				if(count($brr)>6 && count($crr)>3){
			 					$v=su(2,4)*su(3,(count($brr)-4));
			 					$vv=2*su(1,(count($crr)-2));
			 					$vvv=$v*$vv;

			 					$n=su(3,4)*su(2,(count($brr)-4));
			 					$nn=su(2,(count($crr)-2));
			 					$nnn=$n*$nn;

			 					$vn=$vvv+$nnn;
			 					$x['six']=$vn;
			 					//echo '中了六等奖'.'('.$vn.'次)';
			 					//echo '<br>';
			 				
			 				}elseif(count($brr)>7 && count($crr)>3){
			 					$v=su(2,4)*su(3,(count($brr)-4));
			 					$vv=2*su(1,(count($crr)-2));
			 					$vvv=$v*$vv;

			 					$n=su(3,4)*su(2,(count($brr)-4));
			 					$nn=su(2,(count($crr)-2));
			 					$nnn=$n*$nn;

			 					$u=su(1,4)*su(4,(count($brr)-4));
			 					$vu=$vvv+$u+$nnn;
			 					$x['six']=$vn;
			 					//echo '中了六等奖'.'('.$vu.'次)';
			 					//echo '<br>';
			 				}elseif(count($brr)>8 && count($crr)>3){
			 					$v=su(2,4)*su(3,(count($brr)-4));
			 					$vv=2*su(1,(count($crr)-2));
			 					$vvv=$v*$vv;

			 					$n=su(3,4)*su(2,(count($brr)-4));
			 					$nn=su(2,(count($crr)-2));
			 					$nnn=$n*$nn;

			 					$u=su(1,4)*su(4,(count($brr)-4));
			 					
			 					$w=su(5,(count($brr)-4));
			 					$ww=$vvv+$u+$w+$nnn;
			 					$x['six']=$ww;
			 					//echo '中了六等奖'.'('.$ww.'次)';
			 					//echo '<br>';
			 				}
			 					return $x;

				 		}elseif($first==4 && $last==1){
			 				$k=su(1,(count($brr)-4));
			 				$kk=su(1,(count($crr)-1));
			 				$kkk=$k*$kk;
			 				$x['four']=$kkk;
			 				//echo '中了四等奖'.'('.$kkk.'次)';
			 				//echo '<br>'; 

			 				if(count($brr)>5){
			 					$p=su(3,4)*su(2,(count($brr)-4));
			 					$q=su(1,(count($crr)-1));
			 					$pp=$p*$q;
			 					$x['five']=$pp;
			 					//echo '中了五等奖'.'('.$pp.'次)';
			 					//echo '<br>';
		 					}elseif(count($brr)>5 && count($crr)>3){
				 				$d=su(1,(count($brr)-4));
			 					$dd=su(2,(count($crr)-1));
			 					$ddd=$d*$dd;

			 					$p=su(3,4)*su(2,(count($brr)-4));
			 					$q=su(1,(count($crr)-1));
			 					$pp=$p*$q;

			 					$rr=$pp+$ddd;
			 					$x['five']=$rr;
			 					//echo '中了五等奖'.'('.$rr.'次)';
			 					//echo '<br>';

			 				}

			 				if(count($brr)>5 && count($crr)>3){
				 					$s=su(3,4)*su(2,(count($brr)-4));
				 					$ss=su(2,count($crr)-1);
				 					$sss=$s*$ss;
				 					$x['six']=$sss;
				 					//echo '中了六等奖'.'('.$sss.'次)';
			 				}elseif(count($brr)>6 && count($crr)==3){
				 					$v=su(2,4)*su(3,(count($brr)-4));
				 					$vv=su(1,(count($crr)-1));
				 					$vvv=$v*$vv;
				 					$x['six']=$vvv;
				 					//echo '中了六等奖'.'('.$vvv.'次)';
			 				}elseif(count($brr)>6 && count($crr)>3){
				 					$s=su(3,4)*su(2,(count($brr)-4));
				 					$ss=su(2,count($crr)-1);
				 					$sss=$s*$ss;

									$v=su(2,4)*su(3,(count($brr)-4));
				 					$vv=su(1,(count($crr)-1));
				 					$vvv=$v*$vv;

				 					$sv=$sss+$vvv;
				 					$x['six']=$sv;
				 					//echo '中了六等奖'.'('.$sv.'次)';
			 				}
			 					return $x;

				 		}elseif($first==3 && $last==2){
			 				$j=su(2,(count($brr)-3));
			 				$x['four']=$j;
			 				//echo '中了四等奖'.'('.$j.'次)';

				 			if(count($brr)>5){
			 					$p=su(2,(count($brr)-3));
		 						$q=2*su(1,(count($crr)-2));
		 						$pp=$p*$q;

			 					$r=su(2,3)*su(3,(count($brr)-3));
			 					$rr=$pp+$r;
			 					$x['five']=$rr;
			 					//echo '中了五等奖'.'('.$rr.'次)';
			 					//echo '<br>';
				 			}

							if(count($brr)>5 && count($crr)==3){
				 					$v=su(2,3)*su(3,(count($brr)-3));
				 					$vv=2*su(1,(count($crr)-2));
				 					$vvv=$v*$vv;
				 					$x['six']=$vvv;
				 					//echo '中了六等奖'.'('.$vvv.'次)';
			 				}elseif(count($brr)>5 && count($crr)>3){
				 					$s=su(2,(count($brr)-3));
				 					$ss=su(2,count($crr)-2);
				 					$sss=$s*$ss;

				 					$v=su(2,3)*su(3,(count($brr)-3));
				 					$vv=2*su(1,(count($crr)-2));
				 					$vvv=$v*$vv;

				 					$sv=$sss+$vvv;
				 					$x['six']=$sv;
				 					//echo '中了六等奖'.'('.$sv.'次)';
			 				}elseif(count($brr)>6 && count($crr)==3){
				 					$v=su(2,3)*su(3,(count($brr)-3));
				 					$vv=2*su(1,(count($crr)-2));
				 					$vvv=$v*$vv;

				 					$u=su(1,3)*su(4,(count($brr)-3));
				 					$vu=$vvv+$u;
				 					$x['six']=$vu;
				 					//echo '中了六等奖'.'('.$vu.'次)';
			 				}elseif(count($brr)>6 && count($crr)>3){
				 					$s=su(2,(count($brr)-3));
				 					$ss=su(2,count($crr)-2);
				 					$sss=$s*$ss;

				 					$v=su(2,3)*su(3,(count($brr)-3));
				 					$vv=2*su(1,(count($crr)-2));
				 					$vvv=$v*$vv;

				 					$u=su(1,3)*su(4,(count($brr)-3));
				 					$vu=$vvv+$u+$sss;
				 					$x['six']=$vu;
				 					//echo '中了六等奖'.'('.$vu.'次)';
			 				}elseif(count($brr)>7 && count($crr)==3){
				 					$v=su(2,3)*su(3,(count($brr)-3));
				 					$vv=2*su(1,(count($crr)-2));
				 					$vvv=$v*$vv;

				 					$u=su(1,3)*su(4,(count($brr)-3));
				 					
				 					$w=su(5,(count($brr)-3));
				 					$ww=$vvv+$u+$w;
				 					$x['six']=$ww;
				 					//echo '中了六等奖'.'('.$ww.'次)';
			 				}elseif(count($brr)>7 && count($crr)>3){
				 					$s=su(2,(count($brr)-3));
				 					$ss=su(2,count($crr)-2);
				 					$sss=$s*$ss;

				 					$v=su(2,3)*su(3,(count($brr)-3));
				 					$vv=2*su(1,(count($crr)-2));
				 					$vvv=$v*$vv;

				 					$u=su(1,3)*su(4,(count($brr)-3));
				 					
				 					$w=su(5,(count($brr)-3));
				 					$ww=$vvv+$u+$w+$sss;
				 					$x['six']=$ww;
				 					//echo '中了六等奖'.'('.$ww.'次)';
			 				}

			 					return $x;

				 		}elseif($first==4 && $last==0){
			 				$j=su(1,(count($brr)-4));
			 				$jj=su(2,count($crr));
			 				$jjj=$j*$jj;
			 				$x['five']=$jjj;
			 				//echo '中了五等奖'.'('.$jjj.'次)';

			 				$k=su(3,4)*su(2,(count($brr)-4));
			 				$kk=su(2,count($crr));
			 				$kkk=$k*$kk;
			 				$x['six']=$kkk;
			 				//echo '中了六等奖'.'('.$kkk.'次)';
				 		}elseif($first==3 && $last==1){
			 				$j=su(2,(count($brr)-3));
			 				$jj=su(1,(count($crr)-1));
			 				$jjj=$j*$jj;
			 				$x['five']=$jjj;
			 				//echo '中了五等奖'.'('.$jjj.'次)';

			 				if(count($brr)>5 && count($crr)==3){
			 					$v=su(2,3)*su(3,(count($brr)-3));
			 					$vv=su(1,(count($crr)-1));
			 					$vvv=$v*$vv;
			 					$x['six']=$vvv;
			 					//echo '中了六等奖'.'('.$vvv.'次)';
			 				}elseif(count($brr)>5 && count($crr)>3){
			 					$s=su(2,(count($brr)-3));
			 					$ss=su(2,count($crr)-1);
			 					$sss=$s*$ss;

			 					$v=su(2,3)*su(3,(count($brr)-3));
			 					$vv=su(1,(count($crr)-1));
			 					$vvv=$v*$vv;

			 					$sv=$sss+$vvv;
			 					$x['six']=$sv;
			 					//echo '中了六等奖'.'('.$sv.'次)';
			 				}
			 					return $x;
				 		}elseif($first==2 && $last==2){
			 				$j=su(3,(count($brr)-2));
			 				$x['five']=$j;
			 				//echo '中了五等奖'.'('.$j.'次)';

							if(count($brr)>5){
			 					$v=su(3,(count($brr)-2));
			 					$vv=2*su(1,(count($crr)-2));
			 					$vvv=$v*$vv;

			 					$u=2*su(4,(count($brr)-2));
			 					$vu=$vvv+$u;
			 					$x['six']=$vu;
			 					//echo '中了六等奖'.'('.$vu.'次)';
			 				}elseif(count($brr)>6){
			 					$v=su(3,(count($brr)-2));
			 					$vv=2*su(1,(count($crr)-2));
			 					$vvv=$v*$vv;

			 					$u=2*su(4,(count($brr)-2));
			 					
			 					$w=su(5,(count($brr)-2));
			 					$ww=$vvv+$u+$w;
			 					$x['six']=$ww;
			 					//echo '中了六等奖'.'('.$ww.'次)';
			 				}
			 					return $x;
				 		}elseif($first==3 && $last==0){
			 				$j=su(2,(count($brr)-3));
			 				$jj=su(2,(count($crr)));
			 				$jjj=$j*$jj;
			 				$x['six']=$jjj;
			 				//echo '中了六等奖'.'('.$jjj.'次)';
			 				return $x;
				 		}elseif($first==1 && $last==2){
			 				$k=su(4,(count($brr)-1));
			 				$j=su(5,(count($brr)-1));
			 				$kj=$k+$j;
			 				$x['six']=$kj;
			 				//echo '中了六等奖'.'('.$kj.'次)';
			 				return $x;

				 		}elseif($first==2 && $last==1){
			 				$h=su(3,(count($brr)-2));
			 				$hh=su(1,(count($crr)-1));
			 				$hhh=$h*$hh;
			 				$x['six']=$hhh;
			 				//echo '中了六等奖'.'('.$hhh.'次)';
			 				return $x;
				 		}elseif($first==0 && $last==2){
			 				$v=su(5,count($brr));
			 				$x['six']=$v;
			 				//echo '中了六等奖'.'('.$v.'次)';
			 				return $x;
				 		}
					}

				}


	//有红胆无蓝胆	
		if(strpos($arr[0],';')>-1 && strpos($arr[1],';')==false){
			$x=[];
			$brr=explode(';', $arr[0]);
			$grr=explode(',', $arr[1]);
			$crr=array_pop($brr);
			$dan=count($brr);
			$drr=explode(',', $crr);
			$err=array_merge($brr,$drr);
			$first=count(array_intersect($zjj_q,$err));
		 	$last=count(array_intersect($zjj_h,$grr));

		//一个红胆
			if($dan==1){
				if($first==5 && $last==2){
					if(count($grr)==2){
						$x['one']=1;

						$cc=su(3,4)*su(1,(count($err)-5));
						$x['three']=$cc;

						if(count($err)>6){
							$dd=su(2,4)*su(2,(count($err)-5));
							$x['four']=$dd;
						}

						if(count($err)>7){
							$aa=su(1,4)*su(3,(count($err)-5));
							$x['five']=$dd;
						}

						if(count($err)>8){
							$bb=su(4,(count($err)-5));
							$x['six']=$bb;
						}
						
					}
					$x['one']=1;
					//echo '中了一等奖';
					//echo '<br>';

					if(count($grr)>2){
						$j=2*su(1,(count($grr)-2));
						$x['two']=$j;
						//echo '中了二等奖'.'('.$j.'次)';
						//echo '<br>';
					}

				
					if(count($grr)==3){
						$e=su(3,4)*su(1,(count($err)-5));
						$x['three']=$e;
						//echo '中了三等奖'.'('.$e.'次)';	
						//echo '<br>';

					}

					if(count($grr)>3){
						$e=su(3,4)*su(1,(count($err)-5));
						$d=count($grr)-2;
						$td=su(2,$d)+$e;
						$x['three']=$td;
						// echo '中了三等奖'.'('.$td.'次)';
						// echo '<br>';

					}

					if(count($err)==6 && count($grr)>2){
						$f=su(3,4)*su(1,(count($err)-5));
						$g=su(1,count($grr)-2)*2;
						$ff=$f*$g;
						$x['four']=$ff;
						//echo '中了四等奖'.'('.$ff.'次)';
						//echo '<br>';
					}
							
					if(count($err)>6 && count($grr)>2 ){
						$f=su(3,4)*su(1,(count($err)-5));
						$g=su(1,count($grr)-2)*2;
						$ff=$f*$g;
						$h=su(2,4)*su(2,(count($err)-5))+$ff;
						$x['four']=$h;
						// echo '中了四等奖'.'('.$h.'次)';
						// echo '<br>';
					}

					if(count($err)==7 && count($grr)>2){
						$p=su(2,4)*su(2,(count($err)-5));
						$q=2*su(1,(count($grr)-2));
						$pp=$p*$q;
						$x['five']=$pp;
						// echo '中了五等奖'.'('.$pp.'次)';
						// echo '<br>';
					}

					if(count($err)>7 && count($grr)==3){
						$p=su(2,4)*su(2,(count($err)-5));
						$q=2*su(1,(count($grr)-2));
						$pp=$p*$q;

						$r=su(1,4)*su(3,(count($err)-5));
						$rr=$pp+$r;
						$x['five']=$rr;
						// echo '中了五等奖'.'('.$rr.'次)';
						// echo '<br>';

					}elseif(count($err)>7 && count($grr)>3){
						$j=su(3,4)*su(1,(count($err)-5));
						$d=count($grr)-2;
						$td=su(2,$d);
						$tdd=$j*$td;

						$p=su(2,4)*su(2,(count($err)-5));
						$q=2*su(1,(count($grr)-2));
						$pp=$p*$q;


						$r=su(1,4)*su(3,(count($err)-5));
						$rr=$pp+$r+$tdd;
						$x['five']=$rr;
						// echo '中了五等奖'.'('.$rr.'次)';
						// echo '<br>';

					}

	 				if(count($err)>6 && count($grr)>3){
	 					$s=su(2,4)*su(2,(count($err)-5));
	 					$ss=su(2,count($grr)-2);
	 					$sss=$s*$ss;
	 					$x['six']=$sss;
	 					//echo '中了六等奖'.'('.$sss.'次)';
	 				}elseif(count($err)>7 && count($grr)==3){
	 					$v=su(1,4)*su(3,(count($err)-5));
	 					$vv=2*su(1,(count($grr)-2));
	 					$vvv=$v*$vv;
	 					$x['six']=$vvv;
	 					//echo '中了六等奖'.'('.$vvv.'次)';
	 				}elseif(count($err)>7 && count($grr)>3){
	 					$s=su(2,4)*su(2,(count($err)-5));
	 					$ss=su(2,count($grr)-2);
	 					$sss=$s*$ss;

	 					$v=su(1,4)*su(3,(count($err)-5));
	 					$vv=2*su(1,(count($grr)-2));
	 					$vvv=$v*$vv;

	 					$sv=$sss+$vvv;
	 					$x['six']=$sv;
	 					//echo '中了六等奖'.'('.$sv.'次)';
	 				}elseif(count($err)>8 && count($grr)==3){
		 					
	 					$v=su(1,4)*su(3,(count($err)-5));
	 					$vv=2*su(1,(count($grr)-2));
	 					$vvv=$v*$vv;

	 					$u=su(4,(count($err)-5));
	 					$vu=$vvv+$u;
	 					$x['six']=$vu;
	 					//echo '中了六等奖'.'('.$vu.'次)';
	 				}elseif(count($brr)>8 && count($crr)>3){
	 					$s=su(2,4)*su(2,(count($err)-5));
	 					$ss=su(2,count($grr)-2);
	 					$sss=$s*$ss;

	 					$v=su(1,4)*su(3,(count($err)-5));
	 					$vv=2*su(1,(count($grr)-2));
	 					$vvv=$v*$vv;

	 					$u=su(4,(count($grr)-5));
	 					$vu=$vvv+$u+$sss;
	 					$x['six']=$vu;
	 					//echo '中了六等奖'.'('.$vu.'次)';
	 				}
	 					return $x;

			 	}elseif($first==5 && $last==1){
		 			if(count($grr)==2){
		 				$x['two']=1;
		 				// echo '中了二等奖';
		 				// echo '<br>';

		 				$v=su(3,4)*su(1,(count($err)-5));
		 				$x['four']=$v;
		 				//echo '中了四等奖'.'('.$v.'次)';

		 				if(count($err)>6){
		 					$k=su(2,4)*su(2,(count($err)-5));
		 					$x['five']=$k;
		 					//echo '中了五等奖'.'('.$v.'次)';
		 				}

		 				if(count($err)>7){
		 					$c=su(1,4)*su(3,(count($err)-5));
		 					$x['six']=$c;
		 					//echo '中了六等奖'.'('.$c.'次)';
		 				}
		 			}

		 			if(count($grr)>2){
		 				$j=su(1,(count($grr)-1));
		 				$x['two']=$j;
		 				//echo '中了二等奖'.'('.$j.'次)';

	 					$d=count($grr)-1;
	 					$td=su(2,$d);
	 					$x['three']=$td;
	 					// echo '中了三等奖'.'('.$td.'次)';
	 					// echo '<br>';

		 				$e=su(3,4)*su(1,(count($err)-5));
		 				$ee=su(1,(count($grr)-1));
		 				$eee=$e*$ee;
		 				$x['four']=$eee;
		 				// echo '中了四等奖'.'('.$eee.'次)';
		 				// echo '<br>';

		 				if(count($err)==6 && count($grr)>3){
							$f=su(3,4)*su(1,(count($err)-5));
			 				$ff=su(2,(count($grr)-1));
			 				$fff=$f*$ff;
			 				$x['five']=$fff;
			 				// echo '中了五等奖'.'('.$fff.'次)';
			 				// echo '<br>';

		 				}elseif(count($err)>6 && count($grr)>3){
		 					$g=su(2,4)*su(2,(count($err)-5));
		 					$gg=su(1,(count($grr)-1));
		 					$ggg=$g*$gg;

			 				$f=su(3,4)*su(1,(count($err)-5));
			 				$ff=su(2,(count($grr)-1));
			 				$fff=$f*$ff;

			 				$fg=$ggg+$fff;
			 				$x['five']=$fg;
		 					// echo '中了五等奖'.'('.$fg.'次)';
		 					// echo '<br>';

		 				}

		 				if(count($err)>6 && count($grr)>2){
		 					$s=su(2,4)*su(2,(count($err)-5));
		 					$ss=su(2,count($grr)-1);
		 					$sss=$s*$ss;
		 					$x['six']=$sss;
		 					// echo '中了六等奖'.'('.$sss.'次)';
		 					// echo '<br>';

		 				}elseif(count($err)>7 && count($grr)>2){
		 					$s=su(2,4)*su(2,(count($err)-5));
		 					$ss=su(2,count($grr)-1);
		 					$sss=$s*$ss;

		 					$v=su(1,4)*su(3,(count($err)-5));
		 					$vv=su(1,(count($grr)-1));
		 					$vvv=$v*$vv;

		 					$sv=$sss+$vvv;
		 					$x['six']=$sv;
		 					// echo '中了六等奖'.'('.$sv.'次)';
		 					// echo '<br>';

		 				}

		 			}
		 					return $x;
			 	}elseif($first==5 && $last==0){
		 			if(count($grr)==2){
		 				$x['three']=1;
		 				//echo '中了三等奖';
		 				$dd=su(3,4)*su(1,(count($err)-5));
		 				$x['five']=$dd;

		 				if(count($err)>6){
		 					$cc=su(2,4)*su(2,(count($err)-5));
		 					$x['six']=$cc;
		 				}
		 			}
		 			if(count($grr)>2){
		 				$td=su(2,count($grr));
		 				$x['three']=$td;
	 					// echo '中了三等奖'.'('.$td.'次)';
	 					// echo '<br>';

	 					$s=su(3,4)*su(1,(count($err)-5));
	 					$ss=su(2,count($grr));
	 					$sss=$s*$ss;
	 					$x['five']=$sss;
	 					// echo '中了五等奖'.'('.$sss.'次)';
	 					// echo '<br>';


	 					if(count($err)>6){
	 						$v=su(2,4)*su(2,(count($err)-5));
	 						$vv=su(2,count($grr));
	 						$vvv=$v*$vv;
	 						$x['six']=$vvv;
	 						// echo '中了六等奖'.'('.$vvv.'次)';
	 						// echo '<br>';
	 					}

		 			}
		 					return $x;

			 	}elseif($first==4 && $last==2){
		 			if(count($grr)==2){
		 				$j=su(1,(count($err)-4));
		 				$x['three']=$j;
	 					// echo '中了三等奖'.'('.$j.'次)'; 
	 					// echo '<br>';
	 				
	 				    $h=su(2,3)*su(2,(count($err)-4));
	 				    $x['four']=$h;
	 				 	// echo '中了四等奖'.'('.$h.'次)';
	 					// echo '<br>';

	 					if(count($err)>6){
	 						$k=su(1,3)*su(3,(count($err)-4));
	 						$x['five']=$k;
	 						// echo '中了五等奖'.'('.$k.'次)';
	 						// echo '<br>';
	 					}

	 					if(count($err)>7){
	 						$v=su(4,(count($err)-4));
	 						$x['six']=$v;
	 						// echo '中了六等奖'.'('.$v.'次)';
	 						// echo '<br>';

	 					}
		 			}

		 			if(count($grr)>2){
		 				$j=su(1,(count($err)-4));
		 				$x['three']=$j;
	 					// echo '中了三等奖'.'('.$j.'次)'; 
	 					// echo '<br>';
			 				
			 			if(count($err)>5){
		 					$f=su(1,(count($err)-4));
		 					$g=su(1,count($grr)-2)*2;
		 					$ff=$f*$g;
		 					$h=su(2,3)*su(2,(count($err)-4))+$ff;
		 					$x['four']=$h;
		 					// echo '中了四等奖'.'('.$h.'次)';
		 					// echo '<br>';
		 				}

						if(count($err)==6){
		 					$p=su(2,3)*su(2,(count($err)-4));
		 					$q=2*su(1,(count($grr)-2));
		 					$pp=$p*$q;
		 					$x['five']=$pp;
		 					// echo '中了五等奖'.'('.$pp.'次)';
		 					// echo '<br>';
		 				}

		 				if(count($err)>6){
		 					$p=su(2,3)*su(2,(count($err)-4));
		 					$q=2*su(1,(count($grr)-2));
		 					$pp=$p*$q;

		 					$r=su(1,3)*su(3,(count($err)-4));
		 					$rr=$pp+$r;

		 					$x['five']=$rr;
		 					// echo '中了五等奖'.'('.$rr.'次)';
		 					// echo '<br>';

		 				}elseif(count($err)>6 && count($grr)>3){
			 				$d=su(1,(count($err)-4));
		 					$dd=su(2,(count($grr)-2));
		 					$ddd=$d*$dd;

		 					$p=su(2,3)*su(2,(count($err)-4));
		 					$q=2*su(1,(count($grr)-2));
		 					$pp=$p*$q;

		 					$r=su(1,3)*su(3,(count($err)-4));
		 					$rr=$pp+$r+$ddd;
		 					$x['five']=$rr;
		 					// echo '中了五等奖'.'('.$rr.'次)';
		 					// echo '<br>';

		 				}

		 				if(count($err)==6 && count($grr)>3){
		 					$n=su(2,3)*su(2,(count($err)-4));
		 					$nn=su(2,(count($grr)-2));
		 					$nnn=$n*$nn;
		 					$x['six']=$nnn;
		 					// echo '中了六等奖'.'('.$nnn.'次)';
		 				}

		 				if(count($err)>6 && count($grr)==3){
	 						$v=su(1,3)*su(3,(count($err)-4));
		 					$vv=2*su(1,(count($grr)-2));
		 					$vvv=$v*$vv;
		 					$x['six']=$vvv;

		 					// echo '中了六等奖'.'('.$vvv.'次)';
		 					// echo '<br>';
		 				}

		 				if(count($err)>6 && count($grr)>3){
		 					$v=su(1,3)*su(3,(count($err)-4));
		 					$vv=2*su(1,(count($grr)-2));
		 					$vvv=$v*$vv;

		 					$n=su(2,3)*su(2,(count($err)-4));
		 					$nn=su(2,(count($grr)-2));
		 					$nnn=$n*$nn;

		 					$vn=$vvv+$nnn;
		 					$x['six']=$vn;
		 					// echo '中了六等奖'.'('.$vn.'次)';
		 					// echo '<br>';
		 				
		 				}elseif(count($err)>7 && count($grr)>3){
		 					$v=su(1,3)*su(3,(count($err)-4));
		 					$vv=2*su(1,(count($grr)-2));
		 					$vvv=$v*$vv;

		 					$n=su(2,3)*su(2,(count($err)-4));
		 					$nn=su(2,(count($grr)-2));
		 					$nnn=$n*$nn;

		 					$u=su(4,(count($err)-4));
		 					$vu=$vvv+$u+$nnn;
		 					$x['six']=$vu;
		 					// echo '中了六等奖'.'('.$vu.'次)';
		 					// echo '<br>';
		 				}
		 			}
				 			return $x;

			 	}elseif($first==4 && $last==1){
		 			if(count($grr)==2){
		 				$c=count($err)-4;			 			
		 				$four=su(1,$c);
		 				$x['four']=$four;
		 				// echo '中了四等奖'.'('.$four.'次)';
		 				// echo '<br>';
		 				
	 					$k=su(2,3)*su(2,(count($err)-4));
	 					$x['five']=$k;
	 					// echo '中了五等奖'.'('.$k.'次)';
	 					// echo '<br>';

		 				if(count($err)>6){
		 					$v=su(1,3)*su(3,(count($err)-4));
		 					$x['six']=$v;
		 					// echo '中了六等奖'.'('.$v.'次)';
		 					// echo '<br>';
		 				}
		 			}


		 			if(count($grr)>2){
		 				$k=su(1,(count($err)-4));
		 				$kk=su(1,(count($grr)-1));
		 				$kkk=$k*$kk;
		 				$x['four']=$kk;
		 				// echo '中了四等奖'.'('.$kkk.'次)';
		 				// echo '<br>'; 

						if(count($err)>5){
			 				$d=su(1,(count($err)-4));
		 					$dd=su(2,(count($grr)-1));
		 					$ddd=$d*$dd;

		 					$p=su(2,3)*su(2,(count($err)-4));
		 					$q=su(1,(count($grr)-1));
		 					$pp=$p*$q;

		 					$rr=$pp+$ddd;
		 					$x['five']=$rr;
		 					// echo '中了五等奖'.'('.$rr.'次)';
		 					// echo '<br>';

		 				}

		 				if(count($err)>5){
		 					$s=su(2,3)*su(2,(count($err)-4));
		 					$ss=su(2,count($grr)-1);
		 					$sss=$s*$ss;
		 					$x['six']=$sss;
		 					//echo '中了六等奖'.'('.$sss.'次)';
		 				}elseif(count($err)>6 && count($grr)==3){
		 					$v=su(1,3)*su(3,(count($err)-4));
		 					$vv=su(1,(count($grr)-1));
		 					$vvv=$v*$vv;
		 					$x['six']=$vvv;
		 					// echo '中了六等奖'.'('.$vvv.'次)';
		 				}elseif(count($err)>6 && count($grr)>3){
		 					$s=su(2,3)*su(2,(count($err)-4));
		 					$ss=su(2,count($grr)-1);
		 					$sss=$s*$ss;

							$v=su(1,3)*su(3,(count($err)-4));
		 					$vv=su(1,(count($grr)-1));
		 					$vvv=$v*$vv;

		 					$sv=$sss+$vvv;
		 					$x['six']=$sv;
		 					// echo '中了六等奖'.'('.$sv.'次)';
		 				}

		 			}

		 				return $x;
			 	}elseif($first==3 && $last==2){
			 		if(count($grr)==2){
			 			$c=count($err)-3;			 			
		 				$four=su(2,$c);
		 				$x['four']=$four;
		 				// echo '中了四等奖'.'('.$four.'次)';

 						$k=su(1,2)*su(3,(count($err)-3));
 						$x['five']=$k;
 						// echo '中了五等奖'.'('.$k.'次)';
 						// echo '<br>';
	 					
	 					if(count($err)>6){
	 						$v=su(4,(count($err)-3));
	 						$x['six']=$v;
	 						// echo '中了六等奖'.'('.$v.'次)';
	 						// echo '<br>';

	 					}
		 					
			 		}


			 		if(count($grr)>2){
			 			$j=su(2,(count($err)-3));
			 			$x['four']=$j;
		 				// echo '中了四等奖'.'('.$j.'次)';

		 				if(count($err)==6){
		 					$p=su(2,(count($err)-3));
		 					$q=2*su(1,(count($grr)-2));
		 					$pp=$p*$q;
		 					$x['five']=$pp;
		 					// echo '中了五等奖'.'('.$pp.'次)';
		 					// echo '<br>'; 
		 				}elseif(count($err)>6){
		 					$p=su(2,(count($err)-3));
		 					$q=2*su(1,(count($grr)-2));
		 					$pp=$p*$q;

		 					$r=su(1,2)*su(3,(count($err)-3));
		 					$rr=$pp+$r;
		 					$x['five']=$rr;
		 					// echo '中了五等奖'.'('.$rr.'次)';
		 					// echo '<br>';

		 				}

		 				if(count($err)==6 && count($grr)>3){
		 					$s=su(2,(count($err)-3));
		 					$ss=su(2,count($grr)-2);
		 					$sss=$s*$ss;

		 					$v=su(1,2)*su(3,(count($err)-3));
		 					$vv=2*su(1,(count($grr)-2));
		 					$vvv=$v*$vv;

		 					$sv=$sss+$vvv;
		 					$x['six']=$sv;
		 					// echo '中了六等奖'.'('.$sv.'次)';
		 				}elseif(count($err)==6 && count($grr)==3){
		 					$v=su(1,2)*su(3,(count($err)-3));
		 					$vv=2*su(1,(count($grr)-2));
		 					$vvv=$v*$vv;
		 					$x['six']=$vvv;
		 					// echo '中了六等奖'.'('.$vvv.'次)';
		 				}elseif(count($err)>6 && count($grr)>3){
		 					$s=su(2,(count($err)-3));
		 					$ss=su(2,count($grr)-2);
		 					$sss=$s*$ss;

		 					$v=su(1,2)*su(3,(count($err)-3));
		 					$vv=2*su(1,(count($grr)-2));
		 					$vvv=$v*$vv;

		 					$u=su(4,(count($err)-3));

		 					$sv=$sss+$vvv+$u;
		 					$x['six']=$sv;
		 					// echo '中了六等奖'.'('.$sv.'次)';
		 				}elseif(count($err)>6 && count($grr)==3){
		 					$v=su(2,3)*su(3,(count($err)-3));
		 					$vv=2*su(1,(count($grr)-2));
		 					$vvv=$v*$vv;

		 					$u=su(4,(count($err)-3));
		 					$vu=$vvv+$u;
		 					$x['six']=$vu;
		 					// echo '中了六等奖'.'('.$vu.'次)';
		 				}

			 		}
			 			return $x;
				}elseif($first==4 && $last==0){
					if(count($grr)==2){
						$c=count($err)-4;			 			
						$five=su(1,$c);
						$x['five']=$five;
						// echo '中了五等奖'.'('.$five.'次)';
						// echo '<br>';

						$d=su(2,3)*su(2,(count($err)-4));
						$x['six']=$d;
						// echo '中了六等奖'.'('.$d.'次)';
						// echo '<br>';

					}

					if(count($grr)>2){
						$j=su(1,(count($err)-4));
						$jj=su(2,count($grr));
						$jjj=$j*$jj;
						$x['five']=$jjj;
						// echo '中了五等奖'.'('.$jjj.'次)';

						$k=su(2,3)*su(2,(count($err)-4));
						$kk=su(2,count($grr));
						$kkk=$k*$kk;
						$x['six']=$kkk;
						// echo '中了六等奖'.'('.$kkk.'次)';
					}
						return $x;
				}elseif($first==3 && $last==1){
					if(count($grr)==2){
						$c=count($err)-3;			 			
						$five=su(2,$c);
						$x['five']=$five;
						// echo '中了五等奖'.'('.$five.'次)';
						// echo '<br>';

						$d=su(1,2)*su(3,(count($err)-3));
						$x['six']=$d;
						// echo '中了六等奖'.'('.$d.'次)';
					}

					if(count($grr)>2){
						$j=su(2,(count($err)-3));
						$jj=su(1,(count($grr)-1));
						$jjj=$j*$jj;
						$x['five']=$jjj;
						// echo '中了五等奖'.'('.$jjj.'次)';

						if(count($err)==6 && count($grr)>3){
							$s=su(2,(count($err)-3));
							$ss=su(2,count($grr)-1);
							$sss=$s*$ss;
							$x['six']=$sss;
							// echo '中了六等奖'.'('.$sss.'次)';
						}elseif(count($err)==6 && count($grr)==3){
							$v=su(1,2)*su(3,(count($err)-3));
							$vv=su(1,(count($grr)-1));
							$vvv=$v*$vv;
							$x['six']=$vvv;
							// echo '中了六等奖'.'('.$vvv.'次)';
						}elseif(count($err)>5 && count($grr)>3){
							$s=su(2,(count($err)-3));
							$ss=su(2,count($grr)-1);
							$sss=$s*$ss;

							$v=su(1,2)*su(3,(count($err)-3));
							$vv=su(1,(count($grr)-1));
							$vvv=$v*$vv;

							$sv=$sss+$vvv;
							$x['six']=$sv;
							// echo '中了六等奖'.'('.$sv.'次)';
						}
					}
						return $x;
				}elseif($first==2 && $last==2){
					if(count($grr)==2){
						$c=count($err)-2;			 			
						$five=su(3,$c);
						$x['five']=$five;
						// echo '中了五等奖'.'('.$five.'次)';
						// echo '<br>';

						$v=su(4,(count($err)-2));
						$x['six']=$v;
						// echo '中了六等奖'.'('.$v.'次)';
						// echo '<br>';					
					}

					if(count($grr)>2){
						$j=su(3,(count($err)-2));
						$x['five']=$j;
						// echo '中了五等奖'.'('.$j.'次)';

						$xu=su(4,(count($err)-2));
						$x['six']=$xu;

						if(count($err)>5 && count($grr)>3){
							$v=su(3,(count($err)-2));
							$vv=2*su(1,(count($grr)-2));
							$vvv=$v*$vv;

							$u=su(4,(count($err)-2));
							$vu=$vvv+$u;
							$x['six']=$vu;
							// echo '中了六等奖'.'('.$vu.'次)';
						}

					}
						return $x;
				}elseif($first==3 && $last==0){
					if(count($grr)==2){
						$k=su(2,(count($err)-3));
						$x['six']=$k;
						// echo '中了六等奖'.'('.$k.'次)';
					}

					if(count($grr)>2){
						$j=su(2,(count($err)-3));
						$jj=su(2,count($grr));
						$jjj=$j*$jj;
						$x['six']=$jjj;
						// echo '中了六等奖'.'('.$jjj.'次)';
					}
						return $x;
				}elseif($first==1 && $last==2){
					$k=su(4,(count($err)-1));
					$x['six']=$k;
					// echo '中了六等奖'.'('.$j.'次)';

					return $x;
				}elseif($first==2 && $last==1){
					if(count($grr)==2){
						$k=su(3,(count($err)-2));
						$x['six']=$k;
						// echo '中了六等奖'.'('.$k.'次)';
					}

					if(count($grr)>2){
						$k=su(3,(count($err)-2));
						$kk=su(1,(count($grr)-1));
						$kkk=$k*$kk;
						$x['six']=$kkk;
						// echo '中了六等奖'.'('.$kkk.'次)';
					}

				}
					return $x;	
			}
		

		//两个红胆
			if($dan==2){
			 	if($first==5 && $last==2){
			 		if(count($grr)==2){
						$x['one']=1;

						$cc=su(2,3)*su(1,(count($err)-5));
						$x['three']=$cc;

						if(count($err)>6){
							$dd=su(1,3)*su(2,(count($err)-5));
							$x['four']=$dd;
						}

						if(count($err)>7){
							$aa=su(3,(count($err)-5));
							$x['five']=$dd;
						}

					}
			 		$x['one']=1;
			 		// echo '中了一等奖';
			 		// echo '<br>';

			 		if(count($grr)>2){
			 			$j=2*su(1,(count($grr)-2));
			 			$x['two']=$j;
			 			// echo '中了二等奖'.'('.$j.'次)';
			 			// echo '<br>';
			 		}

		 		
	 				if(count($grr)==3){
	 					$e=su(2,3)*su(1,(count($err)-5));
	 					$x['six']=$e;
	 					// echo '中了三等奖'.'('.$e.'次)';	
	 					// echo '<br>';
	 				}

	 				if(count($grr)>3){
	 					$e=su(2,3)*su(1,(count($err)-5));
	 					$d=count($grr)-2;
	 					$td=su(2,$d)+$e;
	 					$x['three']=$td;
	 					// echo '中了三等奖'.'('.$td.'次)';
	 					// echo '<br>';

	 				}

	 				if(count($err)==6 && count($grr)>2){
	 					$f=su(2,3)*su(1,(count($err)-5));
	 					$g=su(1,count($grr)-2)*2;
	 					$ff=$f*$g;
	 					$x['four']=$ff;
	 					// echo '中了四等奖'.'('.$ff.'次)';
	 					// echo '<br>';
	 				}
			 				
		 			if(count($err)>6 && count($grr)>2 ){
	 					$f=su(2,3)*su(1,(count($err)-5));
	 					$g=su(1,count($grr)-2)*2;
	 					$ff=$f*$g;
	 					$h=su(1,3)*su(2,(count($err)-5))+$ff;
	 					$x['four']=$h;
	 					// echo '中了四等奖'.'('.$h.'次)';
	 					// echo '<br>';
						
	 				}

		 			if(count($err)==7 && count($grr)>2){
	 					$p=su(1,3)*su(2,(count($err)-5));
	 					$q=2*su(1,(count($grr)-2));
	 					$pp=$p*$q;
	 					$x['five']=$pp;
	 					// echo '中了五等奖'.'('.$pp.'次)';
	 					// echo '<br>';
	 				}

	 				if(count($err)>7 && count($grr)==3){
	 					$p=su(1,3)*su(2,(count($err)-5));
	 					$q=2*su(1,(count($grr)-2));
	 					$pp=$p*$q;

	 					$r=su(3,(count($err)-5));
	 					$rr=$pp+$r;
	 					$x['five']=$rr;
	 					// echo '中了五等奖'.'('.$rr.'次)';
	 					// echo '<br>';

	 				}elseif(count($err)>7 && count($grr)>3){
	 					$j=su(2,3)*su(1,(count($err)-5));
		 				$d=count($grr)-2;
	 					$td=su(2,$d);
	 					$tdd=$j*$td;

	 					$p=su(1,3)*su(2,(count($err)-5));
	 					$q=2*su(1,(count($grr)-2));
	 					$pp=$p*$q;


	 					$r=su(3,(count($err)-5));
	 					$rr=$pp+$r+$tdd;
	 					$x['five']=$rr;
	 					// echo '中了五等奖'.'('.$rr.'次)';
	 					// echo '<br>';

	 				}

	 				if(count($err)>6 && count($grr)>3){
	 					$s=su(1,3)*su(2,(count($err)-5));
	 					$ss=su(2,count($grr)-2);
	 					$sss=$s*$ss;
	 					$x['six']=$sss;
	 					// echo '中了六等奖'.'('.$sss.'次)';
 					}elseif(count($err)>7 && count($grr)==3){
	 					$v=su(3,(count($err)-5));
	 					$vv=2*su(1,(count($grr)-2));
	 					$vvv=$v*$vv;
	 					$x['six']=$vvv;
	 					// echo '中了六等奖'.'('.$vvv.'次)';
 					}elseif(count($err)>7 && count($grr)>3){
	 					$s=su(1,3)*su(2,(count($err)-5));
	 					$ss=su(2,count($grr)-2);
	 					$sss=$s*$ss;

	 					$v=su(3,(count($err)-5));
	 					$vv=2*su(1,(count($grr)-2));
	 					$vvv=$v*$vv;

	 					$sv=$sss+$vvv;
	 					$x['six']=$sv;
	 					// echo '中了六等奖'.'('.$sv.'次)';
 					}
 						return $x;

			 	}elseif($first==5 && $last==1){

		 			if(count($grr)==2){
		 				$x['two']=1;
		 				// echo '中了二等奖';
		 				// echo '<br>';

		 				$v=su(2,3)*su(1,(count($err)-5));
		 				$x['four']=$v;
		 				// echo '中了四等奖'.'('.$v.'次)';

		 				if(count($err)>6){
		 					$k=su(1,3)*su(2,(count($err)-5));
		 					$x['five']=$k;
		 					// echo '中了五等奖'.'('.$v.'次)';
		 				}

		 				if(count($err)>7){
		 					$c=su(3,(count($err)-5));
		 					$x['six']=$c;
		 					// echo '中了六等奖'.'('.$c.'次)';
		 				}
		 			}

		 			if(count($grr)>2){
		 				$j=su(1,(count($grr)-1));
		 				$x['two']=$j;
		 				// echo '中了二等奖'.'('.$j.'次)';

	 					$d=count($grr)-1;
	 					$td=su(2,$d);
	 					$x['three']=$td;
	 					// echo '中了三等奖'.'('.$td.'次)';
	 					// echo '<br>';	

		 				$e=su(2,3)*su(1,(count($err)-5));
		 				$ee=su(1,(count($grr)-1));
		 				$eee=$e*$ee;
		 				$x['four']=$eee;
		 				// echo '中了四等奖'.'('.$eee.'次)';
		 				// echo '<br>';

		 				if(count($err)==6 && count($grr)==3){
							$f=su(2,3)*su(1,(count($err)-5));
			 				$ff=su(2,(count($grr)-1));
			 				$fff=$f*$ff;
			 				$x['five']=$fff;
			 				// echo '中了五等奖'.'('.$fff.'次)';
			 				// echo '<br>';

		 				}elseif(count($err)>6 && count($grr)>3){
		 					$g=su(1,3)*su(2,(count($err)-5));
		 					$gg=su(1,(count($grr)-1));
		 					$ggg=$g*$gg;

			 				$f=su(2,3)*su(1,(count($err)-5));
			 				$ff=su(2,(count($grr)-1));
			 				$fff=$f*$ff;

			 				$fg=$ggg+$fff;
			 				$x['five']=$fg;
		 					// echo '中了五等奖'.'('.$fg.'次)';
		 					// echo '<br>';

		 				}


		 				if(count($err)>6 && count($grr)>2){
			 					$s=su(1,3)*su(2,(count($err)-5));
			 					$ss=su(2,count($grr)-1);
			 					$sss=$s*$ss;
			 					$x['six']=$sss;
			 					// echo '中了六等奖'.'('.$sss.'次)';
			 					// echo '<br>';

		 				}elseif(count($err)>7 && count($grr)>2){
			 					$s=su(1,3)*su(2,(count($err)-5));
			 					$ss=su(2,count($grr)-1);
			 					$sss=$s*$ss;

			 					$v=su(3,(count($err)-5));
			 					$vv=su(1,(count($grr)-1));
			 					$vvv=$v*$vv;

			 					$sv=$sss+$vvv;
			 					$x['six']=$sv;
			 					// echo '中了六等奖'.'('.$sv.'次)';
			 					// echo '<br>';

		 				}
		 			}
		 					return $x;

			 	}elseif($first==5 && $last==0){
		 			if(count($grr)==2){
		 				$x['three']=1;
		 				//echo '中了三等奖';
		 				$dd=su(2,3)*su(1,(count($err)-5));
		 				$x['five']=$dd;

		 				if(count($err)>6){
		 					$cc=su(1,3)*su(2,(count($err)-5));
		 					$x['six']=$cc;
		 				}
		 			}
		 			if(count($grr)>2){
		 				$td=su(2,count($grr));
		 				$x['three']=$td;
	 					// echo '中了三等奖'.'('.$td.'次)';
	 					// echo '<br>';

	 					$s=su(2,3)*su(1,(count($err)-5));
	 					$ss=su(2,count($grr));
	 					$sss=$s*$ss;
	 					$x['five']=$sss;
	 					// echo '中了五等奖'.'('.$sss.'次)';
	 					// echo '<br>';

	 					if(count($err)>6){
	 						$v=su(1,3)*su(2,(count($err)-5));
	 						$vv=su(2,count($grr));
	 						$vvv=$v*$vv;
	 						$x['six']=$vvv;
	 						// echo '中了六等奖'.'('.$vvv.'次)';
	 						// echo '<br>';
	 					}

		 			}
	 						return $x;
			 	}elseif($first==4 && $last==2){
		 			if(count($grr)==2){
		 				$j=su(1,(count($err)-4));
		 				$x['three']=$j;
	 					// echo '中了三等奖'.'('.$j.'次)'; 
	 					// echo '<br>';
	 				
	 				    $h=su(1,2)*su(2,(count($err)-4));
	 				    $x['four']=$h;
	 				 	//echo '中了四等奖'.'('.$h.'次)';
	 					// echo '<br>';

	 					if(count($err)>6){
	 						$k=su(3,(count($err)-4));
	 						$x['five']=$k;
	 						// echo '中了五等奖'.'('.$k.'次)';
	 						// echo '<br>';
	 					}
		 			}

		 			if(count($grr)>2){
		 				$j=su(1,(count($err)-4));
		 				$x['three']=$j;
	 					// echo '中了三等奖'.'('.$j.'次)'; 
	 					// echo '<br>';
			 				
			 			if(count($err)==6){
		 					$f=su(1,(count($err)-4));
		 					$g=su(1,count($grr)-2)*2;
		 					$ff=$f*$g;
		 					$h=su(1,2)*su(2,(count($err)-4))+$ff;
		 					$x['four']=$h;
		 					// echo '中了四等奖'.'('.$h.'次)';
		 					// echo '<br>';
								
			 			}

						if(count($err)==6){
		 					$p=su(1,2)*su(2,(count($err)-4));
		 					$q=2*su(1,(count($grr)-2));
		 					$pp=$p*$q;
		 					$x['five']=$pp;
		 					// echo '中了五等奖'.'('.$pp.'次)';
		 					// echo '<br>';
		 				}

		 				if(count($err)>6 && count($grr)==3){
		 					$p=su(1,2)*su(2,(count($err)-4));
		 					$q=2*su(1,(count($grr)-2));
		 					$pp=$p*$q;

		 					$r=su(3,(count($err)-4));
		 					$rr=$pp+$r;
		 					$x['five']=$rr;
		 					// echo '中了五等奖'.'('.$rr.'次)';
		 					// echo '<br>';

		 				}elseif(count($err)>7 && count($grr)>3){
			 				$d=su(1,(count($err)-4));
		 					$dd=su(2,(count($grr)-2));
		 					$ddd=$d*$dd;

		 					$p=su(1,2)*su(2,(count($err)-4));
		 					$q=2*su(1,(count($grr)-2));
		 					$pp=$p*$q;

		 					$r=su(3,(count($err)-4));
		 					$rr=$pp+$r+$tdd;
		 					$x['five']=$rr;
		 					// echo '中了五等奖'.'('.$rr.'次)';
		 					// echo '<br>';

		 				}

		 				if(count($err)==6 && count($grr)>3){
		 					$n=su(1,2)*su(2,(count($err)-4));
		 					$nn=su(2,(count($grr)-2));
		 					$nnn=$n*$nn;
		 					$x['six']=$nnn;
		 					// echo '中了六等奖'.'('.$nnn.'次)';

		 				}

		 				if(count($err)>6 && count($grr)==3){
	 						$v=su(3,(count($err)-4));
		 					$vv=2*su(1,(count($grr)-2));
		 					$vvv=$v*$vv;
		 					$x['six']=$vvv;
		 					// echo '中了六等奖'.'('.$vvv.'次)';
		 					// echo '<br>';
		 				}

		 				if(count($err)>6 && count($grr)>3){
		 					$v=su(3,(count($err)-4));
		 					$vv=2*su(1,(count($grr)-2));
		 					$vvv=$v*$vv;

		 					$n=su(1,2)*su(2,(count($err)-4));
		 					$nn=su(2,(count($grr)-2));
		 					$nnn=$n*$nn;

		 					$vn=$vvv+$nnn;
		 					$x['six']=$vn;
		 					// echo '中了六等奖'.'('.$vn.'次)';
		 					// echo '<br>';
		 				}
			 		}
			 				return $x;

			 	}elseif($first==4 && $last==1){
		 			if(count($grr)==2){
		 				$c=count($err)-4;			 			
		 				$four=su(1,$c);
		 				$x['four']=$four;
		 				// echo '中了四等奖'.'('.$four.'次)';
		 				// echo '<br>';

		 				
	 					$k=su(1,2)*su(2,(count($err)-4));
	 					$x['five']=$k;
	 					// echo '中了五等奖'.'('.$k.'次)';
	 					// echo '<br>';

		 				if(count($err)>6){
		 					$v=su(3,(count($err)-4));
		 					$x['six']=$v;
		 					// echo '中了六等奖'.'('.$v.'次)';
		 					// echo '<br>';
		 				}
		 			}

		 			if(count($grr)>2){
		 				$k=su(1,(count($err)-4));
		 				$kk=su(1,(count($grr)-1));
		 				$kkk=$k*$kk;
		 				$x['four']=$kkk;
		 				// echo '中了四等奖'.'('.$kkk.'次)';
		 				// echo '<br>'; 

						if(count($err)>5){
			 				$d=su(1,(count($err)-4));
		 					$dd=su(2,(count($grr)-1));
		 					$ddd=$d*$dd;

		 					$p=su(1,2)*su(2,(count($err)-4));
		 					$q=su(1,(count($grr)-1));
		 					$pp=$p*$q;

		 					$rr=$pp+$ddd;
		 					$x['five']=$rr;
		 					// echo '中了五等奖'.'('.$rr.'次)';
		 					// echo '<br>';
		 				}

		 				if(count($err)==6){
		 					$s=su(1,2)*su(2,(count($err)-4));
		 					$ss=su(2,count($grr)-1);
		 					$sss=$s*$ss;
		 					$x['six']=$sss;
		 					// echo '中了六等奖'.'('.$sss.'次)';
		 				}elseif(count($err)==7){
		 					$v=su(3,(count($err)-4));
		 					$vv=su(1,(count($grr)-1));
		 					$vvv=$v*$vv;
		 					$x['six']=$vvv;
		 					// echo '中了六等奖'.'('.$vvv.'次)';
		 				}elseif(count($err)>7){
		 					$s=su(1,2)*su(2,(count($err)-4));
		 					$ss=su(2,count($grr)-1);
		 					$sss=$s*$ss;

							$v=su(3,(count($err)-4));
		 					$vv=su(1,(count($crr)-1));
		 					$vvv=$v*$vv;

		 					$sv=$sss+$vvv;
		 					$x['six']=$sv;
		 					// echo '中了六等奖'.'('.$sv.'次)';
		 				}
		 			}
		 					return $x;

			 	}elseif($first==3 && $last==2){
			 		if(count($grr)==2){
			 			$c=count($err)-3;			 			
		 				$four=su(2,$c);
		 				$x['four']=$four;
		 				// echo '中了四等奖'.'('.$four.'次)';

 						$k=su(3,(count($err)-3));
 						$x['five']=$k;
 						// echo '中了五等奖'.'('.$k.'次)';
 						// echo '<br>';
			 		}


			 		if(count($grr)>2){
			 			$j=su(2,(count($err)-3));
			 			$x['four']=$j;
		 				// echo '中了四等奖'.'('.$j.'次)';

						if(count($err)>5){
		 					$p=su(2,(count($err)-3));
		 					$q=2*su(1,(count($grr)-2));
		 					$pp=$p*$q;

		 					$r=su(3,(count($err)-3));
		 					$rr=$pp+$r;
		 					$x['five']=$rr;
		 					// echo '中了五等奖'.'('.$rr.'次)';
		 					// echo '<br>';
		 				}

		 				if(count($err)==6 && count($grr)>3){
		 					$s=su(2,(count($err)-3));
		 					$ss=su(2,count($grr)-2);
		 					$sss=$s*$ss;
		 					$x['six']=$sss;
		 					return $x;
		 					// echo '中了六等奖'.'('.$sss.'次)';
		 				}elseif(count($err)==6 && count($grr)==3){
		 					$v=su(3,(count($err)-3));
		 					$vv=2*su(1,(count($grr)-2));
		 					$vvv=$v*$vv;
		 					$x['six']=$vvv;
		 					return $x;
		 					// echo '中了六等奖'.'('.$vvv.'次)';
		 				}elseif(count($err)>6 && count($grr)>3){
		 					$s=su(2,(count($err)-3));
		 					$ss=su(2,count($grr)-2);
		 					$sss=$s*$ss;

		 					$v=su(3,(count($err)-3));
		 					$vv=2*su(1,(count($grr)-2));
		 					$vvv=$v*$vv;

		 					$sv=$sss+$vvv;
		 					$x['six']=$sv;
		 					// echo '中了六等奖'.'('.$sv.'次)';
		 				}

			 		}
			 				return $x;
			 	}elseif($first==4 && $last==0){
		 	   		if(count($grr)==2){
		 	   			$c=count($err)-4;			 			
		 				$five=su(1,$c);
		 				$x['five']=$five;
		 				// echo '中了五等奖'.'('.$five.'次)';
		 				// echo '<br>';

		 				$d=su(1,2)*su(2,(count($err)-4));
		 				$x['six']=$d;
		 				// echo '中了六等奖'.'('.$d.'次)';
	 					// echo '<br>';

		 	   		}

		 	   		if(count($grr)>2){
		 	   			$j=su(1,(count($err)-4));
		 				$jj=su(2,count($grr));
		 				$jjj=$j*$jj;
		 				$x['five']=$jjj;
		 				// echo '中了五等奖'.'('.$jjj.'次)';

		 				$k=su(1,2)*su(2,(count($err)-4));
		 				$kk=su(2,count($grr));
		 				$kkk=$k*$kk;
		 				$x['six']=$kkk;
		 				// echo '中了六等奖'.'('.$kkk.'次)';
		 	   		}
		 	   			return $x;
			 	}elseif($first==3 && $last==1){
			 	   		if(count($grr)==2){
			 	   			$c=count($err)-3;			 			
			 				$five=su(2,$c);
			 				$x['five']=$five;
			 				// echo '中了五等奖'.'('.$five.'次)';
			 				// echo '<br>';

			 				$d=su(3,(count($err)-3));
			 				$x['six']=$d;
			 				// echo '中了六等奖'.'('.$d.'次)';
			 	   		}

			 	   		if(count($grr)>2){
			 	   			$j=su(2,(count($err)-3));
			 				$jj=su(1,(count($grr)-1));
			 				$jjj=$j*$jj;
			 				$x['five']=$jjj;
			 				// echo '中了五等奖'.'('.$jjj.'次)';

			 				if(count($err)==6 && count($grr)>3){
			 					$s=su(2,(count($err)-3));
			 					$ss=su(2,count($grr)-1);
			 					$sss=$s*$ss;
			 					$x['six']=$sss;
			 					// echo '中了六等奖'.'('.$sss.'次)';
			 				}elseif(count($err)==6 && count($grr)==3){
			 					$v=su(3,(count($err)-3));
			 					$vv=su(1,(count($grr)-1));
			 					$vvv=$v*$vv;
			 					$x['six']=$vvv;
			 					// echo '中了六等奖'.'('.$vvv.'次)';
			 				}elseif(count($err)>6 && count($grr)>3){
			 					$s=su(2,(count($err)-3));
			 					$ss=su(2,count($grr)-1);
			 					$sss=$s*$ss;

			 					$v=su(3,(count($err)-3));
			 					$vv=su(1,(count($grr)-1));
			 					$vvv=$v*$vv;

			 					$sv=$sss+$vvv;
			 					$x['six']=$sv;
			 					// echo '中了六等奖'.'('.$sv.'次)';
			 				}
			 	   		}
			 	   				return $x;
		 	   	}elseif($first==2 && $last==2){
		 	   		if(count($grr)==2){
		 	   			$c=count($err)-2;			 			
		 				$five=su(3,$c);
		 				$x['five']=$five;
		 				// echo '中了五等奖'.'('.$five.'次)';
		 				// echo '<br>';
	 					
		 	   		}

		 	   		if(count($grr)>2){
		 	   			$j=su(3,(count($err)-2));
		 	   			$x['five']=$j;
		 				// echo '中了五等奖'.'('.$j.'次)';

	 					$v=su(3,(count($err)-2));
	 					$vv=2*su(1,(count($grr)-2));
	 					$vvv=$v*$vv;
	 					$x['six']=$vvv;
	 					// echo '中了六等奖'.'('.$vvv.'次)';
		 	   		}
		 	   			return $x;

		 	   	}elseif($first==3 && $last==0){
		 	   		if(count($grr)==2){
		 	   			$k=su(2,(count($err)-3));
		 	   			$x['six']=$k;
		 	   			// echo '中了六等奖'.'('.$k.'次)';
		 	   		}

		 	   		if(count($grr)>2){
		 	   			$j=su(2,(count($err)-3));
		 	   			$jj=su(2,count($grr));
		 	   			$jjj=$j*$jj;
		 	   			$x['six']=$jjj;
		 	   			// echo '中了六等奖'.'('.$jjj.'次)';
		 	   		}
		 	   			return $x;
		 	   	}elseif($first==2 && $last==1){
		 	   		if(count($grr)==2){
		 	   			$k=su(3,(count($err)-2));
		 	   			$x['six']=$k;
		 	   			// echo '中了六等奖'.'('.$k.'次)';
		 	   		}

		 	   		if(count($grr)>2){
		 	   			$k=su(3,(count($err)-2));
		 	   			$kk=su(1,(count($grr)-1));
		 	   			$kkk=$k*$kk;
		 	   			$x['six']=$kkk;
		 	   			// echo '中了六等奖'.'('.$kkk.'次)';
		 	   		}
			 	}
			 		return $x;	
			}
				 

		//三个红胆
			if($dan==3){
			 	if($first==5 && $last==2){
			 		if(count($grr)==2){
						$x['one']=1;

						$cc=su(2,3)*su(1,(count($err)-5));
						$x['three']=$cc;

						if(count($err)>6){
							$dd=su(1,3)*su(2,(count($err)-5));
							$x['four']=$dd;
						}
					}
			 		$x['one']=1;
			 		// echo '中了一等奖';
			 		// echo '<br>';

			 		if(count($grr)>2){
			 			$j=2*su(1,(count($grr)-2));
			 			$x['two']=$j;
			 			// echo '中了二等奖'.'('.$j.'次)';
			 			// echo '<br>';
			 		}

		 		
	 				if(count($grr)==3){
	 					$e=su(1,2)*su(1,(count($err)-5));
	 					$x['three']=$e;
	 					// echo '中了三等奖'.'('.$e.'次)';	
	 					// echo '<br>';
	 				}

	 				if(count($grr)>3){
	 					$e=su(1,2)*su(1,(count($err)-5));
	 					$d=count($grr)-2;
	 					$td=su(2,$d)+$e;
	 					$x['three']=$td;
	 					// echo '中了三等奖'.'('.$td.'次)';
	 					// echo '<br>';
	 				}

	 				if(count($err)==6 && count($grr)>2){
			 			$f=su(1,2)*su(1,(count($err)-5));
			 			$g=su(1,count($grr)-2)*2;
			 			$ff=$f*$g;
			 			$x['four']=$ff;
			 			// echo '中了四等奖'.'('.$ff.'次)';
			 			// echo '<br>';
			 		}
				 				
		 			if(count($err)>6 && count($grr)>2 ){
		 				$f=su(1,2)*su(1,(count($err)-5));
		 				$g=su(1,count($grr)-2)*2;
		 				$ff=$f*$g;
		 				$h=su(2,(count($err)-5))+$ff;
		 				$x['four']=$h;
		 				// echo '中了四等奖'.'('.$h.'次)';
		 				// echo '<br>';	
		 			}

		 			if(count($err)==7 && count($grr)>2){
			 			$p=su(2,(count($err)-5));
			 			$q=2*su(1,(count($grr)-2));
			 			$pp=$p*$q;
			 			$x['five']=$pp;
			 			// echo '中了五等奖'.'('.$pp.'次)';
			 			// echo '<br>';
		 			}

	 				if(count($err)>7 && count($grr)==3){
		 				$p=su(2,(count($err)-5));
		 				$q=2*su(1,(count($grr)-2));
		 				$pp=$p*$q;

		 				$r=su(3,(count($err)-5));
		 				$rr=$pp+$r;
		 				$x['five']=$rr;
		 				// echo '中了五等奖'.'('.$rr.'次)';
		 				// echo '<br>';
	 				}elseif(count($err)>6 && count($grr)>3){
		 				$j=su(1,2)*su(1,(count($err)-5));
			 			$d=count($grr)-2;
		 				$td=su(2,$d);
		 				$tdd=$j*$td;
		 			
		 				$p=su(2,(count($err)-5));
		 				$q=2*su(1,(count($grr)-2));
		 				$pp=$p*$q;

		 				$rr=$pp+$tdd;
		 				$x['five']=$rr;
		 				// echo '中了五等奖'.'('.$rr.'次)';
		 				// echo '<br>';
	 				}

	 				if(count($err)>6 && count($grr)>3){
			 			$s=su(2,(count($err)-5));
			 			$ss=su(2,count($grr)-2);
			 			$sss=$s*$ss;
			 			$x['six']=$sss;
			 			// echo '中了六等奖'.'('.$sss.'次)';
		 			}
		 				return $x;

			 	}elseif($first==5 && $last==1){

			 		if(count($grr)==2){
			 			$x['two']=1;
			 			// echo '中了二等奖';
			 			// echo '<br>';

			 			$v=su(1,2)*su(1,(count($err)-5));
			 			$x['four']=$v;
			 			// echo '中了四等奖'.'('.$v.'次)';
			 			if(count($err)>6){
			 				$k=su(2,(count($err)-5));
			 				$x['five']=$k;
			 				// echo '中了五等奖'.'('.$k.'次)';
			 			}
		 				
			 				
			 		}

			 		if(count($grr)>2){
			 			$j=su(1,(count($grr)-1));
			 			$x['two']=$j;
			 			// echo '中了二等奖'.'('.$j.'次)';

		 				$d=count($grr)-1;
		 				$td=su(2,$d);
		 				$x['three']=$td;
		 				// echo '中了三等奖'.'('.$td.'次)';
		 				// echo '<br>';

			 			$e=su(1,2)*su(1,(count($err)-5));
			 			$ee=su(1,(count($grr)-1));
			 			$eee=$e*$ee;
			 			$x['four']=$eee;
		 				// echo '中了四等奖'.'('.$eee.'次)';
		 				// echo '<br>';

		 				if(count($err)==6 && count($grr)>3){
							$f=su(1,2)*su(1,(count($err)-5));
			 				$ff=su(2,(count($grr)-1));
			 				$fff=$f*$ff;
			 				$x['five']=$fff;
			 				// echo '中了五等奖'.'('.$fff.'次)';
			 				// echo '<br>';

		 				}elseif(count($err)>6 && count($grr)>3){
		 					$g=su(2,(count($err)-5));
		 					$gg=su(1,(count($grr)-1));
		 					$ggg=$g*$gg;

			 				$f=su(1,2)*su(1,(count($err)-5));
			 				$ff=su(2,(count($grr)-1));
			 				$fff=$f*$ff;

			 				$fg=$ggg+$fff;
			 				$x['five']=$fg;
		 					// echo '中了五等奖'.'('.$fg.'次)';
		 					// echo '<br>';

		 				}

		 				if(count($err)>6 && count($grr)>2){
		 					$s=su(2,(count($err)-5));
		 					$ss=su(2,count($grr)-1);
		 					$sss=$s*$ss;
		 					$x['six']=$sss;
		 					// echo '中了六等奖'.'('.$sss.'次)';
		 					// echo '<br>';

		 				}
				 			
				 	}
				 		return $x;
			 	}elseif($first==5 && $last==0){
		 			if(count($grr)==2){
		 				$x['three']=1;
		 				//echo '中了三等奖';
		 				$dd=su(1,2)*su(1,(count($err)-5));
		 				$x['five']=$dd;

		 				if(count($err)>6){
		 					$cc=su(2,(count($err)-5));
		 					$x['six']=$cc;
		 				}
		 			}
		 			if(count($grr)>2){
		 				$td=su(2,count($grr));
		 				$x['three']=$td;
	 					// echo '中了三等奖'.'('.$td.'次)';
	 					// echo '<br>';

	 					$s=su(1,2)*su(1,(count($err)-5));
	 					$ss=su(2,count($grr));
	 					$sss=$s*$ss;
	 					$x['five']=$sss;
	 					// echo '中了五等奖'.'('.$sss.'次)';
	 					// echo '<br>';


	 					if(count($err)>6){
	 						$v=su(2,(count($err)-5));
	 						$vv=su(2,count($grr));
	 						$vvv=$v*$vv;
	 						$x['six']=$vvv;
	 						// echo '中了六等奖'.'('.$vvv.'次)';
	 						// echo '<br>';
	 					}

		 			}
		 						return $x;

			 	}elseif($first==4 && $last==2){

		 			if(count($grr)==2){
		 				$j=su(1,(count($err)-4));
		 				$x['three']=$j;
	 					// echo '中了三等奖'.'('.$j.'次)'; 
	 					// echo '<br>';
	 				
	 				    $h=su(2,(count($err)-4));
	 				    $x['four']=$h;
	 				 // 	echo '中了四等奖'.'('.$h.'次)';
	 					// echo '<br>';		 					
		 			}

		 			if(count($grr)>2){
		 				$j=su(1,(count($err)-4));
		 				$x['three']=$j;
	 					// echo '中了三等奖'.'('.$j.'次)'; 
	 					// echo '<br>';
			 				
			 			if(count($err)>5){
		 					$f=su(1,(count($err)-4));
		 					$g=su(1,count($grr)-2)*2;
		 					$ff=$f*$g;
		 					$h=su(2,(count($err)-4))+$ff;
		 					$x['four']=$h;
		 					// echo '中了四等奖'.'('.$h.'次)';
		 					// echo '<br>';
							
		 				}

						if(count($err)>5 && count($grr)==3){
		 					$p=su(2,(count($err)-4));
		 					$q=2*su(1,(count($grr)-2));
		 					$pp=$p*$q;
		 					$x['five']=$pp;
		 					// echo '中了五等奖'.'('.$pp.'次)';
		 					// echo '<br>';
		 				}

		 				if(count($err)>5 && count($grr)>3){
			 				$d=su(1,(count($err)-4));
		 					$dd=su(2,(count($grr)-2));
		 					$ddd=$d*$dd;

		 					$p=su(2,(count($err)-4));
		 					$q=2*su(1,(count($grr)-2));
		 					$pp=$p*$q;

		 					$rr=$pp+$ddd;
		 					$x['five']=$rr;
		 					// echo '中了五等奖'.'('.$rr.'次)';
		 					// echo '<br>';

		 				}

		 				if(count($err)>5 && count($grr)>3){
		 					$n=su(2,(count($err)-4));
		 					$nn=su(2,(count($grr)-2));
		 					$nnn=$n*$nn;
		 					$x['six']=$nnn;
		 					// echo '中了六等奖'.'('.$nnn.'次)';
		 				}
				 	}
				 			return $x;

			 	}elseif($first==4 && $last==1){
		 			if(count($grr)==2){
		 				$c=count($err)-4;			 			
		 				$four=su(1,$c);
		 				$x['four']=$four;
		 				// echo '中了四等奖'.'('.$four.'次)';
		 				// echo '<br>';

	 					$k=su(2,(count($grr)-4));
	 					$x['five']=$k;
	 					// echo '中了五等奖'.'('.$k.'次)';
	 					// echo '<br>';

		 			}

		 			if(count($grr)>2){
		 				$k=su(1,(count($err)-4));
		 				$kk=su(1,(count($grr)-1));
		 				$kkk=$k*$kk;
		 				$x['four']=$kkk;
		 				// echo '中了四等奖'.'('.$kkk.'次)';
		 				// echo '<br>'; 

						if(count($err)>5){
			 				$d=su(1,(count($err)-4));
		 					$dd=su(2,(count($grr)-1));
		 					$ddd=$d*$dd;

		 					$p=su(2,(count($err)-4));
		 					$q=su(1,(count($grr)-1));
		 					$pp=$p*$q;

		 					$rr=$pp+$ddd;
		 					$x['five']=$rr;
		 					// echo '中了五等奖'.'('.$rr.'次)';
		 					// echo '<br>';

		 				}

		 				if(count($err)>5){
		 					$s=su(2,(count($err)-4));
		 					$ss=su(2,count($grr)-1);
		 					$sss=$s*$ss;
		 					$x['six']=$sss;
		 					// echo '中了六等奖'.'('.$sss.'次)';
		 				}

		 			}
		 				return $x;

			 	}elseif($first==3 && $last==2){
			 		if(count($grr)==2){
			 			$c=count($err)-3;			 			
		 				$four=su(2,$c);
		 				$x['four']=$four;
		 				// echo '中了四等奖'.'('.$four.'次)';	
			 		}


			 		if(count($grr)>2){
			 			$j=su(2,(count($err)-3));
			 			$x['four']=$j;
		 				// echo '中了四等奖'.'('.$j.'次)';

	 					$p=su(2,(count($err)-3));
	 					$q=2*su(1,(count($grr)-2));
	 					$pp=$p*$q;
	 					$x['five']=$pp;
	 					// echo '中了五等奖'.'('.$pp.'次)';
	 					// echo '<br>'; 
		 				
		 				if(count($err)>5 && count($grr)>3){
		 					$s=su(2,(count($err)-3));
		 					$ss=su(2,count($grr)-2);
		 					$sss=$s*$ss;
		 					$x['six']=$sss;
		 					// echo '中了六等奖'.'('.$sss.'次)';
		 				}
			 		}
			 				return $x;
			 	}elseif($first==4 && $last==0){
		 	   		if(count($grr)==2){
		 	   			$c=count($err)-4;			 			
		 				$five=su(1,$c);
		 				$x['five']=$five;
		 				// echo '中了五等奖'.'('.$five.'次)';
		 				// echo '<br>';

		 				$d=su(2,(count($err)-4));
		 				$x['six']=$d;
		 				// echo '中了六等奖'.'('.$d.'次)';
	 					// echo '<br>';
		 	   		}

		 	   		if(count($grr)>2){
		 	   			$j=su(1,(count($err)-4));
		 				$jj=su(2,count($grr));
		 				$jjj=$j*$jj;
		 				$x['five']=$jjj;
		 				// echo '中了五等奖'.'('.$jjj.'次)';

		 				$k=su(2,(count($err)-4));
		 				$kk=su(2,count($grr));
		 				$kkk=$k*$kk;
		 				$x['six']=$kkk;
		 				// echo '中了六等奖'.'('.$kkk.'次)';
		 	   		}
		 	   			return $x;
			 	}elseif($first==3 && $last==1){
		 	   		if(count($grr)==2){
		 	   			$c=count($err)-3;			 			
		 				$five=su(2,$c);
		 				$x['five']=$five;
		 				// echo '中了五等奖'.'('.$five.'次)';
		 				// echo '<br>';
		 	   		}

		 	   		if(count($grr)>2){
		 	   			$j=su(2,(count($err)-3));
		 				$jj=su(1,(count($grr)-1));
		 				$jjj=$j*$jj;
		 				$x['five']=$jjj;
		 				// echo '中了五等奖'.'('.$jjj.'次)';
		 				
		 				if(count($err)>5){
		 					$s=su(2,(count($err)-3));
		 					$ss=su(2,count($grr)-1);
		 					$sss=$s*$ss;
		 					$x['six']=$sss;
		 					// echo '中了六等奖'.'('.$sss.'次)';
		 				}
		 	   		}
		 	   				return $x;
			 	}elseif($first==3 && $last==0){
		 	   		if(count($grr)==2){
		 	   			$k=su(2,(count($err)-3));
		 	   			$x['six']=$k;
		 	   			// echo '中了六等奖'.'('.$k.'次)';
		 	   		}

		 	   		if(count($grr)>2){
		 	   			$j=su(2,(count($err)-3));
		 	   			$jj=su(2,count($grr));
		 	   			$jjj=$j*$jj;
		 	   			$x['six']=$jjj;
		 	   			// echo '中了六等奖'.'('.$jjj.'次)';
		 	   		}
			 	}	
			 		return $x;
			}

		//四个红胆
			if($dan==4){
			 	if($first==5 && $last==2){
			 		if(count($grr)==2){
						$x['one']=1;

						$cc=su(1,(count($err)-5));
						$x['three']=$cc;
					}
			 		$x['one']=1;
			 		// cho '中了一等奖';
			 		// echo '<br>';

			 		if(count($grr)>2){
			 			$j=2*su(1,(count($grr)-2));
			 			$x['two']=$j;
			 			// echo '中了二等奖'.'('.$j.'次)';
			 			// echo '<br>';
			 		}

		 		
	 				if(count($grr)==3){
	 					$e=su(1,(count($err)-5));
	 					$x['three']=$e;
	 					// echo '中了三等奖'.'('.$e.'次)';	
	 					// echo '<br>';
	 				}

	 				if(count($grr)>3){
	 					$e=su(1,(count($err)-5));
	 					$d=count($grr)-2;
	 					$td=su(2,$d)+$e;
	 					$x['three']=$td;
	 					// echo '中了三等奖'.'('.$td.'次)';
	 					// echo '<br>';
	 				}

	 				if(count($err)>5 && count($grr)>2){
	 					$f=su(1,(count($err)-5));
	 					$g=su(1,count($grr)-2)*2;
	 					$ff=$f*$g;
	 					$x['four']=$ff;
	 					// echo '中了四等奖'.'('.$ff.'次)';
	 					// echo '<br>';
	 				}

	 				if(count($err)>5 && count($grr)>3){
	 					$j=su(1,(count($err)-5));
		 				$d=count($grr)-2;
	 					$td=su(2,$d);
	 					$tdd=$j*$td;
	 					$x['five']=$tdd;
	 					// echo '中了五等奖'.'('.$tdd.'次)';
	 					// echo '<br>';

	 				}
	 					return $x;

			 	}elseif($first==5 && $last==1){

		 			if(count($grr)==2){
		 				$x['two']=1;
		 				// echo '中了二等奖';
		 				// echo '<br>';

		 				$v=su(1,(count($err)-5));
		 				$x['four']=$v;
		 				// echo '中了四等奖'.'('.$v.'次)';
		 				
		 			}

		 			if(count($grr)>2){
		 				$j=su(1,(count($grr)-1));
		 				$x['two']=$j;
		 				// echo '中了二等奖'.'('.$j.'次)';

	 					$d=count($grr)-1;
	 					$td=su(2,$d);
	 					$x['three']=$td;
	 					// echo '中了三等奖'.'('.$td.'次)';
	 					// echo '<br>';

		 				$e=su(1,(count($err)-5));
		 				$ee=su(1,(count($grr)-1));
		 				$eee=$e*$ee;
		 				$x['four']=$eee;
		 				// echo '中了四等奖'.'('.$eee.'次)';
		 				// echo '<br>';

		 				if(count($err)==6 && count($grr)>3){
							$f=su(1,(count($err)-5));
			 				$ff=su(2,(count($grr)-1));
			 				$fff=$f*$ff;
			 				$x['five']=$fff;
			 				// echo '中了五等奖'.'('.$fff.'次)';
			 				// echo '<br>';

		 				}
		 			
		 			}
		 				return $x;

			 	}elseif($first==5 && $last==0){
		 			if(count($grr)==2){
		 				$x['three']=1;
		 				// echo '中了三等奖';

		 				$dd=su(1,(count($err)-5));
		 				$x['five']=$dd;
		 			}
		 			if(count($grr)>2){
		 				$td=su(2,count($grr));
		 				$x['three']=$td;
	 					// echo '中了三等奖'.'('.$td.'次)';
	 					// echo '<br>';

	 					$s=su(1,(count($err)-5));
	 					$ss=su(2,count($grr));
	 					$sss=$s*$ss;
	 					$x['five']=$sss;
	 					// echo '中了五等奖'.'('.$sss.'次)';
	 					// echo '<br>';
		 			}
 						return $x;

			 	}elseif($first==4 && $last==2){

		 			if(count($grr)==2){
		 				$j=su(1,(count($err)-4));
		 				$x['three']=$j;
	 					// echo '中了三等奖'.'('.$j.'次)'; 
	 					// echo '<br>';
		 			}

		 			if(count($grr)>2){
		 				$j=su(1,(count($err)-4));
		 				$x['three']=$j;
	 					// echo '中了三等奖'.'('.$j.'次)'; 
	 					// echo '<br>';
 			
	 					$f=su(1,(count($err)-4));
	 					$g=su(1,count($grr)-2)*2;
	 					$ff=$f*$g;
	 					$x['four']=$ff;
	 					// echo '中了四等奖'.'('.$ff.'次)';
	 					// echo '<br>';

		 				if(count($err)>5 && count($grr)>3){
				 				$d=su(1,(count($err)-4));
			 					$dd=su(2,(count($grr)-2));
			 					$ddd=$d*$dd;
			 					$x['five']=$ddd;
			 					// echo '中了五等奖'.'('.$ddd.'次)';
			 					// echo '<br>';
		 				}
		 			}
				 				return $x;

				 	}elseif($first==4 && $last==1){
			 			if(count($grr)==2){
			 				$c=count($err)-4;			 			
			 				$four=su(1,$c);
			 				$x['four']=$four;
			 				// echo '中了四等奖'.'('.$four.'次)';
			 				// echo '<br>';
			 			}

			 			if(count($grr)>2){
			 				$k=su(1,(count($err)-4));
			 				$kk=su(1,(count($grr)-1));
			 				$kkk=$k*$kk;
			 				$x['four']=$kkk;
			 				// echo '中了四等奖'.'('.$kkk.'次)';
			 				// echo '<br>'; 

				 			if(count($err)>5){
				 				$d=su(1,(count($err)-4));
			 					$dd=su(2,(count($grr)-1));
			 					$ddd=$d*$dd;

			 					$rr=$ddd;
			 					$x['five']=$rr;
			 					// echo '中了五等奖'.'('.$rr.'次)';
			 					// echo '<br>';
				 			}
			 			}
			 					return $x;

				 	}elseif($first==4 && $last==0){
			 	   		if(count($grr)==2){
			 	   			$c=count($err)-4;			 			
			 				$five=su(1,$c);
			 				$x['five']=$five;
			 				// echo '中了五等奖'.'('.$five.'次)';
			 				// echo '<br>';
			 	   		}

			 	   		if(count($grr)>2){
			 	   			$j=su(1,(count($err)-4));
			 				$jj=su(2,count($grr));
			 				$jjj=$j*$jj;
			 				$x['five']=$jjj;
			 				// echo '中了五等奖'.'('.$jjj.'次)';

			 	   		}
				 	}
				 			return $x;
			 	}
			} 

		



				//有蓝胆无红胆	
			if(strpos($arr[0],';')==false && strpos($arr[1],';')>-1){
				$err=explode(',', $arr[0]);
				$grr=explode(';', $arr[1]);
				$crr=array_pop($grr);
				$dan=count($grr);
				$drr=explode(',', $crr);
				$grr=array_merge($grr,$drr);
				$first=count(array_intersect($zjj_q,$err));
			 	$last=count(array_intersect($zjj_h,$grr));

			//一个蓝胆
	 			if($dan==1){
		 			if($first==5 && $last==2){
		 				if(count($err)==5){
		 					$x['one']=1;
		 					// echo '中了一等奖';
			 				// echo '<br>';

			 				$d=su(1,(count($grr)-2));
			 				$x['two']=$d;
			 				// echo '中了二等奖'.'('.$d.'次)';
			 				// echo '<br>';

		 				}

		 				if(count($err)>5){
		 					$x['one']=1;
		 					// $one='中了一等奖';
			 				// echo $one;
			 				// echo '<br>';

			 				$c=count($grr)-2;
			 				$tt=su(1,$c);
			 				$x['two']=$tt;
			 				// echo '中了二等奖'.'('.$tt.'次)';
			 				// echo '<br>';

		 					$e=su(4,5)*su(1,(count($err)-5));
		 					$x['three']=$e;
		 					// echo '中了三等奖'.'('.$e.'次)';	
		 					// echo '<br>';
			 				
			 				if(count($err)==6){
			 					$f=su(4,5)*su(1,(count($err)-5));
			 					$g=su(1,count($grr)-2);
			 					$ff=$f*$g;
			 					$x['four']=$ff;
			 					// echo '中了四等奖'.'('.$ff.'次)';
			 					// echo '<br>';
				 			}
				 				
				 			if(count($err)>6){
			 					$f=su(4,5)*su(1,(count($err)-5));
			 					$g=su(1,count($grr)-2);
			 					$ff=$f*$g;
			 					$h=su(3,5)*su(2,(count($err)-5))+$ff;
			 					$x['four']=$h;
			 					// echo '中了四等奖'.'('.$h.'次)';
			 					// echo '<br>';
								
				 			}

			 				if(count($err)==7){
			 					$p=su(3,5)*su(2,(count($err)-5));
			 					$q=su(1,(count($grr)-2));
			 					$pp=$p*$q;
			 					$x['five']=$pp;
			 					// echo '中了五等奖'.'('.$pp.'次)';
			 					// echo '<br>';
			 				}

			 				if(count($err)>7 ){
			 					$p=su(3,5)*su(2,(count($err)-5));
			 					$q=su(1,(count($grr)-2));
			 					$pp=$p*$q;

			 					$r=su(2,5)*su(3,(count($err)-5));
			 					$rr=$pp+$r;
			 					$x['five']=$rr;
			 					// echo '中了五等奖'.'('.$rr.'次)';
			 					// echo '<br>';

			 				}

			 				if(count($err)==8){
			 					$v=su(2,5)*su(3,(count($err)-5));
			 					$vv=su(1,(count($grr)-2));
			 					$vvv=$v*$vv;
			 					$x['six']=$vvv;
			 					// echo '中了六等奖'.'('.$vvv.'次)';
			 				}if(count($err)==9 ){
			 					$v=su(2,5)*su(3,(count($err)-5));
			 					$vv=su(1,(count($err)-2));
			 					$vvv=$v*$vv;

			 					$u=su(1,5)*su(4,(count($err)-5));
			 					$vu=$vvv+$u;
			 					$x['six']=$vu;
			 					// echo '中了六等奖'.'('.$vu.'次)';
			 				}if(count($err)>9){
			 					$v=su(2,5)*su(3,(count($err)-5));
			 					$vv=su(1,(count($err)-2));
			 					$vvv=$v*$vv;

			 					$u=su(1,5)*su(4,(count($err)-5));
			 					
			 					$w=su(5,(count($err)-5));
			 					$ww=$vvv+$u+$w;
			 					$x['six']=$ww;
			 					// echo '中了六等奖'.'('.$ww.'次)';
			 				}
		 				}
		 						return $x;
		 			}elseif($first==5 && $last==1){
		 				if(count($err)==5){
		 					$c=count($grr)-1;			 			
			 				$two=su(1,$c);
			 				$x['two']=$two;
			 				// echo '中了二等奖'.'('.$two.'次)';
			 				// echo '<br>';

		 				}

		 				if(count($err)>5){
		 					$c=count($grr)-1;			 			
			 				$two=su(1,$c);
			 				$x['two']=$two;
			 				// echo '中了二等奖'.'('.$two.'次)';
			 				// echo '<br>';

			 				$e=su(4,5)*su(1,(count($err)-5));
			 				$ee=su(1,(count($grr)-1));
			 				$eee=$e*$ee;
			 				$x['four']=$eee;
			 				// echo '中了四等奖'.'('.$eee.'次)';
			 				// echo '<br>';

			 				if(count($err)>6){
			 					$g=su(3,5)*su(2,(count($err)-5));
			 					$gg=su(1,(count($grr)-1));
			 					$ggg=$g*$gg;
			 					$x['five']=$ggg;
			 					// echo '中了五等奖'.'('.$fg.'次)';
			 					// echo '<br>';

			 				}

			 				if(count($err)>7){
			 					$v=su(2,5)*su(3,(count($err)-5));
			 					$vv=su(1,(count($grr)-1));
			 					$vvv=$v*$vv;
			 					$x['six']=$vvv;
			 					// echo '中了六等奖'.'('.$sv.'次)';
			 					// echo '<br>';
			 				}
		 				}
		 						return $x;
		 			}elseif($first==4 && $last==2){
		 				if(count($err)==5){
		 					$x['three']=1;
		 					// echo '中了三等奖';
			 				// echo '<br>';

			 				$c=su(1,(count($grr)-2));
			 				$x['four']=$c;
			 				// echo '中了四等奖'.'('.$c.'次)';
			 				// echo '<br>';
		 				}

		 				if(count($err)>5){
		 					$j=su(1,(count($err)-4));
		 					$x['three']=$j;
		 					// echo '中了三等奖'.'('.$j.'次)'; 
		 					// echo '<br>';

			 				if(count($err)==6){
			 					$f=su(1,(count($err)-4));
			 					$g=su(1,count($grr)-2);
			 					$ff=$f*$g;
			 					$x['four']=$ff;
			 					// echo '中了四等奖'.'('.$ff.'次)';
			 					// echo '<br>';
				 			}
				 				
				 			if(count($err)>6){
			 					$f=su(1,(count($err)-4));
			 					$g=su(1,count($grr)-2);
			 					$ff=$f*$g;
			 					$h=su(3,4)*su(2,(count($err)-4))+$ff;
			 					$x['four']=$h;
			 					// echo '中了四等奖'.'('.$h.'次)';
			 					// echo '<br>';
				 			}

							if(count($err)==6){
			 					$p=su(3,4)*su(2,(count($err)-4));
			 					$q=su(1,(count($grr)-2));
			 					$pp=$p*$q;
			 					$x['five']=$pp;
			 					// echo '中了五等奖'.'('.$pp.'次)';
			 					// echo '<br>';
			 				}

			 				if(count($err)>7){
			 					$p=su(3,4)*su(2,(count($err)-4));
			 					$q=su(1,(count($grr)-2));
			 					$pp=$p*$q;

			 					$r=su(2,4)*su(3,(count($err)-4));
			 					$rr=$pp+$r;
			 					$x['five']=$rr;
			 					// echo '中了五等奖'.'('.$rr.'次)';
			 					// echo '<br>';
			 				}

			 				if(count($err)==7){
		 						$v=su(2,4)*su(3,(count($err)-4));
			 					$vv=su(1,(count($grr)-2));
			 					$vvv=$v*$vv;
			 					$x['six']=$vvv;
			 					// echo '中了六等奖'.'('.$vvv.'次)';
			 					// echo '<br>';
			 				}

			 				if(count($err)==8){
			 					$v=su(2,4)*su(3,(count($err)-4));
			 					$vv=su(1,(count($grr)-2));
			 					$vvv=$v*$vv;

			 					$u=su(1,4)*su(4,(count($err)-4));
			 					$vu=$vvv+$u;
			 					$x['six']=$vu;
			 					// echo '中了六等奖'.'('.$vu.'次)';
			 					// echo '<br>';
			 				}elseif(count($err)>8){
			 					$v=su(2,4)*su(3,(count($err)-4));
			 					$vv=su(1,(count($grr)-2));
			 					$vvv=$v*$vv;

			 					$u=su(1,4)*su(4,(count($err)-4));
			 					
			 					$w=su(5,(count($err)-4));
			 					$ww=$vvv+$u+$w;
			 					$x['six']=$ww;
			 					// echo '中了六等奖'.'('.$ww.'次)';
			 					// echo '<br>';
			 				}
		 				}	
		 						return $x;
		 			}elseif($first==4 && $last==1){
		 				if(count($err)==5){
		 					$c=count($grr)-1;			 			
			 				$four=su(1,$c);
			 				$x['four']=$four;
			 				 // echo '中了四等奖'.'('.$four.'次)';
			 				 // echo '<br>';
		 				}

		 				if(count($err)>5){
		 					$k=su(1,(count($err)-4));
			 				$kk=su(1,(count($grr)-1));
			 				$kkk=$k*$kk;
			 				$x['four']=$kkk;
			 				// echo '中了四等奖'.'('.$kkk.'次)';
			 				// echo '<br>'; 

			 				if(count($err)>5){
			 					$p=su(3,4)*su(2,(count($err)-4));
			 					$q=su(1,(count($grr)-1));
			 					$pp=$p*$q;
			 					$x['five']=$pp;
			 					// echo '中了五等奖'.'('.$pp.'次)';
			 					// echo '<br>';
		 					}

			 				if(count($err)>6){
			 					$v=su(2,4)*su(3,(count($err)-4));
			 					$vv=su(1,(count($grr)-1));
			 					$vvv=$v*$vv;
			 					$x['six']=$vvv;
			 					// echo '中了六等奖'.'('.$vvv.'次)';
			 				}
		 				}
		 						return $x;
		 			}elseif($first==3 && $last==2){
		 				if(count($err)==5){
		 					$x['four']=1;
		 					// echo '中了四等奖';
			 				// echo '<br>';

			 				$c=su(1,count($grr)-2);
			 				$x['five']=$c;
			 				// echo '中了五等奖'.'('.$c.'次)';
			 				// echo '<br>';
		 				}

		 				if(count($err)>5){
		 					$j=su(2,(count($err)-3));
		 					$x['four']=$j;
			 				// echo '中了四等奖'.'('.$j.'次)';

		 				
		 					$p=su(2,(count($err)-3));
		 					$q=su(1,(count($grr)-2));
		 					$pp=$p*$q;
		 					$x['five']=$pp;
		 					// echo '中了五等奖'.'('.$pp.'次)';
		 					// echo '<br>'; 
			 				if(count($err)>5 && count($grr)>3){
			 					$p=su(2,(count($err)-3));
		 						$q=su(1,(count($grr)-2));
		 						$pp=$p*$q;

			 					$r=su(2,3)*su(3,(count($err)-3));
			 					$rr=$pp+$r;
			 					$x['five']=$rr;
			 					// echo '中了五等奖'.'('.$rr.'次)';
			 					// echo '<br>';

			 				}


			 				if(count($err)==6){
			 					$v=su(2,3)*su(3,(count($err)-3));
			 					$vv=su(1,(count($err)-2));
			 					$vvv=$v*$vv;
			 					$x['six']=$vvv;
			 					// echo '中了六等奖'.'('.$vvv.'次)';
			 				}elseif(count($err)==7){
			 					$v=su(2,3)*su(3,(count($err)-3));
			 					$vv=su(1,(count($grr)-2));
			 					$vvv=$v*$vv;

			 					$u=su(1,3)*su(4,(count($err)-3));
			 					$vu=$vvv+$u;
			 					$x['six']=$vu;
			 					// echo '中了六等奖'.'('.$vu.'次)';
			 				}if(count($err)>7){
			 					$v=su(2,3)*su(3,(count($err)-3));
			 					$vv=su(1,(count($grr)-2));
			 					$vvv=$v*$vv;

			 					$u=su(1,3)*su(4,(count($err)-3));
			 					
			 					$w=su(5,(count($err)-3));
			 					$ww=$vvv+$u+$w;
			 					$x['six']=$ww;
			 					// echo '中了六等奖'.'('.$ww.'次)';
			 				}
		 				}
		 						return $x;
		 			}elseif($first==3 && $last==1){
		 				if(count($err)==5){
		 					$c=count($grr)-1;			 			
			 				$five=su(1,$c);
			 				$x['five']=$five;
			 				// echo '中了五等奖'.'('.$five.'次)';
			 				// echo '<br>';
		 				}

		 				if(count($err)>5){
		 					$j=su(2,(count($err)-3));
			 				$jj=su(1,(count($grr)-1));
			 				$jjj=$j*$jj;
			 				$x['five']=$jjj;
			 				// echo '中了五等奖'.'('.$jjj.'次)';
			 				
		 					$v=su(2,3)*su(3,(count($err)-3));
		 					$vv=su(1,(count($grr)-1));
		 					$vvv=$v*$vv;
		 					$x['six']=$vvv;
		 					// echo '中了六等奖'.'('.$vvv.'次)';
		 				}
		 						return $x;
		 			}elseif($first==2 && $last==2){
		 				if(count($err)==5){
		 					$x['five']=1;
		 					// echo '中了五等奖';

			 				$j=su(1,(count($grr)-2));
			 				$x['six']=$j;
			 				// echo '中了六等奖'.'('.$j.'次)';
			 				// echo '<br>';
		 				}

		 				if(count($err)>5){
		 					$j=su(3,(count($brr)-2));
		 					$x['five']=$j;
			 				// echo '中了五等奖'.'('.$j.'次)';

							if(count($err)>5){
			 					$v=su(3,(count($err)-2));
			 					$vv=su(1,(count($grr)-2));
			 					$vvv=$v*$vv;

			 					$u=2*su(4,(count($err)-2));
			 					$vu=$vvv+$u;
			 					$x['six']=$vu;
			 					// echo '中了六等奖'.'('.$vu.'次)';
			 				}elseif(count($err)>6){
			 					$v=su(3,(count($err)-2));
			 					$vv=su(1,(count($grr)-2));
			 					$vvv=$v*$vv;

			 					$u=2*su(4,(count($err)-2));
			 					
			 					$w=su(5,(count($err)-2));
			 					$ww=$vvv+$u+$w;
			 					$x['six']=$ww;
			 					// echo '中了六等奖'.'('.$ww.'次)';
			 				}
		 				}
		 						return $x;
	 				}elseif($first==1 && $last==2){
	 					if(count($err)==5){
	 						$x['six']=1;
			 				// echo '中了六等奖'.'('.$k.'次)';
	 					}

	 					if(count($err)>5){
	 						$k=su(4,(count($err)-1));
	 						$j=su(5,(count($err)-1));
	 						$kj=$k+$j;
	 						$x['six']=$kj;
			 				// echo '中了六等奖'.'('.$kj.'次)';
	 					}
	 						return $x;
	 				}elseif($first==2 && $last==1){
	 					if(count($err)==5){
	 						$x['six']=1;
	 						// echo '中了六等奖';
	 					}

	 					if(count($err)>5){
	 						$j=su(3,(count($err)-2));
	 						$x['six']=$j;
	 						// echo '中了六等奖'.'('.$j.'次)';
	 					}
	 				}

	 						return $x;
	 			}
			}



	//有蓝胆有红胆	
			if(strpos($arr[0],';')>-1 && strpos($arr[1],';')>-1){
				$brr=explode(';', $arr[0]);
				$mrr=explode(';', $arr[1]);
				$crr=array_pop($brr);
				$hrr=array_pop($mrr);
				$rdan=count($brr);
				$bdan=count($mrr);
				$drr=explode(',', $crr);
				$krr=explode(',', $hrr);
				$err=array_merge($brr,$drr);
				$grr=array_merge($mrr,$krr);
				$first=count(array_intersect($zjj_q,$err));
			 	$last=count(array_intersect($zjj_h,$grr));

			//1红1蓝
			 	if($rdan==1 && $bdan==1){
			 		if($first==5 && $last==2){
			 			$x['one']=1;
						// echo '中了一等奖';
						// echo '<br>';

						if(count($grr)>2){
							$j=su(1,(count($grr)-2));
							$x['two']=$j;
							// echo '中了二等奖'.'('.$j.'次)';
							// echo '<br>';
						}

						if(count($grr)==3){
							$e=su(3,4)*su(1,(count($err)-5));
							$x['three']=$e;
							// echo '中了三等奖'.'('.$e.'次)';	
							// echo '<br>';
						}

						if(count($err)==6 && count($grr)>2){
							$f=su(3,4)*su(1,(count($err)-5));
							$g=su(1,count($grr)-2);
							$ff=$f*$g;
							$x['four']=$ff;
							// echo '中了四等奖'.'('.$ff.'次)';
							// echo '<br>';
						}
								
						if(count($err)>6 && count($grr)>2 ){
							$f=su(3,4)*su(1,(count($err)-5));
							$g=su(1,count($grr)-2);
							$ff=$f*$g;
							$h=su(2,4)*su(2,(count($err)-5))+$ff;
							$x['four']=$h;
							// echo '中了四等奖'.'('.$h.'次)';
							// echo '<br>';
						}

						if(count($err)==7 && count($grr)>2){
							$p=su(2,4)*su(2,(count($err)-5));
							$q=su(1,(count($grr)-2));
							$pp=$p*$q;
							$x['five']=$pp;
							// echo '中了五等奖'.'('.$pp.'次)';
							// echo '<br>';
						}

						if(count($err)>7){
							$p=su(2,4)*su(2,(count($err)-5));
							$q=su(1,(count($grr)-2));
							$pp=$p*$q;

							$r=su(1,4)*su(3,(count($err)-5));
							$rr=$pp+$r;
							$x['five']=$rr;
							// echo '中了五等奖'.'('.$rr.'次)';
							// echo '<br>';
						}

		 				if(count($err)==8){
		 					$v=su(1,4)*su(3,(count($err)-5));
		 					$vv=su(1,(count($grr)-2));
		 					$vvv=$v*$vv;
		 					$x['six']=$vvv;
		 					// echo '中了六等奖'.'('.$vvv.'次)';
		 				}elseif(count($err)>8){
			 					
		 					$v=su(1,4)*su(3,(count($err)-5));
		 					$vv=su(1,(count($grr)-2));
		 					$vvv=$v*$vv;

		 					$u=su(4,(count($err)-5));
		 					$vu=$vvv+$u;
		 					$x['six']=$vu;
		 					// echo '中了六等奖'.'('.$vu.'次)';
		 				}
		 					return $x;

				 	}elseif($first==5 && $last==1){
		 			
		 				$j=su(1,(count($grr)-1));
		 				$x['two']=$j;
		 				// echo '中了二等奖'.'('.$j.'次)';

		 				$e=su(3,4)*su(1,(count($err)-5));
		 				$ee=su(1,(count($grr)-1));
		 				$eee=$e*$ee;
		 				$x['four']=$eee;
		 				// echo '中了四等奖'.'('.$eee.'次)';
		 				// echo '<br>';

						if(count($err)>6){
		 					$g=su(2,4)*su(2,(count($err)-5));
		 					$gg=su(1,(count($grr)-1));
		 					$ggg=$g*$gg;
		 					$x['five']=$ggg;
		 					// echo '中了五等奖'.'('.$ggg.'次)';
		 					// echo '<br>';
		 				}

		 				if(count($err)>7){
		 					$v=su(1,4)*su(3,(count($err)-5));
		 					$vv=su(1,(count($grr)-1));
		 					$vvv=$v*$vv;

		 					$sv=$sss+$vvv;
		 					$x['six']=$sv;
		 					// echo '中了六等奖'.'('.$sv.'次)';
		 					// echo '<br>';
		 				}
			 				return $x;

				 	}elseif($first==4 && $last==2){
			 			if(count($grr)>2){
			 				$j=su(1,(count($err)-4));
			 				$x['three']=$j;
		 					// echo '中了三等奖'.'('.$j.'次)'; 
		 					// echo '<br>';
				 				
				 			if(count($err)>5){
			 					$f=su(1,(count($err)-4));
			 					$g=su(1,count($grr)-2);
			 					$ff=$f*$g;
			 					$h=su(2,3)*su(2,(count($err)-4))+$ff;
			 					$x['four']=$h;
			 					// echo '中了四等奖'.'('.$h.'次)';
			 					// echo '<br>';
			 				}

							if(count($err)==6){
			 					$p=su(2,3)*su(2,(count($err)-4));
			 					$q=su(1,(count($grr)-2));
			 					$pp=$p*$q;
			 					$x['five']=$pp;
			 					// echo '中了五等奖'.'('.$pp.'次)';
			 					// echo '<br>';
			 				}

			 				if(count($err)>6){
			 					$p=su(2,3)*su(2,(count($err)-4));
			 					$q=su(1,(count($grr)-2));
			 					$pp=$p*$q;

			 					$r=su(1,3)*su(3,(count($err)-4));
			 					$rr=$pp+$r;
			 					$x['five']=$rr;
			 					// echo '中了五等奖'.'('.$rr.'次)';
			 					// echo '<br>';

			 				}

			 				if(count($err)>6 ){
		 						$v=su(1,3)*su(3,(count($err)-4));
			 					$vv=su(1,(count($grr)-2));
			 					$vvv=$v*$vv;
			 					$x['six']=$vvv;
			 					// echo '中了六等奖'.'('.$vvv.'次)';
			 					// echo '<br>';
			 				}

			 				if(count($err)>7 && count($grr)>3){
			 					$v=su(1,3)*su(3,(count($err)-4));
			 					$vv=su(1,(count($grr)-2));
			 					$vvv=$v*$vv;

			 					$u=su(4,(count($err)-4));
			 					$vu=$vvv+$u;
			 					$x['six']=$vu;
			 					// echo '中了六等奖'.'('.$vu.'次)';
			 					// echo '<br>';
			 				}
			 			}
					 				return $x;

				 	}elseif($first==4 && $last==1){
			 			if(count($grr)>2){
			 				$k=su(1,(count($err)-4));
			 				$kk=su(1,(count($grr)-1));
			 				$kkk=$k*$kk;
			 				$x['four']=$kkk;
			 				// echo '中了四等奖'.'('.$kkk.'次)';
			 				// echo '<br>'; 

							if(count($err)>5){
			 					$p=su(2,3)*su(2,(count($err)-4));
			 					$q=su(1,(count($grr)-1));
			 					$pp=$p*$q;
			 					$x['five']=$pp;
			 					// echo '中了五等奖'.'('.$pp.'次)';
			 					// echo '<br>';

			 				}

			 				if(count($err)>6){
			 					$v=su(1,3)*su(3,(count($err)-4));
			 					$vv=su(1,(count($grr)-1));
			 					$vvv=$v*$vv;
			 					$x['six']=$vvv;
			 					// echo '中了六等奖'.'('.$vvv.'次)';
			 				}
			 			}
			 					return $x;
				 	}elseif($first==3 && $last==2){
				 		if(count($grr)>2){
				 			$j=su(2,(count($err)-3));
				 			$x['four']=$j;
			 				// echo '中了四等奖'.'('.$j.'次)';

			 				if(count($err)>5){
			 					$p=su(2,(count($err)-3));
			 					$q=su(1,(count($grr)-2));
			 					$pp=$p*$q;

			 					$r=su(1,2)*su(3,(count($err)-3));
			 					$rr=$pp+$r;
			 					$x['five']=$rr;
			 					// echo '中了五等奖'.'('.$rr.'次)';
			 					// echo '<br>';
			 				}

			 				if(count($err)==6){
			 					$v=su(1,2)*su(3,(count($err)-3));
			 					$vv=su(1,(count($grr)-2));
			 					$vvv=$v*$vv;
			 					$x['six']=$vvv;
			 					// echo '中了六等奖'.'('.$vvv.'次)';
			 				}elseif(count($err)>6){
			 					$v=su(1,2)*su(3,(count($err)-3));
			 					$vv=su(1,(count($grr)-2));
			 					$vvv=$v*$vv;

			 					$u=su(4,(count($err)-3));
			 					$sv=$vvv+$u;
			 					$x['six']=$sv;
			 					// echo '中了六等奖'.'('.$sv.'次)';
			 				}

				 		}
				 			return $x;
					}elseif($first==3 && $last==1){
						if(count($grr)>2){
							$j=su(2,(count($err)-3));
							$jj=su(1,(count($grr)-1));
							$jjj=$j*$jj;
							$x['five']=$jjj;
							// echo '中了五等奖'.'('.$jjj.'次)';

							if(count($err)>5){
								$v=su(1,2)*su(3,(count($err)-3));
								$vv=su(1,(count($grr)-1));
								$vvv=$v*$vv;
								$x['six']=$vvv;
								// echo '中了六等奖'.'('.$vvv.'次)';
							}
						}
								return $x;
					}elseif($first==2 && $last==2){
						if(count($grr)>2){
							$j=su(3,(count($err)-2));
							$x['five']=$j;
							// echo '中了五等奖'.'('.$j.'次)';

							if(count($err)>5){
								$v=su(3,(count($err)-2));
								$vv=su(1,(count($grr)-2));
								$vvv=$v*$vv;

								$u=su(4,(count($err)-2));
								$vu=$vvv+$u;
								$x['six']=$vu;
								// echo '中了六等奖'.'('.$vu.'次)';
							}

						}
							return $x;
					}elseif($first==1 && $last==2){
						$k=su(4,(count($err)-1));
						$x['six']=$k;
						// echo '中了六等奖'.'('.$j.'次)';

							return $x;
					}elseif($first==2 && $last==1){
						if(count($grr)>2){
							$k=su(3,(count($err)-2));
							$kk=su(1,(count($grr)-1));
							$kkk=$k*$kk;
							$x['six']=$kkk;
							// echo '中了六等奖'.'('.$kkk.'次)';
						}
						return $x;
					}
		 		}
		 	//2红1蓝
		 		if($rdan==2 && $bdan==1){
		 			if($first==5 && $last==2){
		 				$x['one']=1;
				 		// echo '中了一等奖';
				 		// echo '<br>';

			 			$j=su(1,(count($grr)-2));
			 			$x['two']=$j;
			 			// echo '中了二等奖'.'('.$j.'次)';
			 			// echo '<br>';
			 		
	 					$e=su(2,3)*su(1,(count($err)-5));
	 					$x['three']=$e;
	 					// echo '中了三等奖'.'('.$e.'次)';	
	 					// echo '<br>';
		 				

		 				if(count($err)==6 && count($grr)>2){
		 					$f=su(2,3)*su(1,(count($err)-5));
		 					$g=su(1,count($grr)-2);
		 					$ff=$f*$g;
		 					$x['four']=$ff;
		 					// echo '中了四等奖'.'('.$ff.'次)';
		 					// echo '<br>';
		 				}
				 				
			 			if(count($err)>6 && count($grr)>2 ){
		 					$f=su(2,3)*su(1,(count($err)-5));
		 					$g=su(1,count($grr)-2);
		 					$ff=$f*$g;
		 					$h=su(1,3)*su(2,(count($err)-5))+$ff;
		 					$x['four']=$h;
		 					// echo '中了四等奖'.'('.$h.'次)';
		 					// echo '<br>';
							
		 				}

			 			if(count($err)==7 && count($grr)>2){
		 					$p=su(1,3)*su(2,(count($err)-5));
		 					$q=su(1,(count($grr)-2));
		 					$pp=$p*$q;
		 					$x['five']=$pp;
		 					// echo '中了五等奖'.'('.$pp.'次)';
		 					// echo '<br>';
		 				}

		 				if(count($err)>7 && count($grr)==3){
		 					$p=su(1,3)*su(2,(count($err)-5));
		 					$q=su(1,(count($grr)-2));
		 					$pp=$p*$q;

		 					$r=su(3,(count($err)-5));
		 					$rr=$pp+$r;
		 					$x['five']=$rr;
		 					// echo '中了五等奖'.'('.$rr.'次)';
		 					// echo '<br>';

		 				}

		 				if(count($err)>7 && count($grr)==3){
		 					$v=su(3,(count($err)-5));
		 					$vv=su(1,(count($grr)-2));
		 					$vvv=$v*$vv;
		 					$x['six']=$vvv;
		 					// echo '中了六等奖'.'('.$vvv.'次)';
	 					}
	 						return $x;
				 	}elseif($first==5 && $last==1){
			 			if(count($grr)>2){
			 				$j=su(1,(count($grr)-1));
			 				$x['two']=$j;
			 				// echo '中了二等奖'.'('.$j.'次)';

			 				$e=su(2,3)*su(1,(count($err)-5));
			 				$ee=su(1,(count($grr)-1));
			 				$eee=$e*$ee;
			 				$x['four']=$eee;
			 				// echo '中了四等奖'.'('.$eee.'次)';
			 				// echo '<br>';

			 				if(count($err)>6){
			 					$g=su(1,3)*su(2,(count($err)-5));
			 					$gg=su(1,(count($grr)-1));
			 					$ggg=$g*$gg;
			 					$x['five']=$ggg;
			 					// echo '中了五等奖'.'('.$ggg.'次)';
			 					// echo '<br>';

			 				}

			 				if(count($err)>7){
				 					$v=su(3,(count($err)-5));
				 					$vv=su(1,(count($grr)-1));
				 					$vvv=$v*$vv;
				 					$x['six']=$vvv;
				 					// echo '中了六等奖'.'('.$sv.'次)';
				 					// echo '<br>';
			 				}

			 			}
			 					return $x;

				 	}elseif($first==4 && $last==2){
			 			if(count($grr)>2){
			 				$j=su(1,(count($err)-4));
			 				$x['three']=$j;
		 					// echo '中了三等奖'.'('.$j.'次)'; 
		 					// echo '<br>';
				 				
				 			if(count($err)>5){
			 					$f=su(1,(count($err)-4));
			 					$g=su(1,count($grr)-2);
			 					$ff=$f*$g;
			 					$h=su(1,2)*su(2,(count($err)-4))+$ff;
			 					$x['four']=$h;
			 					// echo '中了四等奖'.'('.$h.'次)';
			 					// echo '<br>';
				 			}

							if(count($err)>5){
			 					$p=su(1,2)*su(2,(count($err)-4));
			 					$q=su(1,(count($grr)-2));
			 					$pp=$p*$q;
			 					$x['five']=$pp;
			 					// echo '中了五等奖'.'('.$pp.'次)';
			 					// echo '<br>';
			 				}

			 				if(count($err)>6){
			 					$p=su(1,2)*su(2,(count($err)-4));
			 					$q=su(1,(count($grr)-2));
			 					$pp=$p*$q;

			 					$r=su(3,(count($err)-4));
			 					$rr=$pp+$r;
			 					$x['five']=$rr;
			 					// echo '中了五等奖'.'('.$rr.'次)';
			 					// echo '<br>';

			 				}

			 				if(count($err)>6){
		 						$v=su(3,(count($err)-4));
			 					$vv=su(1,(count($grr)-2));
			 					$vvv=$v*$vv;
			 					$x['six']=$vvv;
			 					// echo '中了六等奖'.'('.$vvv.'次)';
			 					// echo '<br>';
			 				}

				 		}
				 			
				 			return $x;
				 	}elseif($first==4 && $last==1){
			 			if(count($grr)>2){
			 				$k=su(1,(count($err)-4));
			 				$kk=su(1,(count($grr)-1));
			 				$kkk=$k*$kk;
			 				$x['four']=$kkk;
			 				// echo '中了四等奖'.'('.$kkk.'次)';
			 				// echo '<br>'; 

							if(count($err)>5){
			 					$p=su(1,2)*su(2,(count($err)-4));
			 					$q=su(1,(count($grr)-1));
			 					$pp=$p*$q;
			 					$x['five']=$pp;
			 					// echo '中了五等奖'.'('.$pp.'次)';
			 					// echo '<br>';

			 				}

			 				if(count($err)>6){
			 					$v=su(3,(count($err)-4));
			 					$vv=su(1,(count($grr)-1));
			 					$vvv=$v*$vv;
			 					$x['six']=$vvv;
			 					// echo '中了六等奖'.'('.$vvv.'次)';
			 				}
			 			}
			 					return $x;
				 	}elseif($first==3 && $last==2){
				 		if(count($grr)>2){
				 			$j=su(2,(count($err)-3));
				 			$x['five']=$j;
			 				// echo '中了四等奖'.'('.$j.'次)';

							if(count($err)>5){
			 					$p=su(2,(count($err)-3));
			 					$q=su(1,(count($grr)-2));
			 					$pp=$p*$q;

			 					$r=su(3,(count($err)-3));
			 					$rr=$pp+$r;
			 					$x['five']=$rr;
			 					// echo '中了五等奖'.'('.$rr.'次)';
			 					// echo '<br>';

			 				}

			 				if(count($err)>5){
			 					$v=su(3,(count($err)-3));
			 					$vv=su(1,(count($grr)-2));
			 					$vvv=$v*$vv;
			 					$x['six']=$vvv;
			 					// echo '中了六等奖'.'('.$vvv.'次)';
			 				}
				 		}
				 				return $x;
				 	}elseif($first==3 && $last==1){
				 	   		if(count($grr)>2){
				 	   			$j=su(2,(count($err)-3));
				 				$jj=su(1,(count($grr)-1));
				 				$jjj=$j*$jj;
				 				$x['five']=$jjj;
				 				// echo '中了五等奖'.'('.$jjj.'次)';
				 				
				 				if(count($err)>5){
				 					$v=su(3,(count($err)-3));
				 					$vv=su(1,(count($grr)-1));
				 					$vvv=$v*$vv;
				 					$x['six']=$vvv;
				 					// echo '中了六等奖'.'('.$vvv.'次)';
				 				}
				 	   		}
				 	   			return $x;
			 	   	}elseif($first==2 && $last==2){
			 	   		if(count($grr)>2){
			 	   			$j=su(3,(count($err)-2));
			 	   			$x['five']=$j;
			 				// echo '中了五等奖'.'('.$j.'次)';

		 					$v=su(3,(count($err)-2));
		 					$vv=su(1,(count($grr)-2));
		 					$vvv=$v*$vv;
		 					$x['six']=$vvv;
		 					// echo '中了六等奖'.'('.$vvv.'次)';
			 				
			 	   		}

			 	   	}elseif($first==2 && $last==1){
			 	   			$k=su(3,(count($err)-2));
			 	   			$kk=su(1,(count($grr)-1));
			 	   			$kkk=$k*$kk;
			 	   			$x['six']=$kk;
			 	   			// echo '中了六等奖'.'('.$kkk.'次)';
				 	}
				 	return $x;
		 		}

		 		//3红1蓝
		 		if($rdan==3 && $bdan==1){
		 			if($first==5 && $last==2){
		 				$x['one']=1;
			 		// echo '中了一等奖';
			 		// echo '<br>';

		 			$j=su(1,(count($grr)-2));
		 			$x['two']=$j;
		 			// echo '中了二等奖'.'('.$j.'次)';
		 			// echo '<br>';
 			
 					$e=su(1,2)*su(1,(count($err)-5));
 					$x['three']=$e;
 					// echo '中了三等奖'.'('.$e.'次)';	
 					// echo '<br>';

	 				if(count($err)==6){
			 			$f=su(1,2)*su(1,(count($err)-5));
			 			$g=su(1,count($grr)-2);
			 			$ff=$f*$g;
			 			$x['four']=$ff;
			 			// echo '中了四等奖'.'('.$ff.'次)';
			 			// echo '<br>';
			 		}
				 				
		 			if(count($err)>6){
		 				$f=su(1,2)*su(1,(count($err)-5));
		 				$g=su(1,count($grr)-2);
		 				$ff=$f*$g;
		 				$h=su(2,(count($err)-5))+$ff;
		 				$x['four']=$h;
		 				// echo '中了四等奖'.'('.$h.'次)';
		 				// echo '<br>';	
		 			}

		 			if(count($err)==7){
			 			$p=su(2,(count($err)-5));
			 			$q=su(1,(count($grr)-2));
			 			$pp=$p*$q;
			 			$x['five']=$pp;
			 			// echo '中了五等奖'.'('.$pp.'次)';
			 			// echo '<br>';
		 			}

	 				if(count($err)>7){
		 				$p=su(2,(count($err)-5));
		 				$q=su(1,(count($grr)-2));
		 				$pp=$p*$q;

		 				$r=su(3,(count($err)-5));
		 				$rr=$pp+$r;
		 				$x['five']=$rr;
		 				// echo '中了五等奖'.'('.$rr.'次)';
		 				// echo '<br>';
	 				}
	 					return $x;
			 	}elseif($first==5 && $last==1){
			 		if(count($grr)>2){
			 			$j=su(1,(count($grr)-1));
			 			$x['two']=$j;
			 			// echo '中了二等奖'.'('.$j.'次)';

			 			$e=su(1,2)*su(1,(count($err)-5));
			 			$ee=su(1,(count($grr)-1));
			 			$eee=$e*$ee;
			 			$x['four']=$eee;
		 				// echo '中了四等奖'.'('.$eee.'次)';
		 				// echo '<br>';
						if(count($err)>6){
		 					$g=su(2,(count($err)-5));
		 					$gg=su(1,(count($grr)-1));
		 					$ggg=$g*$gg;
		 					$x['five']=$ggg;
		 					// echo '中了五等奖'.'('.$ggg.'次)';
		 					// echo '<br>';

		 				}
				 	}
				 			return $x;
			 	}elseif($first==4 && $last==2){
		 			if(count($grr)>2){
		 				$j=su(1,(count($err)-4));
		 				$x['three']=$j;
	 					// echo '中了三等奖'.'('.$j.'次)'; 
	 					// echo '<br>';
			 				
			 			if(count($err)>5){
		 					$f=su(1,(count($err)-4));
		 					$g=su(1,count($grr)-2);
		 					$ff=$f*$g;
		 					$h=su(2,(count($err)-4))+$ff;
		 					$x['four']=$h;
		 					// echo '中了四等奖'.'('.$h.'次)';
		 					// echo '<br>';
							
		 				}

						if(count($err)>5){
		 					$p=su(2,(count($err)-4));
		 					$q=su(1,(count($grr)-2));
		 					$pp=$p*$q;
		 					$x['five']=$pp;
		 					// echo '中了五等奖'.'('.$pp.'次)';
		 					// echo '<br>';
		 				}
				 	}
				 			
				 		return $x;
			 	}elseif($first==4 && $last==1){
		 			if(count($grr)>2){
		 				$k=su(1,(count($err)-4));
		 				$kk=su(1,(count($grr)-1));
		 				$kkk=$k*$kk;
		 				$x['four']=$kkk;
		 				// echo '中了四等奖'.'('.$kkk.'次)';
		 				// echo '<br>'; 

						if(count($err)>5){
		 					$p=su(2,(count($err)-4));
		 					$q=su(1,(count($grr)-1));
		 					$pp=$p*$q;
		 					$x['five']=$pp;
		 					// echo '中了五等奖'.'('.$pp.'次)';
		 					// echo '<br>';

		 				}
		 			}

		 				return $x;
			 	}elseif($first==3 && $last==2){
			 		if(count($grr)>2){
			 			$j=su(2,(count($err)-3));
			 			$x['four']=$j;
		 				// echo '中了四等奖'.'('.$j.'次)';

	 					$p=su(2,(count($err)-3));
	 					$q=su(1,(count($grr)-2));
	 					$pp=$p*$q;
	 					$x['five']=$pp;
	 					// echo '中了五等奖'.'('.$pp.'次)';
	 					// echo '<br>'; 
			 		}
			 			return $x;
			 	}elseif($first==3 && $last==1){
		 	   		if(count($grr)>2){
		 	   			$j=su(2,(count($err)-3));
		 				$jj=su(1,(count($grr)-1));
		 				$jjj=$j*$jj;
		 				$x['five']=$jjj;
		 				// echo '中了五等奖'.'('.$jjj.'次)';
		 				
		 	   		}

			 	}
			 			return $x;
	 		}

 		//4红1蓝
	 		if($rdan==4 && $bdan==1){
	 			if($first==5 && $last==2){
	 				$x['one']=1;
			 		// echo '中了一等奖';
			 		// echo '<br>';

			 		
		 			$j=su(1,(count($grr)-2));
		 			$x['two']=$j;
		 			// echo '中了二等奖'.'('.$j.'次)';
		 			// echo '<br>';
			 				 		
 				
 					$e=su(1,(count($err)-5));
 					$x['three']=$e;
 					// echo '中了三等奖'.'('.$e.'次)';	
 					// echo '<br>';

	 				if(count($err)>5){
	 					$f=su(1,(count($err)-5));
	 					$g=su(1,count($grr)-2);
	 					$ff=$f*$g;
	 					$x['four']=$ff;
	 					// echo '中了四等奖'.'('.$ff.'次)';
	 					// echo '<br>';
	 				}

	 					return $x;
			 	}elseif($first==5 && $last==1){
		 			if(count($grr)>2){
		 				$j=su(1,(count($grr)-1));
		 				$x['two']=$j;
		 				// echo '中了二等奖'.'('.$j.'次)';

		 				$e=su(1,(count($err)-5));
		 				$ee=su(1,(count($grr)-1));
		 				$eee=$e*$ee;
		 				$x['four']=$eee;
		 				// echo '中了四等奖'.'('.$eee.'次)';
		 				// echo '<br>';
		 			
		 			}
		 				return $x;

			 	}elseif($first==4 && $last==2){
		 			if(count($grr)>2){
		 				$j=su(1,(count($err)-4));
		 				$x['three']=$j;
	 					// echo '中了三等奖'.'('.$j.'次)'; 
	 					// echo '<br>';
	
	 					$f=su(1,(count($err)-4));
	 					$g=su(1,count($grr)-2);
	 					$ff=$f*$g;
	 					$x['four']=$ff;
	 					// echo '中了四等奖'.'('.$ff.'次)';
	 					// echo '<br>';
		 			}
				 		return $x;

				 	}elseif($first==4 && $last==1){
			 			if(count($grr)>2){
			 				$k=su(1,(count($err)-4));
			 				$kk=su(1,(count($grr)-1));
			 				$kkk=$k*$kk;
			 				$x['six']=$kkk;
			 				// echo '中了四等奖'.'('.$kkk.'次)';
			 				// echo '<br>'; 
			 				
			 			}
				 	}
				 			return $x;	
			 	}
			}

		}


 ?>