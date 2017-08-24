<!DOCTYPE html>
<html>
<head lang="cn">
    <meta charset="UTF-8">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'/>
    <title>后台管理系统</title>
    <link href="/admin/css/a.css" rel="stylesheet"/>
    <link href="/admin/images/login/abc.ico" rel="shotcut icon"/>
    <script type="text/javascript" src="/admin/js/jquery-latest.js"></script>
</head>
<body>
<header>
    <div class="text">
        {{--<a><em>加入收藏</em>|<span>联系我们</span></a>--}}
    </div>
</header>
<div id="content">
    {{--<img src="/admin/images/login/jian.png" />--}}
    <h1>{{ trans('login.title') }}</h1>
    <form method="post">
        <input id="usename" name="username" type="text" value="" placeholder="{{--用户名--}}{{trans('login.username')}}"/><br/>
        <input id="password" name="password" type="password" value=""  placeholder="{{--密码--}}{{trans('login.password')}}"/>
        <div class="bt clear">
            {{--<input class="check fl" type="checkbox" value=""/>
            <span class="fl">记住密码</span>
            <em class="fl">忘记密码？</em>--}}
            <input id="submit" type="submit" value="{{trans('login.log_in')}}"/>
        </div>
    </form>
</div>
<div id="footer">
    <p><span>{{trans('login.foot')}}</span></p>
</div>
</body>
<script>
    $("#submit").click(function () {
        var username = $("#usename").val();
        var password = $("#password").val();
        $.post("/index.php/do_login", {username: username, password: password},
                function (data) {
                    if (typeof data == "string") {
                        var data = eval('(' + data + ')');
                    }
                   // console.log(data);
                    if (data == '1') {
                        window.location.href="/index.php/ad_index";
                    } else if (data == '0') {
                        alert("{{trans('login.isname_pwd')}}");
                    } else {
                        alert("{{trans('login.is_gs')}}");
                        /*for (var i in data) {
                             $("input[name='num']").val(data[i][0]);
                            $("input[name="+i+"]").parent("td").append('<span style="color:red">'+data[i][0]+'</span>');
                             alert(i);
                        }*/
                    }
                });
        return false;

    });
</script>
</html>