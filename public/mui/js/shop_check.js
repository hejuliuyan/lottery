
/*userid:用户tokenid，html:检查完需要跳转的页面*/
function shop_check(shopid,html){
	mui.ajax('http://test.foodietech.cn/index.php/shopid_check', {
		data : {
			shopid : shopid,
		},
		dataType : 'json',//服务器返回json格式数据
		type : 'post',//HTTP请求类型
		timeout : 10000,//超时时间设置为10秒；
		success : function(data) {
			if (typeof data == "string") {
				var data = eval('(' + data + ')');
			}
			//alert(333)
			if(isWeiXin()){
				//mui.alert(1456);
				if(data==1){
				mui.alert('该店铺已被禁用',function(){
					mui.openWindow({
						url : 'shop_login.html',
						id : 'shop_login',
						createNew:true
					});
				})
				}else if(data==false){
					mui.alert('未授权',function(){
						mui.openWindow({
							url: 'http://test.foodietech.cn/index.php/wx?tz=2', 
							
						});
					})
					
				}else{
					if(html){
						mui.openWindow({
							url : html,
							createNew:true
							
						});
					}
					
				}
			}else{
				//alert(2121)
				if(data==1){
					//mui.alert(1)
				mui.alert('该店铺已被禁用',function(){
					mui.openWindow({
						url : 'shop_login.html',
						id : 'shop_login',
						createNew:true
					});
				})
				}else if(data==false){
					//mui.alert(2)
					mui.alert('店铺未登录',function(){
						mui.openWindow({
							url: 'shop_login.html',
							createNew:true
							
						});
					})
					
				}else{
					//mui.alert(3)
					if(html){
						mui.openWindow({
							url : html,
							createNew:true
							
						});
					}
					
				}
			}
			
			function isWeiXin(){
			    var ua = window.navigator.userAgent.toLowerCase();
			    if(ua.match(/MicroMessenger/i) == 'micromessenger'){
			        return true;
			    }else{
			        return false;
			    }
			}
			
			
		},
		error : function(xhr, type, errorThrown) {
			//异常处理；
			console.log(type);
		}
	});
	
	
	
	
}