@extends('admin.public.base')
@section('style')
    <style>
        .order_tab {
            border-collapse: collapse;
            border: 1px solid #ddd;
            margin-left: 5%;
        }

        .zj_tab th, .zj_tab td, .order_tab th, .order_tab td {
            padding: 5px;
            border-bottom: 1px solid #ddd;
            border-right: 1px solid #e1e1e1;
        }

        .zj_tab th, .order_tab th {
            font-weight: normal;
            font-size: 12px;
            text-align: center;
            background-color: #f9f9f9
        }

        .zj_tab tr, .order_tab tr {
            line-height: 25px;
        }

        .zj_tab td, .order_tab td {
            font-weight: normal;
            font-size: 12px;
        }

        .order_tab td {
            text-align: center;
        }
    </style>
@stop
@section('title1')
    {{--账务一览--}}{{trans('accounts.title1')}}
@stop
@section('title2')
    @if($type == 'shop')
        店铺帐务
    @else
        个人帐务
    @endif
    {{--详情--}}{{--{{trans('accounts.title2')}}--}}
@stop
@section('content')
    <div class="result-wrap result-four"
         style='width: 50%; min-height: 300px;'>
        <div class='zj_detail'>
            <table class='order_tab' width="90%">
                <tr>
                    <th width="30%">{{--栏目--}}{{trans('accounts.col')}}</th>
                    <th>{{--内容--}}{{trans('accounts.con')}}</th>
                </tr>
                {{--<tr>
                    <td>用户</td>
                    <td class='user_pay'>-</td>
                </tr>--}}
                <tr>
                    <td>{{--账户余额--}}{{trans('accounts.balance')}}</td>
                    <td class='user_pay'>
                        @if(isset($data[0]->balance))
                            {{$data[0]->balance}}
                        @else
                            0
                        @endif
                    </td>
                </tr>
                @if(isset($data[0]->margin))
                    <tr>
                        <td>{{--保证金额--}}{{trans('accounts.guarantee')}}</td>
                        <td class='shop_jd'>{{$data[0]->margin}}</td>
                    </tr>
                @elseif(isset($data[0]->winprize))
                    <tr>
                        <td>{{--兑奖金额--}}{{trans('accounts.ticket')}}</td>
                        <td class='shop_jd'>
                            @if(isset($data[0]->winprize))
                                {{$data[0]->winprize}}
                            @endif
                        </td>
                    </tr>
                @elseif(isset($data[0]->giveprize))
                    <tr>
                        <td>{{--派奖金额--}}{{trans('accounts.send')}}</td>
                        <td class='shop_jd'>
                            @if(isset($data[0]->giveprize))
                                {{$data[0]->giveprize}}
                            @endif
                        </td>
                    </tr>
                @endif
                <tr>
                    <td>{{--流入金额--}}{{trans('accounts.inflows')}}</td>
                    <td class='shop_cp'>
                        @if(isset($data[0]->receipts))
                            {{$data[0]->receipts}}
                        @else
                            0
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>{{--流出金额--}}{{trans('accounts.out_of')}}</td>
                    <td class='user_ready'>
                        @if(isset($data[0]->withdraw))
                            {{$data[0]->withdraw}}
                        @else
                            0
                        @endif
                    </td>
                </tr>
                {{-- <tr>
                     <td>用户退单</td>
                     <td class='user_out'>-</td>
                 </tr>
                 <tr>
                     <td>店铺派奖</td>
                     <td class='shop_pj'>-</td>
                 </tr>--}}
            </table>


        </div>

    </div>
@stop