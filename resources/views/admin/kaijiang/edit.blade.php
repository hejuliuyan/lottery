@extends('admin.public.base')
@section('title1')
    {{trans('lottery.edit.title1')}}
@stop
@section('title2')
    {{trans('lottery.add.title2')}}
@stop
@section('content')
        <div class="kj_dt">
            <dt class="active" data-id="1">{{trans('lottery.edit.tit')}}</dt>
            <?php if($data[0]->types == 1 || $data[0]->types == 2){?>
            <dt data-id="2">{{trans('lottery.edit.zjje')}}</dt>
            <?php }?>
            <div style="clear: both;"></div>
        </div>
        <div class="result-wrap result-one">
            <div class="result-content">
                <table class="insert-tab" width="100%">
                    <input type="hidden" name="id" class="id" value="{{$data[0]->id}}"/>
                    <tbody>
                    <tr>
                        <th width="120"><i class="require-red">*</i>{{trans('lottery.add.fl')}}：</th>
                        <td>
                            <select name="name" id="kj_select">
                                <option value="">{{trans('lottery.index.option.0')}}</option>
                                <option value="01" <?php if ($data[0]->types == 1) echo 'selected'; ?>>{{trans('lottery.index.option.1')}}</option>
                                <option value="02" <?php if ($data[0]->types == 2) echo 'selected'; ?>>{{trans('lottery.index.option.2')}}</option>
                                <option value="03" <?php if ($data[0]->types == 3) echo 'selected'; ?>>{{trans('lottery.index.option.3')}}</option>
                                <option value="04" <?php if ($data[0]->types == 4) echo 'selected'; ?>>{{trans('lottery.index.option.4')}}</option>
                            </select>

                        </td>
                    </tr>

                    <tr>
                        <th><i class="require-red">*</i>{{trans('lottery.index.list_title.qishu')}}：</th>
                        <td>
                            <input class="common-text required" id="title" name="num" size="50"
                                   value="{{$data[0]->num}}" type="text">
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require-red">*</i>{{trans('lottery.add.kjhm')}}：</th>
                        <td class='kj_num'>
                            <?php if($data[0]->types == 1){?>
                            <div class="daletou">
                                前区：<?php foreach($data['num_q'] as $k=>$v){?>
                                <input class='dlt_qian' maxlength="2" value="{{$v}}">
                                <?php }?> &nbsp; &nbsp; &nbsp;
                                后区：<?php foreach($data['num_h'] as $kk=>$vo){?>
                                <input class='dlt_hou' maxlength="2" value="{{$vo}}">
                                <?php }?>
                            </div>
                            <?php }?>

                            <?php if($data[0]->types == 2){?>
                            <div class="qxc">
                                <?php foreach($data['new_num'] as $k=>$v){?>
                                <input class='qxc_num' maxlength="1" value="{{$v}}">
                                <?php }?>

                            </div>
                            <?php }?>

                            <?php if($data[0]->types == 3){?>
                            <div class="p3">
                                <?php foreach($data['new_num'] as $k=>$v){?>
                                <input class='p3_num' maxlength="1" value="{{$v}}">
                                <?php }?>
                            </div>
                            <?php }?>

                            <?php if($data[0]->types == 4){?>
                            <div class="p5">
                                <?php foreach($data['new_num'] as $k=>$v){?>
                                <input class='p5_num' maxlength="1" value="{{$v}}">
                                <?php }?>
                            </div>
                            <?php }?>


                        </td>
                    </tr>
                    <tr>
                        <th><i class="require-red">*</i>{{trans('lottery.index.list_title.kj_date')}}：</th>
                        <td><input style="width:170px;padding:7px 10px;border:1px solid #ccc;margin-right:10px;"
                                   value='{{$data[0]->notice_date}}' class="notice_date"
                                   name="notice_date"
                                   onclick="SelectDate(this,'yyyy-MM-dd hh:mm:ss')"/>

                        </td>
                    </tr>
                    <tr>
                        <th><i class="require-red">*</i>{{trans('lottery.index.list_title.djj_date')}}：</th>
                        <td><input style="width:170px;padding:7px 10px;border:1px solid #ccc;"
                                   value='{{$data[0]->deadline}}' class="deadline" name="deadline"
                                   onclick="SelectDate(this,'yyyy-MM-dd hh:mm:ss')"/>
                        </td>
                    </tr>
                    <tr>
                        <th></th>
                        <td>
                            <input class="btn btn-primary btn6 mr10 ws_fb btn-info" value="{{trans('public.but.release')}}" type="submit">
                            <input class="btn btn6" onclick="history.go(-1)" value="{{trans('public.but.return')}}" type="button">
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="result-wrap result-two">
            <div class="kj_onea" id="kj_onea">
                <input class="mid" value="0" type="hidden"/>
                <div class="kj_two1">{{trans('lottery.edit.grade')}}{{--中奖等级--}}：
                    <select name="level" id="level">
                        <option value="1">{{trans('lottery.edit.grade_1')}}{{--一等奖--}}</option>
                        <option value="2">{{trans('lottery.edit.grade_2')}}{{--二等奖--}}</option>
                    <?php if($data[0]->types == 1){?>
                        <option value="3">{{trans('lottery.edit.grade_3')}}{{--三等奖--}}</option>
                    <?php }?>
                    </select>
                </div>
                <div class="kj_two2">{{trans('lottery.edit.mzjj')}}{{--每注奖金--}}：
                    <input type="text" name="cash" maxlength="8"/>
                </div>
                <?php if($data[0]->types == 1){ ?>
                <div class="kj_two3">{{trans('lottery.edit.zj_money')}}{{--每注追加奖金--}}：
                    <input type="text" name="cash_add" maxlength="7"/>
                </div>
                <?php }?>
            </div>
            <div class="kj_ones">
                <dt>
                    <input class="btn btn-info btn-primary btn6 mr10 mon_saves " value="添加" />
                <div style="clear: both;"></div>
                </dt>
                <table class="insert-tab kj_monlists" width="100%" style="margin-top: 30px;">
                    <!--<table width="600" style="margin-top: 50px; text-align: center;" class="kj_monlists">-->
                    <tr style="background-color: #44AAC8; color: #fff;">
                        <td>ID</td>
                        <td>{{trans('lottery.edit.Award_level')}}</td>
                        <td>{{trans('lottery.edit.mzjj')}}</td>
                        <td>{{trans('lottery.edit.zj_money')}}</td>
                        <td>{{trans('lottery.edit.caozuo')}}</td>
                    </tr>

                    <?php if(!empty($data_lists)): ?>
                    <?php foreach($data_lists as $key => $value): ?>
                    <tr>
                        <td>{{ $value->winning_id }}</td>
                        <td><?php if ($value->level == 1) echo '一等奖';if ($value->level == 2) echo '二等奖'; if ($value->level == 3) echo '三等奖';?></td>
                        <td>{{ $value->cash }}元</td>
                        <td>{{ $value->cash_add }}元</td>
                        <td><span style="margin-right: 10px;" onclick="edit({{ $value->winning_id }})">{{trans('public.but.edit')}} </span><span
                                    onclick="mondel({{ $value->winning_id }})">{{trans('public.but.del')}}</span></td>
                    </tr>
                <?php endforeach; ?>
                <?php endif; ?>
                <!--<tr>
        				<td class="tc"><input name="id[]" value="" type="checkbox"></td>
        				<td>1</td>
        				<td>一等奖</td>
        				<td>100000元</td>
        				<td>50000元</td>
        				<td><span style="margin-right: 10px;;">编辑 </span><span>删除</span></td>
        			</tr>-->
                </table>
            </div>

        </div>
