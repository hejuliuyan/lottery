@extends('admin.public.base')
@section('title1')
    {{--开奖列表--}}{{trans('lottery.add.title1')}}
@stop
@section('title2')
    {{trans('lottery.add.title2')}}
@stop
@section('content')
    <div class="result-wrap">
        <div class="result-content">
            <table class="insert-tab" width="100%">
                <input type="hidden" name="id" class="id" value="0"/>
                <tbody>
                <tr>
                    <th width="120"><i class="require-red">*</i>{{trans('lottery.add.fl')}}：</th>
                    <td>
                        <select name="name" id="kj_select">
                            <option value="">{{trans('lottery.index.option.0')}}</option>
                            <option value="1">{{trans('lottery.index.option.1')}}</option>
                            <option value="2">{{trans('lottery.index.option.2')}}</option>
                            <option value="3">{{trans('lottery.index.option.3')}}</option>
                            <option value="4">{{trans('lottery.index.option.4')}}</option>
                        </select>

                    </td>
                </tr>

                <tr>
                    <th><i class="require-red">*</i>{{trans('lottery.index.list_title.qishu')}}：</th>
                    <td>
                        <input class="common-text required" id="title" name="num" size="50" value="" type="text">
                    </td>
                </tr>
                <tr>
                    <th><i class="require-red">*</i>{{trans('lottery.add.kjhm')}}：</th>
                    <td class='kj_num'>
                        <input class="common-text required" id="title" name="numbers" size="50" value="" type="text">
                    </td>
                </tr>
                <tr>
                    <th><i class="require-red">*</i>{{trans('lottery.index.list_title.kj_date')}}：</th>
                    <td><input style="width:170px;padding:7px 10px;border:1px solid #ccc;margin-right:10px;" value=''
                               class="notice_date" onclick="SelectDate(this,'yyyy-MM-dd hh:mm:ss')"/>

                    </td>
                </tr>
                <tr>
                    <th><i class="require-red">*</i>{{trans('lottery.index.list_title.djj_date')}}：</th>
                    <td><input style="width:170px;padding:7px 10px;border:1px solid #ccc;" value='' class="deadline"
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

@stop
<!-- <div style="position: absolute; left: 0; right: 0; top: 0; bottom: 0; background: #000; opacity: 0.5; display: none;" class="w_adshow">
    <div style="width: 40%; height: 200px; margin: 0 auto; background: #fff; margin-top: 200px; border-radius: 8px;text-align: center; line-height: 200px;font-size: 20px;">请稍后...</div>
</div> -->
@section('js')
<script src="/admin/js/adddate.js"></script>
    <script>

        $(".ws_fb").click(function () {
            var types = $("#kj_select ").val();
            var name = jQuery("#kj_select  option:selected").text();
            var id = $('.id').val();
            var num = $("input[name='num']").val();
            var notice_date = $('.notice_date').val();
            var deadline = $('.deadline').val();

            if (types == '' || types == null || types == undefined) {
                alert('请选择彩种');
                return;
            }

            if (num == '' || num == null || num == undefined) {
                alert('期数不能为空!');
                return;
            }

            if (numbers_check(num) == false) {
                alert('请输入正确的期数');
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

            var no_date = parseInt(Date.parse(new Date(notice_date))) / 1000;
            var de_date = parseInt(Date.parse(new Date(deadline))) / 1000;

            if (no_date > de_date) {
                alert('开奖时间不能大于兑奖时间!');
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
                url: "/index.php/ad_kjnews",
                data: {
                    name: name, num: num, numbers: numbers, types: types, notice_date: notice_date, deadline: deadline,
                },
                datatype: "json",//"xml", "html", "script", "json", "jsonp", "text".
                /*            beforeSend:function(){
                 $('.w_adshow').show();
                 },*/
                success: function (data) {
                    if (typeof data == "string") {
                        var data = eval('(' + data + ')');
                    }
                    if (data == true) {
                        window.location.href = "/index.php/ad_kjlist";
                    } else if (data == 'cz') {
                        alert('已存在相同期数的结果，请重新发送');
                    }
                },
                error: function () {
                    //请求出错处理
                }
            });
        });

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