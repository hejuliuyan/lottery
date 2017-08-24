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

        .update_btn {
            margin-right: 10px
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
        <dt class="active" data-id="1">基本信息</dt>
        <dt data-id="2">出票照片</dt>
        <dt data-id="3">中奖详情</dt>
        <dt data-id="4">订单状态</dt>
        <div style="clear: both;"></div>
    </div>
    <div class="result-wrap result-one">
        <?php if(!empty($data)): ?>
        <div class="result-content">
            <div class='mem_detail'>
                <div class='mem_d'>
                    <div class='mem_title'>{{--订单号--}}{{trans('order.order_num')}}</div>
                    <div class='mem_content mem_id'>{{$data[0]->order_num}}</div>
                </div>
                <div class='mem_d'>
                    <div class='mem_title'>{{--用户名--}}{{trans('order.uname')}}</div>
                    <div class='mem_content '>{{$data[0]->real_name}}</div>
                </div>
                <div class='mem_d'>
                    <div class='mem_title'>{{--店铺名--}}{{trans('order.shop_name')}}</div>
                    <div class='mem_content mem_account'>{{$data[0]->shop_name}}</div>
                </div>
                <div class='mem_d'>
                    <div class='mem_title'>{{--彩种--}}{{trans('order.list_search.cz')}}</div>
                    <div class='mem_content mem_name'>{{$type_arr[$data[0]->type]}}</div>
                </div>
                <div class='mem_d'>
                    <div class='mem_title'>{{--下单时间--}}{{trans('order.order_date')}}</div>
                    <div class='mem_content mem_idcard'>{{date('Y-m-d
                                H:i:s',$data[0]->order_date)}}</div>
                </div>
                <div class='mem_d'>
                    <div class='mem_title'>{{--订单状态--}}{{trans('order.order_state')}}</div>
                    <div class='mem_content mem_cp'>{{$s_arr[$data[0]->status]}}</div>
                </div>
                <div class='mem_d'>
                    <div class='mem_title'>{{--更新时间--}}{{trans('order.up_date')}}</div>
                    <div class='mem_content mem_cp'>{{date('Y-m-d H:i:s',$data[0]->update_date+28800)}}</div>
                </div>
                <!-- <div class="topbar-wrap white">
                <div class="topbar-inner clearfix"></div>
            </div> -->

            </div>
            <div class='mem_detail mem_detail_list'>
                <div class='mem_d'>
                    <div class='mem_title'>{{--取票方式--}}{{trans('order.qpfs')}}</div>
                    <div class='mem_content mem_id'>
                        <?php if($data[0]->order_type == 1): ?>
                        {{--自行取票--}}{{trans('order.tctt')}}
                        <?php else: ?>
                        {{--代管代兑--}}{{trans('order.teg')}}
                        <?php endif; ?>
                    </div>
                </div>
                <div class='mem_d'>
                    <div class='mem_title'>{{--期数--}}{{trans('order.qishu')}}</div>
                    <div class='mem_content mem_phone'>{{$data[0]->order_qi}}</div>
                </div>
                <div class='mem_d'>
                    <div class='mem_title'>{{--注数--}}{{trans('order.zhushu')}}</div>
                    <div class='mem_content mem_account'>{{$data[0]->order_z}}</div>
                </div>
                <div class='mem_d'>
                    <div class='mem_title'>{{--倍数--}}{{trans('order.beishu')}}</div>
                    <div class='mem_content mem_name'>{{$data[0]->order_b}}</div>
                </div>
                <div class='mem_d'>
                    <div class='mem_title'>{{--追加--}}{{trans('order.additional')}}</div>
                    <div class='mem_content mem_idcard'>
                        <?php if($data[0]->add == 1): ?>
                        {{--已追加--}}{{trans('order.additional_ok')}}
                        <?php else: ?>
                        {{--未追加--}}{{trans('order.additional_no')}}
                        <?php endif; ?></div>
                </div>
                <div class='mem_d'>
                    <div class='mem_title'>{{--金额--}}{{trans('order.money')}}</div>
                    <div class='mem_content mem_cp'>{{$data[0]->order_money}}</div>
                </div>
                <div class='mem_d'>
                    <div class='mem_title'>{{--创建时间--}}{{trans('order.create_time')}}</div>
                    <div class='mem_content mem_cp'>{{date('Y-m-d H:i:s',$data[0]->order_date+28800)}}</div>
                </div>
            </div>
            <div class="haoma">
                <div class='haoma_left'>{{--投注号码--}}{{trans('order.tz_num')}}</div>

                <div class='haoma_right'>

                    {{--大乐透部分--}}
                    @if($data[0]->type=='01')
                        <?php foreach ($data[0]->numbers as $k=>$val): ?>
                        <div>
                            <?php $arr = explode("|", $val); ?>
                            <?php foreach ($arr as $k=>$val_a){
                            $arr_d = explode(";", $val_a);
                            if(count($arr_d) > 1){
                            if ($k == '0') {
                                echo '<label style="color: red">前胆</label>';
                            } else {
                                echo '<label style="color: red">后胆</label>';
                            }
                            for($i = 0;$i < count($arr_d) - 1;$i++){?>
                            <input type="text" value="{{$arr_d[$i]}}" class="number_c" disabled="disabled"/>
                            <?php }
                            if ($k == '0') {
                                echo '<label>前区</label>';
                            } else {
                                echo '<label>后区</label>';
                            }
                            $num = count($arr_d) - 1;
                            $arr_l = explode(",", $arr_d[$num]);
                            foreach($arr_l as $v){?>
                            <input type="text" value="{{$v}}" class="number_c" disabled="disabled"/>
                            <?php }
                            }else{
                            if ($k == '0') {
                                echo '<label>前区</label>';
                            } else {
                                echo '<label>后区</label>';
                            }
                            $arr_l = explode(",", $val_a);
                            foreach($arr_l as $v){?>
                            <input type="text" value="{{$v}}" class="number_c" disabled="disabled"/>
                            <?php }
                            }
                            } ?>
                        </div>
                        <?php endforeach; ?>
                    @elseif($data[0]->type=='03')
                        @if($data[0]->tz_type=='0')
                            {{--{{$data[0]->tz_type}}--}}
                            @foreach($data[0]->numbers as $k=>$val)
                                <div>
                                    <?php $arr = explode("|", $val); ?>
                                    @foreach($arr as $k=>$v)
                                        <input type="text" value="{{$v}}" class="number_c" disabled="disabled"/>
                                    @endforeach
                                </div>
                            @endforeach
                        @else
                            @foreach($data[0]->numbers as $k=>$val)
                                <div>
                                    <?php $arr = explode(";", $val); ?>
                                    <?php $d_num = count($arr) - 1; ?>
                                    @foreach($arr as $k=>$v)
                                        <?php $arr_lists = explode(",", $v); ?>
                                        <?php $num = count($arr_lists) - 1; ?>
                                        @foreach($arr_lists as $kk=>$val_a)
                                            @if(($kk==$num)&&($k!=$d_num))
                                                <label>胆</label>
                                            @else
                                                <label>托</label>
                                            @endif
                                            <input type="text" value="{{$val_a}}" class="number_c"
                                                   disabled="disabled"/>
                                        @endforeach
                                    @endforeach
                                </div>
                            @endforeach
                        @endif
                    @elseif($data[0]->type=='02')
                        @foreach($data[0]->numbers as $k=>$val)
                            <div>
                                <?php $arr = explode("|", $val); ?>
                                <?php $lie = array(
                                        '0' => '一',
                                        '1' => '二',
                                        '2' => '三',
                                        '3' => '四',
                                        '4' => '五',
                                        '5' => '六',
                                        '6' => '七',
                                ) ?>
                                @foreach($arr as $k=>$v)
                                    <label>{{$lie[$k]}}</label>
                                    <?php $arr_v = explode(",", $v); ?>
                                    @foreach($arr_v as$kk=>$vv)
                                        <input type="text" value="{{$vv}}" class="number_c" disabled="disabled"/>
                                    @endforeach
                                @endforeach
                            </div>
                        @endforeach
                    @elseif($data[0]->type=='04')
                        @foreach($data[0]->numbers as $k=>$val)
                            <div>
                                <?php $arr = explode("|", $val); ?>
                                <?php $lie = array(
                                        '0' => '万',
                                        '1' => '千',
                                        '2' => '百',
                                        '3' => '十',
                                        '4' => '个'
                                ) ?>
                                @foreach($arr as $k=>$v)
                                    <label>{{$lie[$k]}}</label>
                                    <?php $arr_v = explode(",", $v); ?>
                                    @foreach($arr_v as$kk=>$vv)
                                        <input type="text" value="{{$vv}}" class="number_c" disabled="disabled"/>
                                    @endforeach
                                @endforeach
                            </div>
                        @endforeach
                    @endif
                </div>

                <a href="javascript:history.go(-1)" class="btn btn-info back_btn" style='width: 150px;'>返回<a/>

            </div>

        </div>
        <?php endif; ?>
    </div>

    <div class="result-wrap result-two">
        <?php if(!empty($pic)): ?>
        <?php foreach($pic as $k=>$v): ?>
        <img src="/Uploads/photo/{{$v->p_name}}" width="150px" height="180px" / >
        <?php endforeach;?>
        <?php endif; ?>
        <p style="margin-top:20px;">
            <a href="/index.php/ad_order_list" class="btn btn-info back_btn"
               style='width: 150px;'>返回</a></p>
        <!-- <img src="" /> -->
    </div>
    <div class="result-wrap result-three"
         style='width: 50%; min-height: 300px;'>
        <div class='zj_detail'>
            <table class='zj_tab' width="90%" style='text-align: center;'>
                <tr>
                    <th>奖级</th>
                    <th>中奖注数</th>
                    <th>奖金</th>
                </tr>
            </table>
            <div class='zj_total'>
                中奖总金额：&nbsp;&nbsp;<span class='f_red zj_money'><input
                            class='z_mon' type="text" value='' style='width: 100px'></span>&nbsp;&nbsp;<span
                        class='zj_font'>元</span>
            </div>
            <div class='butn' style='padding-left: 65px; margin-top: 20px'>
                <button type="button" class="btn btn-info update_btn"
                        style='width: 30%; margin-right: 5%;'>修改
                </button>
                &nbsp;&nbsp;
                <button type="button" class="btn btn-info back_btn"
                        style='width: 30%;'>返回
                </button>
            </div>

        </div>

    </div>
    <div class="result-wrap result-four"
         style='width: 50%; min-height: 300px;'>
        <div class='zj_detail'>
            <table class='order_tab' width="90%">
                <tr>
                    <th>订单操作</th>
                    <th>时间</th>
                </tr>
                <tr>
                    <td>用户支付</td>
                    <td class='user_pay'>-</td>
                </tr>
                <tr>
                    <td>店铺接单</td>
                    <td class='shop_jd'>-</td>
                </tr>
                <tr>
                    <td>店铺出票</td>
                    <td class='shop_cp'>-</td>
                </tr>
                <tr>
                    <td>确认出票</td>
                    <td class='user_ready'>-</td>
                </tr>
                <tr>
                    <td>用户退单</td>
                    <td class='user_out'>-</td>
                </tr>
                <tr>
                    <td>店铺派奖</td>
                    <td class='shop_pj'>-</td>
                </tr>
            </table>
            <div class='butn' style='padding-left: 65px; margin-top: 20px;'>
               {{-- <button type="button" class="btn btn-info out_btn"
                        style='width: 35%; margin-right: 8%; margin-left: 3%;'>退单
                </button>--}}
                &nbsp;&nbsp;
                <button type="button" class="btn btn-info back_btn"
                        style='width: 35%;'>返回
                </button>
            </div>

        </div>

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
            if (data_id == 1) {
                $('.result-one').show();
                $('.result-two').hide();
                $('.result-three').hide();
                $('.result-four').hide();
            } else if (data_id == 2) {
                $('.result-one').hide();
                $('.result-two').show();
                $('.result-three').hide();
                $('.result-four').hide();
            } else if (data_id == 3) {
                $('.result-one').hide();
                $('.result-two').hide();
                $('.result-three').show();
                $('.result-four').hide();
            } else if (data_id == 4) {
                $('.result-one').hide();
                $('.result-two').hide();
                $('.result-three').hide();
                $('.result-four').show();
            }
        });

        $.ajax('/index.php/zj_detail', {
            data: {
                order_id: order_id,
            },
            dataType: 'json',//服务器返回json格式数据
            type: 'post',//HTTP请求类型
            timeout: 10000,//超时时间设置为10秒；
            success: function (data) {
                if (typeof data == "string") {
                    var data = eval('(' + data + ')');
                }
                //console.log(data);
                var a = '';
                var b = '';
                var c = '';
                var d = '';
                var e = '';
                var f = '';
                var g = '';
                if (data.type == '01') {

                    if (parseInt(data.one.money) > 0 && data.one.z > 0) {
                        a = "<tr><td>一等奖(含追加)</td><td>" + data.one.z + "</td><td>" + data.one.money + "</td></tr>";
                        jQuery('.zj_tab').append(a);

                    }

                    if (parseInt(data.two.money) > 0 && data.two.z > 0) {
                        b = "<tr><td>二等奖(含追加)</td><td>" + data.two.z + "</td><td>" + data.two.money + "</td></tr>";
                        jQuery('.zj_tab').append(b);

                    }

                    if (parseInt(data.three.money) > 0 && data.three.z > 0) {
                        c = "<tr><td>三等奖(含追加)</td><td>" + data.three.z + "</td><td>" + data.three.money + "</td></tr>";
                        jQuery('.zj_tab').append(c);

                    }

                    if (parseInt(data.four.money) > 0 && data.four.z > 0) {
                        d = "<tr><td>四等奖(含追加)</td><td>" + data.four.z + "</td><td>" + data.four.money + "</td></tr>";
                        jQuery('.zj_tab').append(d);

                    }

                    if (parseInt(data.five.money) > 0 && data.five.z > 0) {
                        e = "<tr><td>五等奖(含追加)</td><td>" + data.five.z + "</td><td>" + data.five.money + "</td></tr>";
                        jQuery('.zj_tab').append(e);

                    }

                    if (parseInt(data.six.money) > 0 && data.six.z > 0) {
                        f = "<tr><td>六等奖(含追加)</td><td>" + data.six.z + "</td><td>" + data.six.money + "</td></tr>";
                        jQuery('.zj_tab').append(f);

                    }
                } else if (data.type == '03') {
                    if (parseInt(data.zx.money) > 0 && data.zx.z > 0) {
                        a = "<tr><td>直选</td><td>" + data.zx.z + "</td><td>" + data.zx.money + "</td></tr>";
                        jQuery('.zj_tab').append(a);

                    }

                    if (parseInt(data.z3.money) > 0 && data.z3.z > 0) {
                        b = "<tr><td>组三</td><td>" + data.z3.z + "</td><td>" + data.z3.money + "</td></tr>";
                        jQuery('.zj_tab').append(b);

                    }

                    if (parseInt(data.z6.money) > 0 && data.z6.z > 0) {
                        c = "<tr><td>组六</td><td>" + data.z6.z + "</td><td>" + data.z6.money + "</td></tr>";
                        jQuery('.zj_tab').append(c);

                    }

                    if (parseInt(data.zdan.money) > 0 && data.zdan.z > 0) {
                        d = "<tr><td>直选复式胆拖</td><td>" + data.zdan.z + "</td><td>" + data.zdan.money + "</td></tr>";
                        jQuery('.zj_tab').append(d);

                    }

                   if (parseInt(data.hz_zx.money) > 0 && data.hz_zx.z > 0) {
                        e = "<tr><td>和值·直选</td><td>" + data.hz_zx.z + "</td><td>" + data.hz_zx.money + "</td></tr>";
                        jQuery('.zj_tab').append(e);

                    }
                            
                    if (parseInt(data.hz_z3.money) > 0 && data.hz_z3.z > 0) {
                        f = "<tr><td>和值·组三</td><td>" + data.hz_z3.z + "</td><td>" + data.hz_z3.money + "</td></tr>";
                        jQuery('.zj_tab').append(f);

                    }
                    
                    if (parseInt(data.hz_z6.money) > 0 && data.hz_z6.z > 0) {
                        g = "<tr><td>和值·组六</td><td>" + data.hz_z6.z + "</td><td>" + data.hz_z6.money + "</td></tr>";
                        jQuery('.zj_tab').append(g);

                    }

                    jQuery('.z_mon').val(data.new_total);
                } else if (data.type == '04') {
                    if (parseInt(data.zx.money) > 0 && data.zx.z > 0) {
                        a = "<tr><td>一等奖</td><td>" + data.zx.z + "</td><td>" + data.zx.money + "</td></tr>";
                        jQuery('.zj_tab').append(a);
                    }

                    jQuery('.z_mon').val(data.new_total);

                } else if (data.type == '02') {

                    if (parseInt(data.one.money) > 0 && data.one.z > 0) {
                        a = "<tr><td>一等奖(含追加)</td><td>" + data.one.z + "</td><td>" + data.one.money + "</td></tr>";
                        jQuery('.zj_tab').append(a);

                    }

                    if (parseInt(data.two.money) > 0 && data.two.z > 0) {
                        b = "<tr><td>二等奖(含追加)</td><td>" + data.two.z + "</td><td>" + data.two.money + "</td></tr>";
                        jQuery('.zj_tab').append(b);

                    }

                    if (parseInt(data.three.money) > 0 && data.three.z > 0) {
                        c = "<tr><td>三等奖(含追加)</td><td>" + data.three.z + "</td><td>" + data.three.money + "</td></tr>";
                        jQuery('.zj_tab').append(c);

                    }

                    if (parseInt(data.four.money) > 0 && data.four.z > 0) {
                        d = "<tr><td>四等奖(含追加)</td><td>" + data.four.z + "</td><td>" + data.four.money + "</td></tr>";
                        jQuery('.zj_tab').append(d);

                    }

                    if (parseInt(data.five.money) > 0 && data.five.z > 0) {
                        e = "<tr><td>五等奖(含追加)</td><td>" + data.five.z + "</td><td>" + data.five.money + "</td></tr>";
                        jQuery('.zj_tab').append(e);

                    }

                    if (parseInt(data.six.money) > 0 && data.six.z > 0) {
                        f = "<tr><td>六等奖(含追加)</td><td>" + data.six.z + "</td><td>" + data.six.money + "</td></tr>";
                        jQuery('.zj_tab').append(f);

                    }

                    jQuery('.z_mon').val(data.new_total);
                }
            },
            error: function (xhr, type, errorThrown) {
                //异常处理；
                console.log(type);
            }
        })


        $.ajax('/index.php/order_detail_log', {
            data: {
                order_id: order_id,
            },
            dataType: 'json',//服务器返回json格式数据
            type: 'post',//HTTP请求类型
            timeout: 10000,//超时时间设置为10秒；
            success: function (data) {
                if (typeof data == "string") {
                    var data = eval('(' + data + ')');
                }
                //console.log(data);
                if (data) {
                    var len = data.length;
                    for (var i = 0; i < len; i++) {
                        if (data[i].order_status == '01') {
                            $('.user_pay').html(data[i].new_time);
                        }

                        if (data[i].order_status == '02') {
                            $('.shop_jd').html(data[i].new_time);
                        }

                        if (data[i].order_status == '03') {
                            $('.shop_cp').html(data[i].new_time);
                        }

                        if (data[i].order_status == '04') {
                            $('.user_ready').html(data[i].new_time);
                        }

                        if (data[i].order_status == '05') {
                            $('.user_out').html(data[i].new_time);
                        }

                        if (data[i].order_status == '07') {
                            $('.shop_pj').html(data[i].new_time);
                        }

                    }
                }
            },
            error: function (xhr, type, errorThrown) {
                //异常处理；
                console.log(type);
            }
        });

        $(document).on('click', '.out_btn', function () {
            $.ajax('/index.php/order_check', {
                data: {
                    order_id: order_id,
                },
                dataType: 'json',//服务器返回json格式数据
                type: 'post',//HTTP请求类型
                timeout: 10000,//超时时间设置为10秒；
                success: function (data) {
                    if (typeof data == "string") {
                        var data = eval('(' + data + ')');
                    }

                    if (data == 1 || data == 3) {
                        $.ajax('/index.php/user_out', {
                            data: {
                                order_id: order_id,
                            },
                            dataType: 'json',//服务器返回json格式数据
                            type: 'post',//HTTP请求类型
                            timeout: 10000,//超时时间设置为10秒；
                            success: function (data) {
                                if (typeof data == "string") {
                                    var data = eval('(' + data + ')');
                                }

                                if (data == true) {
                                    $.ajax('/index.php/orderlog', {
                                        data: {
                                            order_id: order_id, order_status: '05', value: '用户已退单',
                                        },
                                        dataType: 'json',//服务器返回json格式数据
                                        type: 'post',//HTTP请求类型
                                        timeout: 10000,//超时时间设置为10秒；
                                        success: function (data) {
                                            /* if(typeof data == "string") {
                                             var data = eval('('+data+')');
                                             }*/
                                            alert('退单成功');
                                            window.location.href = '/index.php/ad_order_list';
                                        },
                                        error: function (xhr, type, errorThrown) {
                                            //异常处理；
                                            console.log(type);
                                        }
                                    });

                                } else if (data == false) {
                                    alert('退单失败');
                                }
                            },
                            error: function (xhr, type, errorThrown) {
                                //异常处理；
                                console.log(type);
                            }
                        });
                    } else {
                        alert('操作无效');
                    }
                },
                error: function (xhr, type, errorThrown) {
                    //异常处理；
                    console.log(type);
                }
            });

        })

        $(document).on('click', '.update_btn', function () {
            var win_mon = $('.z_mon').val();
            if (win_mon == '' || win_mon == null || win_mon == undefined) {
                alert('金额不能为空');
                return;
            } else if (num(win_mon) == false) {
                alert('请输入正确的数字');
                return;
            } else {
                var r = confirm('确定修改中奖金额？');
                if (r == true) {
                    $.ajax('/index.php/order_check', {
                        data: {
                            order_id: order_id,
                        },
                        dataType: 'json',//服务器返回json格式数据
                        type: 'post',//HTTP请求类型
                        timeout: 10000,//超时时间设置为10秒；
                        success: function (data) {
                            if (typeof data == "string") {
                                var data = eval('(' + data + ')');
                            }
                            //console.log(data);
                            if (data == false) {
                                alert('未知异常');
                            } else if (data == 6) {
                                $.ajax('/index.php/update_total', {
                                    data: {
                                        order_id: order_id, win_total: win_mon,
                                    },
                                    dataType: 'json',//服务器返回json格式数据
                                    type: 'post',//HTTP请求类型
                                    timeout: 10000,//超时时间设置为10秒；
                                    success: function (data) {
                                        if (typeof data == "string") {
                                            var data = eval('(' + data + ')');
                                        }
                                        //console.log(data);
                                        if (data == false) {
                                            alert('请修改后再提交');
                                        } else {
                                            alert('修改成功');
                                            window.location.href = '/index.php/ad_order_list';
                                        }


                                    },
                                    error: function (xhr, type, errorThrown) {
                                        //异常处理；
                                        console.log(type);
                                    }
                                });
                            } else {
                                alert('订单已派奖，不能修改');
                            }


                        },
                        error: function (xhr, type, errorThrown) {
                            //异常处理；
                            console.log(type);
                        }
                    });


                } else {

                }
            }
        })

        $(document).on('click', '.back_btn', function () {
            window.location.href = '/index.php/ad_order_list';
        })


        //数字匹配
        function num(obj) {

            reg = /^[1-9][0-9]+$/;
            if (!reg.test(obj)) {
                return false;
            } else {
                return true;
            }
        }

    </script>
    <script src="/admin/js/adddate.js"></script>
@stop