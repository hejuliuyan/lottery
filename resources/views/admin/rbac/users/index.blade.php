@extends('admin.public.base')
@section('title1')
    系统管理
@stop
@section('title2')
    用户列表
@stop
@section('content')

            <div class="result-wrap">

                <div class="result-title">
                    <div class="result-list" style="text-align: left; float: left;">
                    <!-- <select name="name" id="kj_select">
                        <option value="0">全部</option>
                        <option value="1">大乐透</option>
                        <option value="2">七星彩</option>
                        <option value="3">排三</option>
                    </select> -->
                    {{--<form action="/index.php/ad_shop_search" method="post">
                    <input type="text" name="where" id="where" placeholder="店铺编号"
                    value=""> <input type="text" name="phone" id="phone"
                    placeholder="店主手机号" value=""> <input type="submit" name="检索"
                    id="search">
                </form>--}}
            </div>
            <div class="result-list" style="text-align: right;">
                <!-- <input type="submit" name="submit" value="xinzeng"> -->
                <a href="/index.php/ad_user_add" id="add_user">
                    <button type="button"
                    class="btn btn-info">新增
                </button>
            </a>
        </div>
    </div>
    <form name="myform" id="myform" method="post">
        <div class="result-content">
            <table class="result-tab tablesorter" id="myTable" width="100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>用户名</th>
                        <th>邮箱</th>
                        <th>创建时间</th>
                        <th>修改时间</th>
                        <th>状态</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($lists)): ?>
                        <?php foreach($lists as $key => $value): ?>
                            <tr>
                                <!-- <input name="id" value="" type="hidden"> -->
                                <td>{{ $value->id }}</td>
                                <td>{{ $value->name }}</td>
                                <td>{{ $value->email }}</td>
                                <td>{{ $value->created_at }}</td>
                                <td>{{ $value->updated_at }}</td>
                                <td>
                                    <?php if($value->state == '1'):?>
                                        启用
                                    <?php else: ?>
                                        禁用
                                    <?php endif; ?>
                                </td>
                                <td><a id="updateOrd"
                                   href="/index.php/ad_user_up?id={{ $value->id }}"><button type="button" class="btn btn-info">修改</button></a> <a
                                   id="batchDel" data-id="{{ $value->id }}"
                                   href="javascript:void(0)"><button type="button" class="btn btn-info">删除</button></a> <a
                                   href="/index.php/ad_user_role?id={{ $value->id }}"><button type="button" class="btn btn-info">角色</button></a></td>
                               </tr>
                           <?php endforeach; ?>
                       <?php endif; ?>
                   </tbody>
               </table>
               <!--<div class="list-page"> 2 条 1/1 页</div>-->
           </div>
       </form>
   </div>
@stop
@section('js')
<script>
    $(document).on('click', '#search', function () {
        if ($("#where").val() == '') {
            if ($("#phone").val() == '') {
                alert("请填写数据再提交");
                return false;
            }
        }
    })
    $(document).ready(function () {
        //第一列不进行排序(索引从0开始) 
        //$("#myTable").tablesorter( {sortList: [[0,0], [1,0]]} );
        $("#myTable").tablesorter();
    });

    $("#kj_select").change(function () {
        var types = $("#kj_select ").val();
        if (types == '0') {
            window.location.href = "/index.php/ad_kjlist";
        } else {
            window.location.href = "/index.php/ad_kjsearch?types=" + types + "";
        }


    });


    $(document).on('click', '#batchDel', function () {
        if ((confirm('确定要删除吗')) == false) {
            return false;
        }
        ;
        var delid = $(this).attr('data-id');
        $.ajax({
            type: "GET",
            url: "/index.php/ad_user_del",
            data: {
                id: delid,
            },
            datatype: "json",
            success: function (data) {
                if (typeof data == "string") {
                    var data = eval('(' + data + ')');
                }
                if (data) {
                    window.location.href = "/index.php/ad_user";
                    //alert('删除成功');

                }
            },
            error: function () {
                //请求出错处理
            }
        });
    })
    function GetRequest() {
        var url = location.search; //获取url中"?"符后的字串
        var theRequest = new Object();
        if (url.indexOf("?") != -1) {
            var str = url.substr(1);
            strs = str.split("&");
            for (var i = 0; i < strs.length; i++) {
                theRequest[strs[i].split("=")[0]] = unescape(strs[i].split("=")[1]);
            }
        }
        return theRequest;
    }
    var Request = new Object();
    Request = GetRequest();
    types = Request['types'];
    $("#kj_select option[value=" + types + "]").attr('selected', 'selected');
</script>
@stop