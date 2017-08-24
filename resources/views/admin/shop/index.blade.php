@extends('admin.public.base')
@section('title1')
    {{trans('shop.title1')}}
@stop
@section('title2')
    {{trans('shop.title2')}}
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
                <form action="/index.php/ad_shop_search" method="post">
                    <input type="text" name="where" id="where" placeholder="{{trans('shop.search.num')}}" value="">
                    <input type="text" name="phone" id="phone" placeholder="{{trans('shop.search.phone')}}" value="">
                    <input type="submit" class="btn btn-info " value="{{trans('public.but.search')}}" id="search"/>
                </form>
            </div>
            <div class="result-list" style="text-align: right;">
                <input type="text" name="num" id="add_num"/>
                <!-- <input type="submit" name="submit" value="xinzeng"> -->
                <a href="#" id="add_shop">
                    <button type="button" class="btn btn-info">{{trans('public.but.add')}}</button>
                </a>
            </div>
        </div>
        <form name="myform" id="myform" method="post">
            <div class="result-content">
                <table class="result-tab tablesorter" id="myTable" width="100%">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>{{trans('shop.shop_name')}}</th>
                        {{--<th>身份证号</th>--}}
                        {{--<th>真实姓名</th>--}}
                        <th>{{trans('shop.mobile')}}</th>
                        <th>{{trans('shop.log_name')}}</th>
                        <th>{{trans('shop.c_time')}}</th>
                        <th>{{trans('shop.cp_num')}}</th>
                        <th>{{trans('shop.address')}}</th>

                        {{--<th>状态</th>--}}
                        <th>{{trans('public.operation')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(!empty($lists)): ?>
                    <?php foreach($lists as $key => $value): ?>
                    <tr>
                        <!-- <input name="id" value="" type="hidden"> -->
                        <td>{{ $value->id }}</td>
                        <td>{{ $value->shop_name }}</td>
                        {{--<td>{{ $value->idcard_num }}</td> --}}
                        {{--<td>{{ $value->keeper_name }}</td>--}}
                        <td>{{ $value->keeper_mobile }}</td>
                        <td>
                            <?php if(isset($value->shop_account)):?>
                            {{ $value->shop_account }}
                            <?php endif; ?>
                        </td>
                        <td>{{ date('Y-m-d H:i:s',$value->created_at) }}</td>
                        <td><?php if(isset($value->shop_cpnum)): ?>
                            {{ $value->shop_cpnum }}
                            <?php endif; ?>
                        </td>
                        <td>{{ $value->address }}</td>


                        <td>
                            <a id="updateOrd" href="/index.php/ad_spedit?id={{ $value->id }}">
                                <button type="button" class="btn btn-info">{{--修改--}}{{trans('public.but.saves')}}</button>
                            </a>
                            {{--<a id="batchDel" data-id="{{ $value->id }}" href="javascript:void(0)">
                                <button type="button" class="btn btn-info">--}}{{--删除--}}{{--{{trans('public.but.del')}}</button>
                            </a>--}}
                            <a href="/index.php/ad_shop_show?id={{ $value->id }}">
                                <button type="button" class="btn btn-info">{{--账务--}}{{trans('public.but.money')}}</button>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
                <!--<div class="list-page"> 2 条 1/1 页</div>-->
            </div>
        </form>
    </div>

    <!--/main-->
@stop
@section('js')
    <script>
        $(document).on('click', '#search', function () {
            if ($("#where").val() == '') {
                if ($("#phone").val() == '') {
                    alert("{{trans('shop.js.null')}}");
                    return false;
                }
            }
        })
        /* $("#search").click(function () {debugger;
         if($("#where").val()==''){
         alert("请填写数据再提交");
         }
         } */
        $(document).on('click', '#add_shop', function () {
            var num = $("#add_num").val();
            $.ajax({
                type: "GET",
                url: "/index.php/ad_shop_add",
                data: {
                    num: num,
                },
                datatype: "json",
                success: function (data) {
                    /* if(typeof data == "string") {var data = eval('('+data+')');}
                     if(data.status==1){
                     window.location.href="/index.php/ad_kjlist";
                     } */
                    if (data == '1') {
                        //alert('添加成功');
                        window.location.href = "/index.php/ad_shop";
                    } else if (data == '2') {
                        alert("{{trans('shop.js.num')}}");
                    } else {
                        alert("{{trans('shop.js.max_num')}}");
                    }

                },
                error: function () {
                    //请求出错处理
                }
            });
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
            if ((confirm("{{trans('shop.js.is_del')}}")) == false) {
                return false;
            }
            ;
            var delid = $(this).attr('data-id');
            $.ajax({
                type: "GET",
                url: "/index.php/ad_shop_del",
                data: {
                    id: delid,
                },
                datatype: "json",//"xml", "html", "script", "json", "jsonp", "text".
                /* beforeSend:function(){
                 $('.w_adshow').show();
                 },*/
                success: function (data) {
                    if (typeof data == "string") {
                        var data = eval('(' + data + ')');
                    }
                    if (data.status == 1) {
                        window.location.href = "/index.php/ad_shop";
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