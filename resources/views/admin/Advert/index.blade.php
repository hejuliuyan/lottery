@extends('admin.public.base')
@section('title1')
    {{--产品管理--}}{{trans('advert.title1')}}
@stop
@section('title2')
    {{--广告图片--}}{{trans('advert.title2')}}
@stop
@section('content')

    <div class="result-wrap">

        <div class="result-title">

            <div class="result-list" style="text-align: right;">
                <!--  <input type="text" name="num" id="add_num" /> -->
                <!-- <input type="submit" name="submit" value="xinzeng"> -->
                <form action="/index.php/advert_picadd" method="post"
                      enctype="multipart/form-data">
                    <span style="color: red;">只可上传png、jpg、gif格式图片</span>
                    <!--  <a href="#" id="advert_pic"><button type="button" class="btn btn-info">新增</button></a> -->
                    <input type="file" name="photo" class="file"/> <input type="submit"
                                                                          value="{{trans('public.but.adds')}}"
                                                                          class="btn btn-info sub"/>
                </form>
            </div>
        </div>
        <form name="myform" id="myform" method="post">
            <div class="result-content">
                <table class="result-tab tablesorter" id="myTable" width="100%">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>{{trans('advert.create_time')}}</th>
                        {{--<th>状态</th>--}}
                        <th>{{trans('advert.preview')}}</th>
                        <th>{{trans('advert.operating')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(!empty($lists)): ?>
                    <?php foreach($lists as $key => $value): ?>
                    <tr>
                        <!-- <input name="id" value="" type="hidden"> -->
                        <td>{{ $value->id }}</td>
                        <td>{{ $value->create_time }}</td>

                        <td><img src="../admin/uploads/images/{{ $value->p_name }}" width="50px" height="30px"></td>


                        <td><a class="updateOrd" href="javascript:void(0)"
                               data-id="{{ $value->id }}"
                               data-state="{{$value->state}}"><?php if($value->state == 1): ?>
                                <button type="button" class="btn btn-info">{{trans('public.but.disable')}}</button>
                                <?php else: ?>
                                <button type="button"
                                        class="btn btn-info">{{trans('public.but.enable')}}</button><?php endif; ?></a>
                            <a
                                    class="batchDel" data-id="{{ $value->id }}"
                                    href="javascript:void(0)">
                                <button type="button" class="btn btn-info">{{trans('public.but.del')}}</button>
                            </a></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
                <!--<div class="list-page"> 2 条 1/1 页</div>-->
            </div>
        </form>
    </div>
@stop
@section('js')
    <script>
        $(".updateOrd").click(function () {
            var id = $(this).attr('data-id');
            var state = $(this).attr('data-state');
            $.get("/index.php/advert_pic_save", {id: id, state: state},
                    function (data) {
                        window.location.reload();//刷新当前页面
                    });
            return false;
        });
        $(document).on('click', '#search', function () {
            if ($("#where").val() == '') {
                if ($("#phone").val() == '') {
                    alert("{{trans('advert.js.null')}}");
                    return false;
                }
            }
        })
        $(document).on('click', '.sub', function () {
            /*alert($(".file").val());
             console.log($(".file").val());*/
            if ($(".file").val() == '') {
                alert("请选择图片再上传");
                return false;
            }

        })

        $(document).on('click', '#add_shop', function () {
            var num = $("#add_num").val();
            $.ajax({
                type: "GET",
                url: "/index.php/ad_shop_add",
                data: {
                    num: num,
                },
                datatype: "json",
                success: function (data) {
                    /* if(typeof data == "string") {var data = eval('('+data+')');}
                     if(data.status==1){
                     window.location.href="/index.php/ad_kjlist";
                     } */
                    if (data == '1') {
                        //alert('添加成功');
                        window.location.href = "/index.php/ad_shop";
                    } else if (data == '2') {
                        alert("{{trans('advert.js.num')}}");
                    } else {
                        alert("{{trans('advert.js.max')}}");
                    }

                },
                error: function () {
                    //请求出错处理
                }
            });
        })
        $(document).ready(function () {
            //第一列不进行排序(索引从0开始)
            //$("#myTable").tablesorter( {sortList: [[0,0], [1,0]]} );
            $("#myTable").tablesorter();
        });

        $("#kj_select").change(function () {
            var types = $("#kj_select ").val();
            if (types == '0') {
                window.location.href = "/index.php/ad_kjlist";
            } else {
                window.location.href = "/index.php/ad_kjsearch?types=" + types + "";
            }


        });


        $(document).on('click', '.batchDel', function () {
            var delid = $(this).attr('data-id');
            $.ajax({
                type: "GET",
                url: "/index.php/advert_picdel",
                data: {
                    id: delid,
                },
                datatype: "json",//"xml", "html", "script", "json", "jsonp", "text".
                /* beforeSend:function(){
                 $('.w_adshow').show();
                 },*/
                success: function (data) {
                    if (typeof data == "string") {
                        var data = eval('(' + data + ')');
                    }
                    if (data.status == 1) {
                        // window.location.href = "/index.php/ad_shop";
                        //alert('删除成功');
                        window.location.reload();//刷新当前页面

                    }
                },
                error: function () {
                    //请求出错处理
                }
            });
        })

    </script>
@stop