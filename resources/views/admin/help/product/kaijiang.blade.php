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
        <h1>开奖列表</h1><br>
        <p style="text-indent:2em;">列表显示筛选</p><br>
        {{-- <p>权限模块主要分为三个部分：用户管理、角色管理、权限管理。多个权限可对应多个角色，多个角色也可对应多个用户。管理员可创建多个角色，每个角色分配不同权限，然后对用户分配角色。</p> --}}
        <div><img src="/admin/images/kj_select.png" /></div><br>
        <p style="text-indent:2em;">编辑操作</p><br>
         <div><img src="/admin/images/kj_edit.png" /></div>
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