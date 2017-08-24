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
            width:150px;
            height:30px;
            line-height:30px;
            font-size: small;
            padding:0px;
        }
    </style>
@stop
@section('title1')
    {{--财务管理--}}{{trans('financial.title1')}}
@stop
@section('title2')
    {{--平台帐务--}}{{trans('financial.flat_title2')}}
@stop
@section('content')

    <div class="search">
        <form action="/index.php/ad_platform_show" method="get">
            <p class="search_p">
                <label for="trans_id">{{--帐务号--}}{{trans('financial.search.trans_id')}}：</label><input type="text" name="trans_id" id="trans_id"
                                                         placeholder="{{--请输入账务号--}}{{trans('financial.search.trans_pla')}}" value="{{ $where['trans_id'] }}">
            </p>
            <p class="search_p">
                <label for="document_id">{{--交易单号--}}{{trans('financial.search.document_id')}}：</label><input type="text" name="document_id" id="document_id"
                                                             placeholder="{{--请输入交易单号--}}{{trans('financial.search.document_pla')}}" value="{{$where['document_id']}}">
            </p>
            <p class="search_p">
                <label for="order_id">{{--订单号--}}{{trans('financial.search.order_id')}}：</label><input type="text" name="order_id" id="order_id" placeholder="{{--请输入订单号--}}{{trans('financial.search.order_pla')}}"
                                                         value="{{$where['order_id']}}">
            </p>
            <p class="search_p">
                <label for="">{{--时间--}}{{trans('financial.search.time')}}：</label><input style="width: 170px; border: 1px solid #ccc;"
                                                notice_date"
                onclick="SelectDate(this,'yyyy-MM-dd hh:mm:ss')"
                placeholder="{{trans('financial.search.start_time')}}" name="statr_time" value="{{$where['statr_time']}}" />——
                <input style="width: 170px; border: 1px solid #ccc;"
                       notice_date"
                onclick="SelectDate(this,'yyyy-MM-dd hh:mm:ss')"
                placeholder="{{trans('financial.search.end_time')}}" name="end_time" value="{{$where['end_time']}}" />
            </p>
            <p class="search_p">
                <label for=""></label><input type="submit" id="search" class="btn btn-info btn_s" value="{{--检索--}}{{trans('financial.search.search')}}" /> <a
                        href="/index.php/ad_platform_export">
                    <button type="button" class="btn btn-info export_excel btn_s">{{--导出EXCEL--}}{{trans('financial.search.xls')}}</button>
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
                    <th>{{--帐务号--}}{{trans('financial.search.trans_id')}}</th>
                    <th>{{--帐户名--}}{{trans('financial.trans_name')}}</th>
                    <th>{{--对方账户--}}{{trans('financial.opp_name')}}</th>
                    <th>{{--交易科目--}}{{trans('financial.trans_title')}}</th>
                    <th>{{--交易金额--}}{{trans('financial.money')}}</th>
                    <th>{{--交易单号--}}{{trans('financial.search.document_id')}}</th>
                    <th>{{--订单号--}}{{trans('financial.search.order_id')}}</th>
                    <th>{{--交易方式--}}{{trans('financial.trans_way')}}</th>
                    <th>{{--交易日期--}}{{trans('financial.date')}}</th>
                    <th>{{--账户余额--}}{{trans('financial.balance')}}</th>
                </tr>
                </thead>
                <tbody>
                <?php if(!empty($lists)): ?>
                <?php foreach($lists as $key => $value): ?>
                <tr>

                    <input name="id[]" value="" type="hidden">
                    <td>{{ $value->trans_id }}</td>
                    <td>{{ $value->trans_account }}</td>
                    <td>
                        <?php if(isset($value->opp_name)): ?>
                        {{ $value->opp_name }}
                        <?php else: ?>
                        无数据
                        <?php  endif ?>
                    </td>
                    <td><?php /*$arr[$value->trans_title] */?>{{$arr[$value->trans_title] }}</td>
                    <td>{{ $value->trans_price }}</td>


                    <td>{{ $value->document_id }}</td>
                    <td>
                        <?php if(isset($value->order_num)): ?>
                        {{ $value->order_num }}
                        <?php else: ?>
                        无数据
                    <?php  endif ?>
                    <!-- {{ $value->order_id }} -->
                    </td>
                    <td>银联支付</td>
                    <td>{{ $value->trans_date }}</td>
                    <td>{{ $value->trans_balance }}</td> {{--
								<td><a id="updateOrd"
									href="/index.php/ad_kjedit?id={{ $value->id }}">修改</a> <a
									id="batchDel" data-id="{{ $value->id }}"
									href="javascript:void(0)">删除</a></td>--}}
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