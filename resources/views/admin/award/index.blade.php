@extends('admin.public.base')
@section('title1')
    {{trans('award.title1')}}
@stop
@section('title2')
    {{trans('award.title2')}}
@stop
@section('content')
    <div class="search-wrap">
        <div class="search-content">
            <form action="#" method="post">
                <table class="search-tab">
                    <!--<tr>

                    <th width="70">期数:</th>
                    <td><input class="common-text" placeholder="期数" name="keywords" value="" id="" type="text"></td>
                    <th width="70">开奖日期:</th>
                    <td>
                        <select name="kj_data" id="kj_data">
                            <option value="0">全部</option>
                            <option value="1">近一周</option>
                             <option value="2">近一个月</option>
                        </select>
                    </td>
                    <td><input class="btn btn-primary btn2" name="sub" value="查询" type="submit"></td>
                </tr>-->
                </table>
            </form>
        </div>
    </div>
    <div class="result-wrap">
        <form name="myform" id="myform" method="post">
            <div class="result-title">
                <div class="result-list" style="text-align: left; float: left;">
                    <select name="type" id="types">
                        {{--<option value=''>请选择彩种</option>
                        <option value="01">大乐透</option>
                        <option value="03">排列三</option>
                        <option value="04">排列五</option>
                        <option value="02">七星彩</option>--}}
                        <option value="0">{{trans('award.select')}}</option>
                        <option value="1">{{trans('lottery.index.option.1')}}</option>
                        <option value="2">{{trans('lottery.index.option.2')}}</option>
                        <option value="3">{{trans('lottery.index.option.3')}}</option>
                        <option value="4">{{trans('lottery.index.option.4')}}</option>
                    </select> <input type="text" placeholder='{{trans('award.qishu')}}' id='zj_qi'>
                    <button id='sub' type="button" class="btn btn-info">{{trans('award.title2')}}</button>
                    <button id='tx' type="button" class="btn btn-info">{{trans('award.tx')}}</button>
                </div>

            </div>
        </form>
    </div>
@stop

@section('js')
    <script>
        $("#sub").click(function () {
            var types = $("#types ").val();
            var zj_qi = $("#zj_qi ").val();
            if (qi(zj_qi)) {
                $.ajax({
                    type: "post",
                    url: "/index.php/do_zj",
                    data: {
                        zj_qi: zj_qi, types: types,
                    },
                    datatype: "json",//"xml", "html", "script", "json", "jsonp", "text".
                    success: function (data) {
                        if (typeof data == "string") {
                            var data = eval('(' + data + ')');
                        }
                        console.log(data);
                        if (data == true) {
                            alert("{{trans('award.js.ok')}}");
                        } else if (data == 'solved') {
                            alert("{{trans('award.js.repeat')}}");
                        } else if (data == 'miss') {
                            alert("{{trans('award.js.incomplete')}}");
                        } else if (data == false) {
                            alert("{{trans('award.js.abnormal')}}");
                        }
                    },
                    error: function () {
                        //请求出错处理
                    }
                });

            } else {
                alert("{{trans('award.js.input_qs')}}");
            }


        });

        $("#tx").click(function () {
            var types = $("#types ").val();
            var zj_qi = $("#zj_qi ").val();
            if (qi(zj_qi)) {
                $.ajax({
                    type: "post",
                    url: "/index.php/zj_send",
                    data: {
                        zj_qi: zj_qi, types: types,
                    },
                    datatype: "json",//"xml", "html", "script", "json", "jsonp", "text".
                    success: function (data) {
                        if (typeof data == "string") {
                            var data = eval('(' + data + ')');
                        }
                        console.log(data);
                        if (data == true) {
                            alert("{{trans('award.js.success')}}");
                        } else if (data == 'solved') {
                            alert("{{trans('award.js.repeat')}}");
                        } else if (data == false) {
                            alert("{{trans('award.js.abnormal')}}");
                        }

                    },
                    error: function () {
                        //请求出错处理
                    }
                });
            } else {
                alert("{{trans('award.js.input_qs')}}");
            }


        });

        //期数匹配
        function qi(obj) {
            reg = /^\d{5,}$/;
            if (!reg.test(obj)) {
                return false;
            } else {
                return true;
            }
        }

    </script>
@stop