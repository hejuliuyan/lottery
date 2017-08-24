@extends('admin.public.base')

@section('style')
    <style>
        .per_list {
            border: 1px solid #93A1A1;
            width: 25%;
            margin-top: 15px;
            margin-bottom: 10px;
            padding: 2px 5px;
            border-radius: 3px;
        }

        .per_lists {
            border: 1px solid #93A1A1;
            width: 25%;
            /*margin-bottom: 15px;*/
            margin-top: 8px;
            padding: 2px 5px;
            border-radius: 3px;
            margin-left: 5%;
        }

        .list_cz {
            float: right;
        }

        .icon_cz {
            height: 20px;
            width: 20px;
        }

        .list_cz > a {
            margin: 2px 5px;
        }
    </style>
@stop
@section('title1')
    系统管理
@stop
@section('title2')
    权限列表
@stop
@section('content')

    <div class="result-wrap">

        <div class="result-title">
            <div class="result-list" style="text-align: left; float: left;">

            </div>
            <div class="result-list" style="text-align: right;">
                <!-- <input type="submit" name="submit" value="xinzeng"> -->
                <a href="/index.php/ad_per_add" id="add_user">
                    <button type="button"
                            class="btn btn-info">添加类别
                    </button>
                </a>
            </div>
        </div>
        <form name="myform" id="myform" method="post">

            <?php if(!empty($lists)): ?>
            <?php foreach($lists as $key => $value): ?>
            <div>
                <div class="per_list">{{ $value->display_name }}
                    <span class="list_cz">
                        <a class="mui-icon mui-icon-compose" id="updateOrd"
                           href="/index.php/ad_per_edit?id={{ $value->id }}"><img class="icon_cz"
                                                                                  src="/admin/images/save.png"/></a>
                        <a class="mui-icon mui-icon-closeempty" id="batchDel" data-id="{{ $value->id }}"
                           href="javascript:void(0)"><img class="icon_cz" src="/admin/images/del.png"/></a>
                        <a class="mui-icon mui-icon-closeempty"
                           href="/index.php/ad_per_add?id={{ $value->id }}"><img class="icon_cz"
                                                                                 src="/admin/images/add.png"/></a>
                    </span>
                </div>
                <?php if(!empty($value->lists)): ?>
                @foreach($value->lists as $k => $v)
                    <div class="per_lists">
                        {{$v->display_name}}
                        <span class="list_cz">
                                <a class="mui-icon mui-icon-compose" id="updateOrd"
                                   href="/index.php/ad_per_edit?id={{ $v->id }}"><img class="icon_cz"
                                                                                      src="/admin/images/save.png"/></a>
                                <a class="mui-icon mui-icon-closeempty" id="batchDel" data-id="{{ $v->id }}"
                                   href="javascript:void(0)"><img class="icon_cz" src="/admin/images/del.png"/></a>
                            </span>
                    </div>
                @endforeach
                <?php endif; ?>
            </div>
            {{--  <div class=""></div>--}}
            <?php endforeach; ?>
            <?php endif; ?>

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
            if ((confirm('此操作会一并删除角色关系，确定？')) == false) {
                return false;
            }
            ;
            var delid = $(this).attr('data-id');
            $.ajax({
                type: "GET",
                url: "/index.php/ad_per_del",
                data: {
                    id: delid,
                },
                datatype: "json",
                success: function (data) {
                    console.log(data);
                    if (typeof data == "string") {
                        var data = eval('(' + data + ')');
                    }
                    if (data == '1') {
                        window.location.href = "/index.php/ad_per";
                        //alert('删除成功');
                    } else if (data == '2') {
                        alert('请先删除目录下子权限');
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
