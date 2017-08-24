@extends('admin.public.base')

@section('style')
    <style>
        .pagination {
            margin: 30px auto;
            height: 10px;
        }

        .pagination > li {
            float: left;
            font-size: 16px;
            height: 25px;
            width: 35px;
            border: 1px solid #D1D1D1;
            text-align: center;
        }

        .search {
            margin-top: 20px;
            margin-left: 30px;
        }

        .search_p {
            margin-top: 10px;
        }

        .search_p label {
            width: 120px;
            font-size: 14px;
            line-height: 30px;
            display: inline-block;
            text-align: right;
            font-size: 14px;
            line-height: 30px;
            display: inline-block;
        }
    </style>
@stop
@section('title1')
    {{--订单管理--}}{{trans('order.title')}}
@stop
@section('title2')
    {{--列表--}}{{trans('order.title_list')}}
@stop
@section('content')

    <div class="search">
        <form action="/index.php/ad_order_list" method="get">
            <p class="search_p">
                <label for=''>{{--彩种--}}{{trans('order.list_search.cz')}}：</label> <select name="type" id="types">
                    <option value="">{{--请选择彩种--}}{{trans('order.list_search.sel_cz')}}</option>
                    <option value="01" @if($where['type']=='01')selected
                            @endif>{{--大乐透--}}{{trans('order.list_search.cz_1')}}
                    </option>
                    <option value="02" @if($where['type']=='02')selected
                            @endif>{{trans('order.list_search.cz_2')}}
                    </option>
                    <option value="03" @if($where['type']=='03')selected
                            @endif>{{trans('order.list_search.cz_3')}}
                    </option>
                    <option value="04" @if($where['type']=='04')selected
                            @endif>{{trans('order.list_search.cz_4')}}
                    </option>
                </select>
            </p>
            <p class="search_p">
                <label for="order_qi">{{--期数--}}{{trans('order.qishu')}}：</label><input type="text"
                                                        name="order_qi" id="order_qi" placeholder="{{trans('order.qs_pla')}}"
                                                        value="{{ $where['order_qi'] }}">
            </p>
            <p class="search_p">
                <label for="mobile">{{trans('order.mobile')}}：</label><input type="text" name="mobile"
                                                         id="mobile" placeholder="{{trans('order.mobile_pla')}}"
                                                         value="{{$where['mobile']}}">
            </p>
            <p class="search_p">
                <label for="keeper_mobile">{{trans('order.keeper_mobile')}}：</label><input type="text"
                                                                name="keeper_mobile" id="keeper_mobile"
                                                                placeholder="{{--请输入店铺手机号--}}{{trans('order.keeper_mobile_pla')}}"
                                                                value="{{$where['keeper_mobile']}}">
            </p>
            <p class="search_p">
                <label for="order_num">{{--订单号--}}{{trans('order.order_num')}}：</label><input type="text"
                                                          name="order_num" id="order_num" placeholder="{{trans('order.order_num_pl')}}"
                                                          value="{{$where['order_num']}}">
            </p>
            <p class="search_p">
                <label for="">{{trans('order.date')}}：</label> <input
                        style="width: 170px; border: 1px solid #ccc;"
                        notice_date"
                onclick="SelectDate(this,'yyyy-MM-dd hh:mm:ss')"
                placeholder="{{trans('order.begin_time')}}" name="begin_time"
                value="{{$where['begin_time']}}" />—— <input
                        style="width: 170px; border: 1px solid #ccc;"
                        notice_date"
                onclick="SelectDate(this,'yyyy-MM-dd hh:mm:ss')"
                placeholder="{{trans('order.end_time')}}" name="end_time" value="{{$where['end_time']}}" />
            </p>
            <p class="search_p">
                <label></label><input type="submit" id="search" class="btn btn-info" value="{{trans('public.but.search')}}" />
                <!--  <a
                    href="/index.php/ad_order_list">
                    <button type="button" class="btn btn-info export_excel">导出</button> -->
                </a>
            </p>
        </form>
    </div>
    <div class="result-wrap">

        <div class="result-title">

            <div class="result-list" style="text-align: right;">

                <form name="myform" id="myform" method="post">
                    <!-- <a href="/index.php/ad_platform_export">
                        <button type="button" class="btn btn-info export_excel">导出</button>
                    </a> -->

            </div>
        </div>
        <div class="result-content">
            <table class="result-tab tablesorter" id="myTable" width="100%">
                <thead>
                <tr>
                    <th>{{--订单号--}}{{trans('order.order_num')}}</th>
                    <th>{{--用户名--}}{{trans('order.uname')}}</th>
                    <th>{{--店铺名--}}{{trans('order.shop_name')}}</th>
                    <th>{{--彩种--}}{{trans('order.list_search.cz')}}</th>
                    <th>{{trans('order.qishu')}}</th>
                    <th>{{--下单时间--}}{{trans('order.order_date')}}</th>
                    <th>{{--订单状态--}}{{trans('order.order_state')}}</th>
                    <th>{{--操作--}}{{trans('order.operation')}}</th>
                </tr>
                </thead>
                <tbody>
                <?php if(!empty($lists)): ?>
                <?php foreach($lists as $key => $value): ?>
                <tr>

                    <td>{{ $value->order_num }}</td>
                    <td>{{ $value->real_name }}</td>
                    <td>{{ $value->shop_name }}</td>
                    <td>{{$type_arr[$value->type]}}</td>
                    <td>{{ $value->order_qi }}</td>
                    <td>{{date('Y-m-d H:i:s',$value->order_date+28800)}}</td>
                    <td>{{$s_arr[$value->status] }}</td>
                    <td><a id="updateOrd" href="/index.php/ad_order?id={{ $value->id }}"><button type="button" class="btn btn-info">{{--编辑--}}{{trans('public.but.edit')}}</button></a>

                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
            <!--<div class="list-page"> 2 条 1/1 页</div>-->
            {!! $lists->render() !!}
        </div>
        </form>
    </div>
@stop
@section('js')
    <script src="/admin/js/adddate.js"></script>
@stop
