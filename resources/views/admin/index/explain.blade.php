@extends('admin.public.base')
@section('style')
    <style>
        .kj_dt dt {
            margin-left: 10px;
            margin-right: 20px;
        }

        .result-three {
            display: none;
        }

        .result-four {
            display: none;
        }

        .zj_tab, .order_tab {
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

        .zj_total {
            width: 90%;
            margin-left: 5%;
            margin-top: 10px;
            margin-bottom: 10px;
            height: 30px;
            line-height: 30px;
            text-align: left;
            font-size: 14px;
        }

        .zj_money, .zj_font {
            font-size: 20px;
        }

        .mem_d div {
            float: left;
        }

        .mem_d {
            width: 50%;
            height: 35px;
            text-align: center;
            line-height: 35px;
        }

        .mem_detail {
            margin-left: 2%;
            margin-top: 4px;
            width: 45%;
            min-height: 200px;
            text-align: center;
            float: left;
        }

        .mem_title {
            width: 35%;
            height: 30px;
        }

        .mem_content {
            width: 65%;
            height: 30px;
        }

        .result-content {
            overflow: hidden;
        }

        .haoma {
            clear: both;
            padding-left: 4%;
        }

        .number_c {
            width: 30px;
            height: 20px;
        }

        .haoma_left {
            width: 6%;
            float: left;
        }

        .haoma_right {
            width: 94%;
            float: right;
        }

        label {
            margin: 10px;
        }

        .haoma_right > div {
            margin-bottom: 15px;
        }
    </style>
@stop
@section('title1')
    {{--订单管理--}}{{trans('order.title')}}
@stop
@section('title2')
    {{--详情--}}{{trans('order.title_info')}}
@stop
@section('content')
    <div class="kj_dt">
        <dt class="active" data-id="1">基本操作</dt>
        <dt data-id="2">产品管理</dt>
        <dt data-id="3">中奖详情</dt>
        <dt data-id="4">订单状态</dt>
        <div style="clear: both;"></div>
    </div>
    <div class="result-wrap result-one" data-id="1">
    </div>
    <div class="result-wrap result-two" data-id="2">
    </div>
    <div class="result-wrap result-three" data-id="3"
         style='width: 50%; min-height: 300px;'>
    </div>
    <div class="result-wrap result-four" data-id="4"
         style='width: 50%; min-height: 300px;'>
    </div>

@stop
@section('js')
    <script>
        var url = window.location.search;
        var order_id = url.substring(url.lastIndexOf('=') + 1, url.length);
        $(document).on('click', '.kj_dt dt', function () {
            $(".kj_dt dt").removeClass("active");
            $(this).addClass("active");
            var data_id = $(this).attr('data-id');
            $(".result-wrap").each(function (i) {
                if ($(this).attr('data-id') == data_id) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });


        $(document).on('click', '.back_btn', function () {
            window.location.href = '/index.php/ad_order_list';
        })
    </script>
    <script src="/admin/js/adddate.js"></script>
@stop