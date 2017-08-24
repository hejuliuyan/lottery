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

        .check_list {
            /*border: 1px solid #000000;*/
            margin-left: 50px;

        }

        .check_list > span {
            padding: 2px 5px;
        }

        .bd_w {
            border-bottom: 1px solid #CCCCCC;
        }
    </style>
@stop
@section('title1')
    角色管理
@stop
@section('title2')
    权限分配
@stop
@section('content')

    <form id="formid" name="myform" method='post'>
        <div class="result-wrap result-one">
            <div class="result-content">
                <table class="insert-tab" width="100%">

                    <tbody>

                    <tr>

                        <td>
                            <?php if(!empty($data)): ?>
                            <?php foreach($data as $key => $value): ?>
                            <span style="margin-right: 20px;">
                                <input type="checkbox" name="per_list[]" class="f_chx" value="{{$value->id}}"
                                       @if(isset($value->state)) checked @endif />

                                {{$value->display_name}}
									</span>
                            {{--<div class="bd_w"></div>--}}
                            <div class="check_list">
                                @if(!empty($value->lists))
                                    @foreach($value->lists as $v)
                                        <span>
                                            <label>{{$v->display_name}}</label>
                                            <input name="per_list[]" value="{{$v->id}}" type="checkbox"
                                                   @if(isset($v->state)) checked @endif/>
                                                </span>
                                    @endforeach
                                @endif
                            </div>
                            <div class="bd_w"></div>
                            <?php endforeach; ?>
                            <?php endif; ?>
                            {{--权限<input type="checkbox"
                               name="car" value="" />--}}
                        </td>
                    </tr>


                    <tr>

                        <td><input type="hidden" name="id" value="{{$id}}"/> <input
                                    class="btn btn-primary btn6 mr10 ws_fb" value="确认"
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
            $.post("/index.php/ad_role_add_per", $("#formid").serialize(), function (data) {
                //console.info(data);
                if (data == '1') {
                    window.location.href = "/index.php/ad_role";
                }
            });
            return false;
        });
        $(".f_chx").click(function () {
            var state = $(this).attr("checked");
            if (state == 'checked') {
                $(this).parent("span").next(".check_list").children("span").children("input").attr("checked", "checked");
            } else {
                $(this).parent("span").next(".check_list").children("span").children("input").removeAttr("checked");
            }
        })
    </script>
@stop