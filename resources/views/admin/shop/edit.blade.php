@extends('admin.public.base')
@section('style')
    <style>
        .result-content {
            width: 50%;
            float: left;
        }

        .result-wrap, .result-one {
            overflow: hidden;
        }

        .licence_pic {
            width: 40%;
            float: left;
            height: 60px;
            text-align: center;
        }

        .licence_pic > div > img {
            /* margin-left:100px;*/

        }

        .licence_pic > div > p {
            text-align: center;
        }
    </style>
@stop
@section('title1')
    {{--店铺管理--}}{{trans('shop.title1')}}
@stop
@section('title2')
    {{--信息修改--}}{{trans('shop.edit.title2')}}
@stop
@section('content')
    <form id="formid" name="myform" method='post'
          action='/index.php/ad_spsaves'>
        <div class="result-wrap result-one">
            <div class="result-content">
                <table class="insert-tab" width="100%">
                    <input type="hidden" name="id" class="id"
                           value="{{ $data[0]->id }}"/>
                    <tbody>
                    <tr>
                        <th width="120"><i class="require-red">*</i>{{--店名--}}{{trans('shop.edit.title2')}}：</th>
                        <td><input type="text" name="shop_name"
                                   value="{{ $data[0]->shop_name }}" required/></td>
                    </tr>

                    <tr>
                        <th><i class="require-red">*</i>{{--身份证号--}}{{trans('shop.edit.idcard')}}：</th>
                        <td><input type="text" name="idcard_num"
                                   value="{{ $data[0]->idcard_num }}"/></td>
                    </tr>
                    <tr>
                        <th><i class="require-red">*</i>{{--真实姓名--}}{{trans('shop.edit.real_name')}}：</th>
                        <td class='kj_num'><input type="text" name="keeper_name"
                                                  value="{{ $data[0]->keeper_name }}"/></td>
                    </tr>
                    <tr>
                        <th><i class="require-red">*</i>{{--手机号码--}}{{trans('shop.edit.phone')}}：</th>
                        <td><input type="text" name="keeper_mobile"
                                   value="{{ $data[0]->keeper_mobile }}"/></td>
                    </tr>
                    <tr>
                        <th><i class="require-red">*</i>{{--登录名--}}{{trans('shop.edit.log_name')}}：</th>
                        <td><input type="text" name="shop_account"
                                   value="{{ $data[0]->shop_account }}"/></td>
                    </tr>
                    <tr>
                        <th><i class="require-red"></i>{{--出票次数--}}{{trans('shop.cp_num')}}：</th>
                        <td>{{ $data[0]->shop_cpnum }}<input type="hidden"
                                                             name="shop_cpnum" value="{{ $data[0]->shop_cpnum }}"/>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require-red">*</i>{{--详细地址--}}{{trans('shop.address')}}：</th>
                        <td><input type="text" name="address"
                                   value="{{ $data[0]->address }}"/></td>
                    </tr>

                    <tr>
                        <th><i class="require-red">*</i>{{--星级--}}{{trans('shop.edit.star')}}：</th>
                        <td><select name="shop_level" id="shop_level">
                                <option value="">{{trans('shop.edit.star_list.0')}}</option>
                                <option value="1" @if($data[0]->shop_level=='1')selected
                                        @endif>{{--一星--}}{{trans('shop.edit.star_list.1')}}
                                </option>
                                <option value="2" @if($data[0]->shop_level=='2')selected
                                        @endif>{{--二星--}}{{trans('shop.edit.star_list.2')}}
                                </option>
                                <option value="3" @if($data[0]->shop_level=='3')selected
                                        @endif>{{--三星--}}{{trans('shop.edit.star_list.3')}}
                                </option>
                                <option value="4" @if($data[0]->shop_level=='4')selected
                                        @endif>{{--四星--}}{{trans('shop.edit.star_list.4')}}
                                </option>
                                <option value="5" @if($data[0]->shop_level=='5')selected
                                        @endif>{{--五星--}}{{trans('shop.edit.star_list.5')}}
                                </option>
                            </select></td>
                    </tr>
                    <tr>
                        <th><i class="require-red">*</i>{{--创建时间--}}{{trans('shop.c_time')}}：</th>
                        <td>{{ date('Y-m-d H:i:s',$data[0]->created_at) }}</td>
                    </tr>
                    @if(!empty($data[0]->updated_at))
                        <tr>
                            <th><i class="require-red">*</i>{{--修改时间--}}{{trans('shop.edit.u_time')}}：</th>
                            <td>
                                {{ date('Y-m-d H:i:s',$data[0]->updated_at) }}

                            </td>
                        </tr>
                    @endif
                    <tr>
                        <th><i class="require-red">*</i>{{--是否认证--}}{{trans('shop.edit.is_Authenticate')}}：</th>
                        <td><input name="verified" type="radio" value="Y"
                                   <?php if($data[0]->verified == 'Y'): ?> checked
                            <?php endif; ?> />{{--已认证--}}{{trans('shop.edit.verified')}} <input name="verified"
                                                                                                type="radio"
                                                                                                value="N"
                                                                                                <?php if($data[0]->verified == 'N'): ?> checked
                            <?php endif; ?> />{{--未认证--}}{{trans('shop.edit.not_certified')}}
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require-red">*</i>{{--是否交保--}}{{trans('shop.edit.is_ensure')}}：</th>
                        <td><input name="margin_paid" type="radio" value="Y"
                                   <?php if($data[0]->margin_paid == 'Y'): ?> checked
                            <?php endif; ?> />{{--已交--}}{{trans('shop.edit.ok_ensure')}} <input name="margin_paid"
                                                                                                type="radio"
                                                                                                value="N"
                                                                                                <?php if($data[0]->margin_paid == 'N'): ?> checked
                            <?php endif; ?> />{{--未交--}}{{trans('shop.edit.no_ensure')}}
                        </td>
                    </tr>

                    <tr>
                        <th><i class="require-red">*</i>{{--是否启用--}}{{trans('shop.edit.is_enable')}}：</th>
                        <td><input name="active" type="radio" value="1"
                                   <?php if($data[0]->active == 1): ?> checked <?php endif; ?> />{{--启用--}}{{trans('shop.edit.enable')}}
                            <input name="active" type="radio" value="0"
                                   <?php if($data[0]->active == 0): ?> checked <?php endif; ?> />{{--禁用--}}{{trans('shop.edit.no_enable')}}
                        </td>
                    </tr>
                    <tr>
                        <th></th>
                        <td><input class="btn btn-primary btn6 mr10 ws_fb btn-info"
                                   value="{{--发布--}}{{trans('public.but.release')}}"
                                   type="submit" id="submit"> <input class="btn btn6"
                                                                     onclick="history.go(-1)"
                                                                     value="{{--返回--}}{{trans('public.but.return')}}"
                                                                     type="button"></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="licence_pic">
                <div>
                    <?php if(isset($data[0]->licence_pic) && (!empty($data[0]->licence_pic))): ?>
                    <input type="hidden" name="pic" id="pic" value="{{$data[0]->licence_pic}}">
                    <img src="/Uploads/photo/{{$data[0]->licence_pic}}" width="300px"
                         height="450px" / > {{--<img src="" />--}}
                    <input class="btn btn-primary btn6 mr10 btn-info" style="margin-top:10px;"
                           value="{{--删除--}}{{trans('public.but.del')}}"
                           type="submit" id="del_pic">

                    <p>{{--商家代销证--}}{{trans('shop.dxz')}}</p>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </form>
