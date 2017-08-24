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
    {{trans('member.edit.title1')}}
@stop
@section('title2')
    {{trans('member.edit.title2')}}
@stop
@section('content')
    <div class="result-wrap">
        <div class='mem_detail'>
            <div class='mem_d'>
                <div class='mem_title'>{{trans('member.member_num')}}</div>
                <div class='mem_content mem_id'>{{$data[0]->id}}</div>
            </div>
            <div class='mem_d'>
                <div class='mem_title'>{{trans('member.phone')}}</div>
                <div class='mem_content mem_phone'>{{$data[0]->mobile}}</div>
            </div>
            <div class='mem_d'>
                <div class='mem_title'>{{trans('member.name')}}</div>
                <div class='mem_content mem_account'>{{$data[0]->account}}</div>
            </div>
            <div class='mem_d'>
                <div class='mem_title'>{{trans('member.edit.title_list.real_name')}}</div>
                <div class='mem_content mem_name'>{{$data[0]->real_name}}</div>
            </div>
            <div class='mem_d'>
                <div class='mem_title'>{{trans('member.edit.title_list.idcard')}}</div>
                <div class='mem_content mem_idcard'>{{$data[0]->idcard_numer}}</div>
            </div>
            @if(isset($data[0]->shop_name))
                <div class='mem_d'>
                    <div class='mem_title'>{{trans('member.edit.title_list.default_shop')}}</div>
                    <div class='mem_content mem_cp'>{{$data[0]->shop_name}}</div>
                </div>
            @endif
            <div class='mem_d'>
                <div class='mem_title'>{{trans('member.edit.title_list.c_time')}}</div>
                <div class='mem_content mem_create'>{{$data[0]->created_at}}</div>
            </div>
            <div class='mem_d'>
                <div class='mem_title'>{{trans('member.edit.title_list.u_time')}}</div>
                <div class='mem_content mem_update'>{{$data[0]->updated_at}}</div>
            </div>
            <div class='mem_d'>
                <div class='mem_title'>{{trans('member.edit.title_list.state')}}</div>
                <?php if($data[0]->active == 0){?>
                <div class='mem_content'>{{trans('public.but.enable')}}{{--启用--}}：<input type='radio' name='status' value='0'
                                                   checked/>&nbsp;&nbsp;{{trans('public.but.disable')}}：<input class='stop' type='radio'
                                                                                  name='status' value='1'/></div>
                <?php }else if($data[0]->active == 1){?>
                <div class='mem_content'>{{trans('public.but.enable')}}：<input type='radio' name='status' value='0'/>&nbsp;&nbsp;{{trans('public.but.disable')}}：<input
                            class='stop' type='radio' name='status' checked value='1'/></div>
                <?php }?>
            </div>
            <div class='mem_d' style='margin-top: 20px;'>
                <button type="button" class="btn btn-info update_btn" style='width:150px;margin-right:43px;'>{{trans('public.but.saves')}}
                </button>
                &nbsp;&nbsp;
                <button type="button" class="btn btn-info back_btn" style='width:150px;'>{{trans('public.but.return')}}</button>

            </div>
        </div>
    </div>
    <!--/main-->
@stop
@section('js')
    <script>


        $(document).on('click', '.back_btn', function () {
            window.history.back(-1);
        })


        $(document).on('click', '.update_btn', function () {
            var active = $("input[name = status]:checked").val();
            var id = $('.mem_id').text();
            $.ajax({
                type: "POST",
                url: "/index.php/mem_update",
                data: {
                    active: active, id: id,
                },
                datatype: "json",//"xml", "html", "script", "json", "jsonp", "text".
                success: function (data) {
                    if (typeof data == "string") {
                        var data = eval('(' + data + ')');
                    }
                    //console.log(data);
                    if (data == true) {
                        alert("{{trans('member.ok')}}");
                        window.location.href = '/index.php/ad_members';

                    } else {
                        alert("{{trans('member.null')}}");
                    }

                },
                error: function () {
                    //请求出错处理
                }
            });
        })

    </script>
@stop