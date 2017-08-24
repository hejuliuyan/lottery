@extends('admin.public.base')
@section('title1')
    权限管理
@stop
@section('title2')
    角色列表
@stop
@section('content')
    <div class="result-wrap">

        <div class="result-title">
            <div class="result-list" style="text-align: left; float: left;"></div>
            <div class="result-list" style="text-align: right;">
                <!-- <input type="submit" name="submit" value="xinzeng"> -->
                <a href="/index.php/ad_role_add" id="add_role">
                    <button type="button" class="btn btn-info">新增</button>
                </a>
            </div>
        </div>
        <form name="myform" id="myform" method="post">
            <div class="result-content">
                <table class="result-tab tablesorter" id="myTable" width="100%">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>角色名</th>
                        <th>说明</th>
                        <th>创建时间</th>
                        <th>修改时间</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(!empty($lists)): ?>
                    <?php foreach($lists as $key => $value): ?>
                    <tr>
                        <!-- <input name="id" value="" type="hidden"> -->
                        <td>{{ $value->id }}</td>
                        <td>{{ $value->display_name }}</td>
                        <td>{{ $value->description }}</td>
                        <td>{{ $value->created_at }}</td>
                        <td>{{ $value->updated_at }}</td>
                        <td><a id="updateOrd"
                               href="/index.php/ad_role_edit?id={{ $value->id }}"><button type="button" class="btn btn-info">修改</button></a> <a
                                    id="batchDel" data-id="{{ $value->id }}"
                                    href="javascript:void(0)"><button type="button" class="btn btn-info">删除</button></a> <a
                                    href="/index.php/ad_role_per?id={{ $value->id }}"><button type="button" class="btn btn-info">权限</button></a></td>
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
            if ((confirm('此操作会一并删除用户、权限关联关系，确定？')) == false) {
                return false;
            }
            var delid = $(this).attr('data-id');
            $.ajax({
                type: "GET",
                url: "/index.php/ad_role_del",
                data: {
                    id: delid,
                },
                datatype: "json",
                success: function (data) {
                    //console.log(data);
                    if (typeof data == "string") {
                        var data = eval('(' + data + ')');
                    }
                    if (data == '1') {
                        window.location.href = "/index.php/ad_role";
                        //alert('删除成功');
                    } else {
                        alert('删除失败');
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