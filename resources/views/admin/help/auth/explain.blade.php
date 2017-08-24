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
        <h1>1、权限操作</h1><br>
        <p style="text-indent:2em;">权限有权限类别和权限部分，管理员可以先创建一个类别，然后在类别下面创建权限。这样方便管理。</p>
        {{-- <p>权限模块主要分为三个部分：用户管理、角色管理、权限管理。多个权限可对应多个角色，多个角色也可对应多个用户。管理员可创建多个角色，每个角色分配不同权限，然后对用户分配角色。</p> --}}
        <div><img src="/admin/images/per.png" /></div><br>
        <div><img src="/admin/images/per_edit.png" /></div>
        </br><br>
        <h1>2、角色权限分配</h1>
        <p style="text-indent:2em;">如需选择某权限类别下所有权限，选中权限类别，即可选中类别下所有权限。</p>
        <div><img src="/admin/images/role.png" /></div>
    </div>

@stop
@section('js')
    <script>
        /*var url = window.location.search;
         var order_id = url.substring(url.lastIndexOf('=') + 1, url.length);*/
    </script>
    <script src="/admin/js/adddate.js"></script>
@stop