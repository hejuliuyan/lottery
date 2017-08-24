
/*userid:用户tokenid，html:检查完需要跳转的页面*/
function token_check(userid,html){
	mui.ajax('http://test.foodietech.cn/index.php/token_check', {
		data : {
			token : userid,
		},
		dataType : 'json',//服务器返回json格式数据
		type : 'post',//HTTP请求类型
		timeout : 10000,//超时时间设置为10秒；
		success : function(data) {
			if (typeof data == "string") {
				var data = eval('(' + data + ')');
			}
			
			if(isWeiXin()){
				if(data==1){
				mui.alert('用户未注册',function(){
					mui.openWindow({
						url : 'login.html',
						id : 'login',
						createNew:true
					});
				})
				}else if(data==2){
					mui.alert('资料未完善',function(){
						mui.openWindow({
							url : 'personal.html',
							id : 'personal',
							createNew:true
						});
					})
				}else if(data==3){
					mui.alert('该用户已被禁用',function(){
						mui.openWindow({
							url : 'login.html',
							id : 'login',
							createNew:true
						});
					})
				}else if(data==false){
					mui.alert('未授权',function(){
						mui.openWindow({
							url: 'http://test.foodietech.cn/index.php/wx?tz=1', 
							
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
				if(data==1){
				mui.alert('用户未注册或未登录',function(){
					mui.openWindow({
						url : 'login.html',
						id : 'login',
						createNew:true
					});
				})
				}else if(data==2){
					mui.alert('资料未完善',function(){
						mui.openWindow({
							url : 'personal.html',
							id : 'personal',
							createNew:true
						});
					})
				}else if(data==3){
					mui.alert('该用户已被禁用',function(){
						mui.openWindow({
							url : 'login.html',
							id : 'login',
							createNew:true
						});
					})
				}else if(data==false){
					mui.alert('用户未登录',function(){
						mui.openWindow({
							url: 'login.html',
							createNew:true
							
						});
					})
					
				}else{
					if(html){
						//window.localStorage.setItem('reset','');
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