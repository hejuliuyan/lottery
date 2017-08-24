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

        .btn_s {
            width: 150px;
            height: 30px;
            line-height: 30px;
            font-size: small;
            padding: 0px;
        }
    </style>
@stop
@section('title1')
    {{--财务管理--}}{{trans('financial.title1')}}
@stop
@section('title2')
    {{--个人财务--}}{{trans('financial.personal_t2')}}
@stop
@section('content')

    <div class="search">
        <form action="/index.php/ad_personal_show" method="get">
            <p class="search_p">
                <label for="mobile">{{--手机号--}}{{trans('financial.search.mobile')}}：</label><input type="text" name="mobile" id="mobile"
                                                       placeholder="{{trans('financial.search.mobile_pla')}}" value="{{$where['mobile']}}">
            </p>
            <p class="search_p">
                <label for="document_id">{{--交易单号--}}{{trans('financial.search.document_id')}}：</label><input type="text" name="document_id" id="document_id"
                                                             placeholder="{{--请输入交易单号--}}{{trans('financial.search.document_pla')}}" value="{{$where['document_id']}}">
            </p>
            {{--<p class="search_p">
                <label for="order_id">--}}{{--订单号--}}{{--{{trans('financial.search.order_id')}}：</label><input type="text" name="order_id" id="order_id" placeholder="{{trans('financial.search.order_pla')}}"
                                                         value="{{$where['order_id']}}">
            </p>--}}
            <p class="search_p">
                <label for="">{{trans('financial.search.time')}}：</label><input style="width: 170px; border: 1px solid #ccc;"
                                                notice_date"
                onclick="SelectDate(this,'yyyy-MM-dd hh:mm:ss')"
                placeholder="{{trans('financial.search.start_time')}}" name="statr_time" value="{{$where['statr_time']}}" />——
                <input style="width: 170px; border: 1px solid #ccc;"
                       notice_date"
                onclick="SelectDate(this,'yyyy-MM-dd hh:mm:ss')"
                placeholder="{{trans('financial.search.end_time')}}" name="end_time" value="{{$where['end_time']}}" />
            </p>
            <p class="search_p">
                <label for=""></label><input type="submit" id="search" class="btn btn-info btn_s" value="{{trans('financial.search.search')}}" /> <a
                        href="/index.php/ad_export_personal">
                    <button type="button" class="btn btn-info export_excel btn_s">{{trans('financial.search.xls')}}</button>
                </a>
            </p>
        </form>


    </div>
    <div class="result-wrap">

        <div class="result-title">

            <div class="result-list" style="text-align: right;">
                <!-- <form action="/index.php/ad_platform_show" method="get">
                    <input type="text" name="document_id" id="where" placeholder="交易单号" value="">
                    <input type="text" name="order_id" id="phone" placeholder="订单号" value="">
                    <input type="submit"  id="search">
                </form> -->
                <form name="myform" id="myform" method="post">
                    <!--  <a href="/index.php/ad_export_personal">
                    <button type="button" class="btn btn-info export_excel">导出</button>
                </a> -->

            </div>
        </div>
        <div class="result-content">
            <table class="result-tab tablesorter" id="myTable" width="100%">
                <thead>
                <tr>
                    <th>{{--帐务号--}}{{trans('financial.search.trans_id')}}</th>
                    <th>{{--帐户名--}}{{trans('financial.trans_name')}}</th>
                    <th>{{--对方账户--}}{{trans('financial.opp_name')}}</th>
                    <th>{{--交易科目--}}{{trans('financial.trans_title')}}</th>
                    <th>{{--交易金额--}}{{trans('financial.money')}}</th>
                    <th>{{--交易单号--}}{{trans('financial.search.document_id')}}</th>

                    <th>{{--交易方式--}}{{trans('financial.trans_way')}}</th>
                    <th>{{--交易日期--}}{{trans('financial.date')}}</th>
                    <th>{{--账户余额--}}{{trans('financial.balance')}}</th>
                    <th>{{-- {{trans('financial.single_balance')}} --}}店铺余额</th>
                </tr>
                </thead>
                <tbody>
                <?php if(!empty($lists)): ?>
                <?php foreach($lists as $key => $value): ?>
                <tr>
                    <td>{{ $value->trans_id }}</td>
                    <td>{{ $value->real_name }}</td>
                    <td>@if(isset($value->opp_name))
                            {{ $value->opp_name }}
                        @endif
                    </td>

                    <td><?php /*$arr[$value->trans_title] */?>{{$arr[$value->trans_title] }}</td>
                    <td>{{ $value->trans_price }}</td>
                    <td>{{ $value->document_id }}</td>

                    <td>{{$way_arr[$value->trans_way] }}</td>
                    <td>{{ $value->trans_date }}</td>
                    <td>{{ $value->trans_balance }}</td>
                    <td>{{ $value->single_balance }}</td>
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