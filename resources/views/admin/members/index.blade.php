@extends('admin.public.base')
@section('style')
    <style>
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
            width: 80%;
            min-height: 300px;
            text-align: center;
        }

        .mem_title {
            width: 50%;
            height: 30px;
        }

        .mem_content {
            width: 50%;
            height: 30px;
        }

        .update_btn {
            margin-right: 10px
        }

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
    </style>
@stop
@section('title1')
    {{trans('member.title1')}}
@stop
@section('title2')
    {{trans('member.title2')}}
@stop
@section('content')
    <div class="result-wrap">
        <form name="myform" id="myform" class='myform'>
            <div class="result-title">
                <div class="result-list" style="text-align: left; float: left;">
                    <form method='get' action="/index.php/ad_members">
                        <input type="text" placeholder='{{trans('member.input')}}' name='search_phone' id='search_phone'><a
                                href="javascript:void(0)" style='margin-left:20px'>
                            <input type="submit" class="btn btn-info btn_search" value='{{trans('public.but.search')}}'></a>
                    </form>

                    <!--  <button type="submit" class="btn btn-info btn_search">检索</button> -->
                </div>
            </div>
            <div class="result-content">
                <table class="result-tab tablesorter" id="myTable" width="100%">
                    <thead>
                    <tr>
                        <th>{{trans('member.member_num')}}{{--会员号--}}</th>
                        <th>{{trans('member.name')}}{{--用户名--}}</th>
                        <th>{{trans('member.phone')}}{{--手机号码--}}</th>
                        <th>{{trans('member.cr_time')}}{{--创建时间--}}</th>
                        {{--<th>状态</th>--}}
                        <th>{{trans('member.operating')}}{{--操作--}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(!empty($list)): ?>
                    <?php foreach($list as $key => $value): ?>
                    <tr>
                        <td>{{ $value->id }}</td>
                        <td>{{ $value->account }}</td>
                        <td>{{ $value->mobile }}</td>
                        <td>{{ $value->created_at }}</td>
                        {{--<td>{{ $value->new_status }}</td>--}}
                        <td>
                            <a href="/index.php/mem_edit_view?id={{$value->id}}"><button type="button" class="btn btn-info">{{trans('public.but.edit')}}</button></a>
                            <a href="/index.php/ad_member_show?id={{$value->id}}"><button type="button" class="btn btn-info">{{trans('public.but.money')}}</button></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
                <!--<div class="list-page"> 2 条 1/1 页</div>-->
            </div>
            {!! $list->render() !!}
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

    </script>
@stop