@stop
<!-- <div style="position: absolute; left: 0; right: 0; top: 0; bottom: 0; background: #000; opacity: 0.5; display: none;" class="w_adshow">
    <div style="width: 40%; height: 200px; margin: 0 auto; background: #fff; margin-top: 200px; border-radius: 8px;text-align: center; line-height: 200px;font-size: 20px;">请稍后...</div>
</div> -->
@section('js')
<script src="/admin/js/adddate.js"></script>
<script>
    function edit(obj) {
        $.ajax({
            type: "POST",
            url: "/index.php/mon_edit",
            data: {
                id: obj,
            },
            datatype: "json",//"xml", "html", "script", "json", "jsonp", "text".
            success: function (data) {
                if (typeof data == "string") {
                    var data = eval('(' + data + ')');
                }
                var data = data.data[0];
                $('.mid').val(data.winning_id);
                $("input[name='cash']").val(data.cash);
                $("input[name='cash_add']").val(data.cash_add);

                //$("#level option").removeAttr("selected");
                $("#level option[value=" + data.level + "]").attr('selected', 'selected').siblings().removeAttr("selected");
                //$("#level option[value="+data.level+"]").attr('selected','selected');
                $('.mon_saves').text('修改');
            },
            //调用出错执行的函数
            error: function () {
                //请求出错处理
            }
        });
    }
    $(document).on('click', '.kj_dt dt', function () {
        $(".kj_dt dt").removeClass("active");
        $(this).addClass("active");
        var data_id = $(this).attr('data-id');
        if (data_id == 1) {
            $('.result-one').show();
            $('.result-two').hide();
        } else {
            $('.result-one').hide();
            $('.result-two').show();
        }
    });
    /*$(document).on('click','.kj_two2 input',function(){
     $("input[name='cash']").css("color","#000");
     var cash = $("input[name='cash']").val();
     if(cash=='最多输入8位数'){
     $("input[name='cash']").val('');
     }
     })
     $(document).on('click','.kj_two3 input',function(){
     $("input[name='cash_add']").css("color","#000");
     var cash = $("input[name='cash_add']").val();
     if(cash=='最多输入7位数'){
     $("input[name='cash_add']").val('');
     }
     })*/
    $(document).on('click', '.mon_saves', function () {
        var id = $('.id').val();
        var cash_bj=$('.kj_two3').length;
        var cash = $("input[name='cash']").val();
        var level = $("#level  option:selected").val();
        var mid = $('.mid').val();
        if(cash_bj!=0){
           
            var cash_add = $("input[name='cash_add']").val();
            
            if (cash_add == '' || cash_add == null || cash_add == undefined) {
                alert('奖金数不能为空');
                return;
            }

             if (numbers_check(cash_add) == false) {
                alert('请输入正确钱数');
                return;
            }
        }else{
            var cash_add = 0;
        }

         if (cash == '' || cash == null || cash == undefined) {
                alert('奖金数不能为空');
                return;
            }

        


        if (numbers_check(cash) == false) {
            alert('请输入正确钱数');
            return;
        }
//	if(cash_add.length>7||cash<cash_add){
//		//$("input[name='cash_add']").val('最多输入7位数');
//		$("input[name='cash_add']").css("color","red");
//		return;
//	}

        $.ajax({
            type: "POST",
            url: "/index.php/mon_saves",
            data: {
                id: id, cash: cash, cash_add: cash_add, level: level, mid: mid,
            },
            datatype: "json",//"xml", "html", "script", "json", "jsonp", "text".
            /* beforeSend:function(){
             $('.w_adshow').show();
             },*/
            success: function (data) {
                if (typeof data == "string") {
                    var data = eval('(' + data + ')');
                }
                if (data.data == 2) {
                    /*$('.w_adshow').hide();*/
                    alert('重复添加！')
                } else {
                    lists(id);
                }
//      	if(data.status==1){
//      		window.location.href="/index.php/ad_kjlist";
//     		}      
            },
            //调用出错执行的函数
            error: function () {
                //请求出错处理
            }
        });
    });

    $(".ws_fb").click(function () {
        var types = $("#kj_select ").val();
        var name = jQuery("#kj_select  option:selected").text();
        var id = $('.id').val();
        var num = $("input[name='num']").val();
        var notice_date = $('.notice_date').val();
        var deadline = $('.deadline').val();

        if (num == '' || num == null || num == undefined) {
            alert('期数不能为空!');
            return;
        }

        if (notice_date == '' || notice_date == null || notice_date == undefined) {
            alert('开奖时间不能为空!');
            return;
        }

        if (deadline == '' || deadline == null || deadline == undefined) {
            alert('兑奖时间不能为空!');
            return;
        }

        var no_date = Date.parse(new Date(notice_date));
        var de_date = Date.parse(new Date(deadline));

        if (no_date > deadline) {
            alert('开奖时间不能大于兑奖时间!');
            return;
        }

        if (numbers_check(num) == false) {
            alert('请输入正确的期数');
            return;
        }


        if (types == 1) {
            var d_qian = [];
            var q_num = [];
            var h_num = [];
            var d_qian = $('.daletou').children('.dlt_qian');
            for (var i = 0; i < d_qian.length; i++) {
                if (numbers_check(d_qian[i].value) == false) {
                    alert('请输入正确数字');
                    return;
                } else {
                    if (d_qian[i].value > 35 || d_qian[i].value < 0) {
                        alert('请输入正确的号码!');
                        return;
                    }

                    if (d_qian[i].value == '' || d_qian[i].value == null || d_qian[i].value == undefined) {
                        alert('号码不能为空！');
                        return;
                    }


                    q_num[i] = d_qian[i].value;

                    var nary = q_num.sort();
                    for (var k = 0; k < nary.length - 1; k++) {
                        if (nary[k] == nary[k + 1]) {
                            alert('不能出现重复号码！');
                            return;
                        }
                    }
                }
            }

            for (var x = 0; x < q_num.length; x++) {
                if (q_num[x] < 10 && q_num[x].substr(0, 1) > 0) {
                    q_num[x] = '0' + q_num[x];
                }
            }


            //console.log(q_num);
            var d_hou = $('.daletou').children('.dlt_hou');
            for (var j = 0; j < d_hou.length; j++) {
                if (numbers_check(d_hou[j].value) == false) {
                    alert('请输入正确数字');
                    return;
                } else {
                    if (d_hou[j].value == '' || d_hou[j].value == null || d_hou[j].value == undefined) {
                        alert('号码不能为空！');
                        return;
                    }

                    if (d_hou[j].value > 12 || d_hou[j].value < 0) {
                        alert('请输入正确的号码!');
                        return;
                    }

                    h_num[j] = d_hou[j].value;

                    var na = h_num.sort();
                    for (var n = 0; n < na.length - 1; n++) {
                        if (na[n] == na[n + 1]) {
                            alert('不能出现重复号码！');
                            return;
                        }
                    }
                }
            }

            for (var h = 0; h < h_num.length; h++) {
                if (h_num[h] < 10 && h_num[h].substr(0, 1) > 0) {
                    h_num[h] = '0' + h_num[h];
                }
            }

            var q_num_font = q_num.join(',');
            var h_num_font = h_num.join(',');
            var numbers = q_num_font + '|' + h_num_font;
            console.log(numbers);
        } else if (types == 2) {
            var qxc_num = [];
            var qxc = $('.qxc').children('.qxc_num');
            for (var i = 0; i < qxc.length; i++) {
                if (numbers_check(qxc[i].value) == false) {
                    alert('请输入正确数字');
                    return;
                } else {

                    if (qxc[i].value == '' || qxc[i].value == null || qxc[i].value == undefined) {
                        alert('号码不能为空！');
                        return;
                    }

                    qxc_num[i] = qxc[i].value;
                }

            }

            var numbers = qxc_num.join(',');
        } else if (types == 3) {
            var p3_num = [];
            var p3 = $('.p3').children('.p3_num');
            for (var i = 0; i < p3.length; i++) {
                if (numbers_check(p3[i].value) == false) {
                    alert('请输入正确数字');
                    return;
                } else {
                    if (p3[i].value == '' || p3[i].value == null || p3[i].value == undefined) {
                        alert('号码不能为空！');
                        return;
                    }
                    p3_num[i] = p3[i].value;
                }

            }
            var numbers = p3_num.join(',');
        } else if (types == 4) {
            var p5_num = [];
            var p5 = $('.p5').children('.p5_num');
            for (var i = 0; i < p5.length; i++) {
                if (numbers_check(p5[i].value) == false) {
                    alert('请输入正确数字');
                    return;
                } else {
                    if (p5[i].value == '' || p5[i].value == null || p5[i].value == undefined) {
                        alert('号码不能为空！');
                        return;
                    }
                    p5_num[i] = p5[i].value;
                }
            }
            var numbers = p5_num.join(',');
        }


        $.ajax({
            type: "POST",
            url: "/index.php/ad_kjsave",
            data: {
                id: id,
                name: name,
                num: num,
                numbers: numbers,
                types: types,
                notice_date: notice_date,
                deadline: deadline
            },
            datatype: "json",//"xml", "html", "script", "json", "jsonp", "text".
            /* beforeSend:function(){
             $('.w_adshow').show();
             },*/
            success: function (data) {

                if (typeof data == "string") {
                    var data = eval('(' + data + ')');
                }
//      	$('.result-one').hide();
//			$('.result-two').show();
//			$('.w_adshow').hide();
                //console.log(data);


                if (data == true) {
                    window.location.href = "/index.php/ad_kjlist";
                } else if (data == 'cz') {
                    alert('已存在相同期数的结果，请重新发送');
                } else {
                    for (var i in data) {
                       /* $("input[name='num']").val(data[i][0]);*/
                        $("input[name="+i+"]").parent("td").children("span").remove();
                        $("input[name="+i+"]").parent("td").append('<span style="color:red">'+data[i][0]+'</span>');
                       // alert(i);
                    }
                }
            },
            //调用出错执行的函数
            error: function () {
                //请求出错处理
            }
        });
    });

    function mondel(obj) {
        $.ajax({
            type: "GET",
            url: "/index.php/mon_del",
            data: {
                id: obj,
            },
            datatype: "json",//"xml", "html", "script", "json", "jsonp", "text".
            /*beforeSend:function(){
             $('.w_adshow').show();
             },*/
            success: function (data) {
                if (typeof data == "string") {
                    var data = eval('(' + data + ')');
                }
                var id = $('.id').val();
                lists(id)
            },
            //调用出错执行的函数
            error: function () {
                //请求出错处理
            }
        });
    }


    function lists(obj) {
        $.ajax({
            type: "POST",
            url: "/index.php/mon_lists",
            data: {
                id: obj,
            },
            datatype: "json",//"xml", "html", "script", "json", "jsonp", "text".
            /* beforeSend:function(){
             $('.w_adshow').show();
             },*/
            success: function (data) {
                if (typeof data == "string") {
                    var data = eval('(' + data + ')');
                }
                /*$('.w_adshow').hide();*/
                var data = data.data;
                var html = [];
                html = '<tr style="background-color: #3CA3C1; color:#fff;"><td></td><td>ID</td><td>奖级</td><td>每注奖金</td><td>每注追加奖金</td><td>操作</td></tr>';
                for (var i = 0; i <= data.length - 1; i++) {
                    if (data[i].level == 1) var jiang = '一等奖';
                    if (data[i].level == 2) var jiang = '二等奖';
                    if (data[i].level == 3) var jiang = '三等奖';
                    if (data[i].level == 4) var jiang = '四等奖';
                    if (data[i].level == 5) var jiang = '五等奖';
                    if (data[i].level == 6) var jiang = '六等奖';
                    html += '<tr><td class="tc"><input name="id[]" value="" type="checkbox"></td><td>' + data[i].winning_id + '</td><td>' + jiang + '</td><td>' + data[i].cash + '元</td><td>' + data[i].cash_add + '元</td><td><span style="margin-right: 10px;" onclick="edit(' + data[i].winning_id + ')">编辑 </span><span onclick="mondel(' + data[i].winning_id + ')">删除</span></td></tr>'
                }
                $('.kj_monlists').html(html);

                $('.mid').val(0);
                $("input[name='cash']").val('');
                $("input[name='cash_add']").val('');
                $("#level option[value=1]").attr('selected', 'selected');
                $('.mon_saves').text('添加');
//      	if(data.status==1){
//      		window.location.href="/index.php/ad_kjlist";
//     		}      
            },
            //调用出错执行的函数
            error: function () {
                //请求出错处理
            }
        });
    }

    $('#kj_select').change(function () {
        var cp_type = $('#kj_select').val();
        if (cp_type == 1) {
            var h = "<div class='daletou'>前区：<input class='dlt_qian' maxlength='2'><input class='dlt_qian' maxlength='2'><input class='dlt_qian' maxlength='2'><input class='dlt_qian' maxlength='2'><input class='dlt_qian' maxlength='2'> &nbsp;&nbsp;&nbsp;后区：<input class='dlt_hou' maxlength='2'><input class='dlt_hou' maxlength='2'></div>";
            $('.kj_num').html(h);
        } else if (cp_type == 2) {
            $('.kj_num').html("<div class='qxc'><input class='qxc_num'  maxlength='1'><input class='qxc_num' maxlength='1'><input class='qxc_num' maxlength='1'><input class='qxc_num' maxlength='1'><input class='qxc_num' maxlength='1'><input class='qxc_num' maxlength='1'><input class='qxc_num' maxlength='1'></div>");
        } else if (cp_type == 3) {
            $('.kj_num').html("<div class='p3'><input class='p3_num'  maxlength='1'><input class='p3_num' maxlength='1'><input class='p3_num' maxlength='1'></div>");
        } else if (cp_type == 4) {
            $('.kj_num').html("<div class='p5'><input class='p5_num'  maxlength='1'><input class='p5_num' maxlength='1'><input class='p5_num' maxlength='1'><input class='p5_num' maxlength='1'><input class='p5_num' maxlength='1'></div>");
        }
    })

    //数字验证匹配
    function numbers_check(obj) {
        reg = /^[0-9]+.?[0-9]*$/;
        ;
        if (!reg.test(obj)) {
            return false;
        } else {
            return true;
        }
    }

</script>
@stop