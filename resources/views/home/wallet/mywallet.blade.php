<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>我的钱包</title>
<meta name="viewport"
	content="width=device-width, 		initial-scale=1,maximum-scale=1,user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<!--标准mui.css-->
<link rel="stylesheet" href="/mui/css/mui.min.css">
<link rel="stylesheet" href="/mui/css/css.css">
<script src="/mui/js/jquery-1.7.2.min.js"></script>
<script src="/mui/js/mui.min.js"></script>
<script src="/mui/js/jquery-latest.js"></script>
<style>
.header_d>.mui-btn {
	border-color: #FFFFFF;
	margin: 15px 15px 0 0;
}

.mui-bar {
	background-color: #EEEEEE;
}
</style>
</head>

<body>
	<!--<header class="mui-bar mui-bar-nav"><h1 class="mui-title">我的钱包</h1></header>-->
	<header class="mui-bar mui-bar-nav">
		<a href="dlt.html?display=show"
			class=" mui-icon mui-icon-left-nav mui-pull-left bck"></a>
		<h1 class="mui-title">我的钱包</h1>
	</header>
	<section class="ord1_top">
		<div class="head_div head_col">
			<div class="header_d">
				<p class="head_col">账户余额（元）</p>
				<p class="head_col head_money">
					{{$arr->trans_balance}}
					<!-- 1400 -->
				</p>
			</div>
			<div class="header_d head_col">
				<button type="button" class="mui-btn mui-btn-outlined head_col">提现</button>
				<button type="button" class="mui-btn mui-btn-outlined head_col">充值</button>
				<!--<a href="#" class="mui-btn mui-btn-outlined head_col"
				style="font-size: initial;">提现</a> <a href="#"
				class="mui-btn mui-btn-outlined head_col"
				style="font-size: initial;">充值</a>-->
			</div>
		</div>
	</section>
	<section>
		<p class="p_color">额度限制</p>
		<div class="balance_div div_color">
			当前累积账户余额提现额度<span>{{$arr->trans_balance}}元</span>
		</div>
		<p class="p_color">最近交易记录</p>
		<div class="div_color">
			<a href="/index.php/mywallet?date=1"
				class="<?php if ($date=='1'):?>a_action<?php endif; ?> mui-btn  mui-btn-outlined search_b a_but">最近一周</a> <a
				href="/index.php/mywallet?date=2"
				class="<?php if ($date=='2' or $date==null):?>a_action<?php endif; ?> mui-btn  mui-btn-outlined search_b a_but">最近一月</a> <a
				href="/index.php/mywallet?date=3"
				class="<?php if ($date=='3'):?>a_action<?php endif; ?> mui-btn  mui-btn-outlined search_b a_but">最近三月</a>
			<!-- <button type="button" class="mui-btn  mui-btn-outlined search_b">最近一周</button>
			<button type="button" class="mui-btn  mui-btn-outlined search_b">最近一月</button>
			<button type="button" class="mui-btn  mui-btn-outlined search_b">最近三月</button> -->
		</div>
	</section>
	<?php if(!empty($data)): ?>
     <?php foreach($data as $key => $value): ?>
	<section class="money_list">
		<div class="lists">
			<div class="list_left">
				<dt class="list_left_font">
				 <?php if($value->trans_title==1): ?>充值
				<?php elseif($value->trans_title==2):?>支付
				<?php elseif($value->trans_title==3):?>兑奖
				<?php elseif($value->trans_title==3):?>提现
				<?php endif; ?>
				</dt>
				<dt class="list_left_time" style="font-size: small; color: #909090;">{{
					$value->trans_date }}</dt>
			</div>
			<div class="list_img">
			<?php if($value->trans_title==1): ?><img
					src="/mui/wimages/lower_money.png" />
				<?php elseif($value->trans_title==2):?><img
					src="/mui/wimages/lower_money.png" />			
				<?php elseif($value->trans_title==3):?><img
					src="/mui/wimages/upper_money.png" />
				<?php elseif($value->trans_title==3):?><img
					src="/mui/wimages/upper_money.png" />
				<?php endif; ?>				
			</div>
			<div class="list_right">
				<div class="div_left">					
				<?php if($value->trans_title==1): ?><dt style="color: red;">+{{
						$value->trans_price }}</dt>
				<?php elseif($value->trans_title==2):?><dt style="color: #30D65A;">-{{
						$value->trans_price }}</dt>
				<?php elseif($value->trans_title==3):?><dt style="color: red;">+{{
						$value->trans_price }}</dt>
				<?php elseif($value->trans_title==3):?><dt style="color: #30D65A;">-{{
						$value->trans_price }}
				<?php endif; ?>
				<!-- <dt>+1000</dt> -->
					
					
					<dt style="font-size: smaller; color: #909090;">余额{{
						$value->trans_balance }}元</dt>
				</div>
				<div class="a_img">
					<!-- <button type="button">
						<img src="/mui/wimages/aaa_ok.png" />
					</button> -->
					<a href="/index.php/mywallet_info?id={{
						$value->id }}"><img src="/mui/wimages/aaa_ok.png" /></a>
				</div>
			</div>
		</div>

	</section>
	<?php endforeach; ?>
   <?php endif; ?>
</body>
<script>
	/* $(".a_but").click( function () {debugger;
		$(this).addClass("a_action");
	}); */
</script>
</html>