@stop
@section('js')
    <script>
        $("#del_pic").click(function () {
            var id = $(".id").val();
            var pic = $("#pic").val();
            $.post("/index.php/ad_shop_pic", {id: id, pic: pic},
                    function (data) {
                        if (data) {
                            $(".licence_pic").remove();
                        }
                    });
            return false;
        })
        $("#submit").click(function () {
            /*$("input[name='radio1']:checked").val();*/
            /*  var shop_name = $("input[name='shop_name']").val(); */
            if ($("input[name='shop_name']").val().length < 3) {
                alert('店名不能少于三个字');
                return false;
            }
            /* if(sname($("input[name='shop_name']").val())==false){
             alert('请输入正确名称');
             return false;
             }  */
            if ($("input[name='idcard_num']").val() == '') {
                alert('身份证号不能为空');
                return false;
            }
            if (card($("input[name='idcard_num']").val()) == false) {
                alert('身份证格式不正确');
                return false;
            }
            if ($("input[name='keeper_name']").val() == '') {
                alert('姓名不能为空');
                return false;
            }
            if (rname($("input[name='keeper_name']").val()) == false) {
                alert('姓名格式不正确');
                return false;
            }
            if ($("input[name='keeper_mobile']").val() == '') {
                alert('手机号不能为空');
                return false;
            }
            if (phone($("input[name='keeper_mobile']").val()) == false) {
                alert('请输入正确的手机号');
                return false;
            }
            if ($("input[name='shop_account']").val() == '') {
                alert('登录名不能为空');
                return false;
            }
            if ($("input[name='created_at']").val() == '') {
                alert('创建时间不能为空');
                return false;
            }
            if ($("input[name='address']").val() == '') {
                alert('详细地址不能为空');
                return false;
            }
            $("#submit").val("正在提交...");
            $.post("/index.php/ad_spsaves", $("#formid").serialize(), function (data) {
                console.info(data);

                if (data == '1') {
                    window.location.href = "/index.php/ad_shop";
                } else if (data == '0') {
                    alert('修改失败！');
                    $("#submit").val("发布");
                    //window.location.href="/index.php/ad_shop";
                } else if (data == '-1') {
                    alert('请输入正确地址');
                    $("#submit").val("发布");
                } else if (data == '3') {
                    alert('手机号已被注册');
                    $("#submit").val("发布");
                }
                else {
                    for (var i in data) {
                        /* $("input[name='num']").val(data[i][0]);*/
                        $("input[name=" + i + "]").parent("td").append('<span style="color:red">' + data[i][0] + '</span>');
                        // alert(i);
                    }
                }
            });
            return false;
        });
        //身份证匹配
        function card(obj) {

            reg = /^[1-9]\d{7}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}$|^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([0-9]|X)$/;
            if (!reg.test(obj)) {
                return false;
            } else {
                return true;
            }
        }


        //真实姓名匹配
        function rname(obj) {

            reg = /^[\u4e00-\u9fa5]{0,4}$/;
            if (!reg.test(obj)) {
                return false;
            } else {
                return true;
            }
        }
        //店铺名称匹配
        function sname(obj) {

            reg = /^[\u4e00-\u9fa5]{0,20}$/;
            if (!reg.test(obj)) {
                return false;
            } else {
                return true;
            }
        }
        //手机号匹配
        function phone(obj) {

            reg = /^(13[0-9]|14[5|7]|15[0|1|2|3|5|6|7|8|9]|18[0|1|2|3|5|6|7|8|9])\d{8}$/;
            if (!reg.test(obj)) {
                return false;
            } else {
                return true;
            }
        }
    </script>
@stop