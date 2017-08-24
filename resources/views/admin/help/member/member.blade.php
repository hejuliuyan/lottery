@extends('admin.public.help_left')
@section('style')
    <style>
        .content {
            /*margin-left: 10%;*/
            margin: 3% 0 0 18%;
            width: 70%;
        }
    </style>
@stop
@section('title1')

@stop
@section('title2')

@stop
@section('content')
    <div class="content">
        <h1>个人用户</h1><br>
        <p style="text-indent:2em;">会员列表有对应每个会员的帐务信息</p><br>
        <div><img src="/admin/images/m_mon.png" /></div><br>
        <div><img src="/admin/images/zhangwu.png" /></div><br>
        <p style="text-indent:2em;">会员编辑可对会员进行禁用，用户登录时首先检查状态，如果被禁用，就返回首页。</p><br>
         <div><img src="/admin/images/member_jy.png" /></div>
        </br><br>

    </div>

@stop
@section('js')
    <script>
        /*var url = window.location.search;
         var order_id = url.substring(url.lastIndexOf('=') + 1, url.length);*/
    </script>
    <script src="/admin/js/adddate.js"></script>
@stop