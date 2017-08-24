@extends('admin.public.base')
@style
<style>
a{border: none;}
</style>
@stop
@section('title1')
    {{trans('lottery.index.title1')}}
@stop
@section('title2')
    {{trans('lottery.index.title2')}}
@stop
@section('content')
    <div class="search-wrap">
        <div class="search-content" style='margin-left: 2%;'>
            <p>{{trans('lottery.index.p1')}}</p>
            <p>{{trans('lottery.index.p2')}}</p>
            <p>{{trans('lottery.index.p3')}}</p>
            <p>{{trans('lottery.index.p4')}}</p>
        </div>
    </div>
    <div class="result-wrap">
        <form name="myform" id="myform" method="post">
            <div class="result-title">
                <div class="result-list" style="text-align: left; float: left;">
                    <select name="name" id="kj_select">
                        <option value="0">{{trans('lottery.index.option.0')}}</option>
                        <option value="1">{{trans('lottery.index.option.1')}}</option>
                        <option value="2">{{trans('lottery.index.option.2')}}</option>
                        <option value="3">{{trans('lottery.index.option.3')}}</option>
                        <option value="4">{{trans('lottery.index.option.4')}}</option>
                    </select>
                </div>
                <div class="result-list" style="text-align: right;">
                    <a href="/index.php/ad_kjadd">
                        <button type="button"
                                class="btn btn-info">{{trans('public.but.add')}}
                        </button>
                    </a>
                </div>
            </div>
            <div class="result-content">
                <table class="result-tab tablesorter" id="myTable" width="100%">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>{{trans('lottery.index.list_title.cz')}}</th>
                        <th>{{trans('lottery.index.list_title.qishu')}}</th>
                        <th>{{trans('lottery.index.list_title.zjhm')}}</th>
                        <th>{{trans('lottery.index.list_title.kj_date')}}</th>
                        <th>{{trans('lottery.index.list_title.djj_date')}}</th>
                        <th>{{trans('lottery.index.list_title.caozuo')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(!empty($lists)): ?>
                    <?php foreach($lists as $key => $value): ?>
                    <tr>
                        <input name="id[]" value="" type="hidden">
                        <td>{{ $value->id }}</td>
                        <td>{{ $value->name }}</td>
                        <td>{{ $value->num }}</td>
                        <td>{{ $value->numbers }}</td>
                        <td>{{ $value->notice_date }}</td>
                        <td>{{ $value->deadline }}</td>
                        <td><a id="updateOrd"
                               href="/index.php/ad_kjedit?id={{ $value->id }}" ><button type="button" class="btn btn-info">{{trans('public.but.saves')}}</button></a> <a
                                    id="batchDel" data-id="{{ $value->id }}"
                                    href="javascript:void(0)"><button type="button" class="btn btn-info">{{trans('public.but.del')}}</button></a></td>
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
        var delid = $(this).attr('data-id');
        $.ajax({
            type: "GET",
            url: "/index.php/ad_kjdel",
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
                    window.location.href = "/index.php/ad_kjlist";
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
