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
    系统管理
@stop
@section('title2')
    用户添加
@stop
@section('content')
    <form id="formid" name="myform" method='post'>
        <div class="result-wrap result-one">
            <div class="result-content">
                <table class="insert-tab" width="100%">

                    <tbody>
                    <tr>
                        <th width="120"><i class="require-red">*</i>用户名：</th>
                        <td><input type="text" name="name" value=""
                                   required/></td>
                    </tr>

                    <tr>
                        <th><i class="require-red">*</i>邮箱：</th>
                        <td><input type="text" name="email"
                                   value=""/></td>
                    </tr>
                    <tr>
                        <th><i class="require-red">*</i>密码：</th>
                        <td><input type="text" name="password"
                                   value=""/></td>
                    </tr>


                    <tr>
                        <th><i class="require-red">*</i>是否启用：</th>
                        <td><input name="state" type="radio" value="1"
                                   checked/>启用
                            <input name="state" type="radio" value="0"
                            />禁用
                        </td>
                    </tr>
                    <tr>
                        <th></th>
                        <td><input class="btn btn-primary btn6 mr10 ws_fb btn-info" value="确认"
                                   type="submit" id="submit"> <input class="btn btn6"
                                                                     onclick="history.go(-1)" value="返回"
                                                                     type="button"></td>
                    </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </form>
@stop
@section('js')
    <script>
        $("#submit").click(function () {

            $.post("/index.php/ad_user_doadd", $("#formid").serialize(), function (data) {
                debugger;
                //console.info(data);
                if (data == '1') {
                    window.location.href = "/index.php/ad_user";
                } else if (data == '0') {
                    alert('添加失败！');
                    //window.location.href="/index.php/ad_shop";
                } else {
                    for (var i in data) {
                        /* $("input[name='num']").val(data[i][0]);*/
                        $("input[name=" + i + "]").parent("td").children("span").remove();
                        $("input[name=" + i + "]").parent("td").append('<span style="color:red">' + data[i][0] + '</span>');
                        // alert(i);
                    }
                }
            });
            return false;
        });

    </script>
@stop