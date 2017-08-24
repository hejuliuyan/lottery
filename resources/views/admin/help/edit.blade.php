@extends('admin.public.base')
@section('style')
    <style>
        .content {
            /*margin-left: 10%;*/
            /*margin: 3% 0 0 18%;*/
            margin: 20px auto;
            width: 80%;
        }
        #edui1{
            margin: 30px 0;
            /*height: 500px;*/
        }

        /*.input > p {
            margin-top: 20px;
        }

        .input {
            border: 1px solid;
        }*/
    </style>
@stop
@section('title1')

@stop
@section('title2')

@stop
@section('content')
    <div class="content">
        <div class="sel" style="margin-top: 20px;">
            <span>请选择要操作模板：</span>
            <select name="name" id="sel">
                <option value="index">首页</option>
                <option value="kj_list">开奖列表</option>
                <option value="zj_handle">中奖结果处理</option>
                <option value="banner">广告</option>
                <option value="member_list">会员列表</option>
                <option value="shop_list">店铺列表</option>
                <option value="personal_m">个人帐务</option>
                <option value="shop_m">店铺帐务</option>
                <option value="order_list">订单列表</option>
                <option value="user">用户</option>
                <option value="role">角色</option>
                <option value="per">权限</option>
            </select>
        </div>
        <script id="container" name="content" type="text/plain">
           {{--  <p style="font-size:70px;"> asd</p> --}}
        </script>
        <!-- 配置文件 -->
        <script type="text/javascript" src="/admin/ueditor/ueditor.config.js"></script>
        <!-- 编辑器源码文件 -->
        <script type="text/javascript" src="/admin/ueditor/ueditor.all.js"></script>
        <!-- 实例化编辑器 -->
        <input type="button" class="btn btn-block" id="inp" value="提交"/>
        <script type="text/javascript">
            var ue = UE.getEditor('container');
            $("#inp").on("click", function () {
                var content = ue.getContent();
                var type = $("#sel").val();
                $.post("/explain_edit", {content: content, type: type},
                        function (data) {
                            alert("操作成功！");
                            window.location.reload();//刷新当前页面.
                        });
            });
            ue.ready(function() {
                var types = $("#sel ").val();
                sel(types);
            });
            $("#sel").change(function () {
                var types = $("#sel ").val();
                sel(types);                
            });
            function sel(type){
                $.get("/explain", { type: type},
                    function(data){
                        ue.setContent(data);                        
                    } 
                 );
            }
        </script>
    </div>

@stop
@section('js')
    <script>
        /*var url = window.location.search;
         var order_id = url.substring(url.lastIndexOf('=') + 1, url.length);*/
    </script>
    <script src="/admin/js/adddate.js"></script>
@stop