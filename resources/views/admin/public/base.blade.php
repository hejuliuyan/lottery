<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>管理员中心</title>
    <link rel="stylesheet" type="text/css" href="/admin/css/common.css"/>
    <link rel="stylesheet" type="text/css" href="/admin/css/main.css"/>
    <script type="text/javascript" src="/admin/js/libs/modernizr.min.js"></script>
    <script src="/mui/js/jquery-latest.js"></script>
    <script src="/mui/js/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="/admin/js/jquery.tablesorter.js"></script>
    <script>
        $(document).on('click', '.openPopover', function () {
            $(this).siblings(".sub-menu").toggleClass("hidd");
        })


    </script>
    <style>
        .hidd {
            display: none;
        }

        #log_out {
            margin-right: 5px;
            float: right;
            margin-right: 100px;
            margin-top: 5px;
        }

        #log_out > a {
            color: #ffffff;
        }

        .topbar-wrap {
            background-color: #E7E6E2;
            overflow: hidden;
        }

        .top_left {
            padding-left: 5%;
            float: left;
        }

        .top_right {
            color: #231816;
            float: right;

        }

        .top_right > p {
            height: 25px;
            line-height: 25px;
            margin-right: 50px;
            text-align: right;
        }

        .top_left > span {
            color: black;
        }
    </style>
    @yield('style')

</head>
<body>
<div class="topbar-wrap white">
    <!--<div class="topbar-inner clearfix">-->
    {{--<div class="topbar-logo-wrap clearfix">
        <h1 class="topbar-logo none">
            <a href="index.html" class="navbar-brand">管理员中心</a>
        </h1>
    </div>--}}
    <div class="top_left"><img src="/admin/images/logo.jpg"><span>上海比冲信息科技有限责任公司</span></div>
    <div class="top_right"><p>{{trans('left.base.hello')}}{{ Session::get('username') }}</p>
        <p>{{date('Y-m-d H:i:s',time()+28800)}}</p></div>
</div>
<div class="container clearfix">
@include('admin.public.left')
<!--/sidebar-->
    {{--<a href="#" color="#white">@yield('title1')</a>--}}
    <div class="main-wrap">

        <div class="crumb-wrap">
            <div class="crumb-list">
                <i class="icon-font"></i><span>@yield('title1')</span><span
                        class="crumb-step">&gt;</span><span class="crumb-name">@yield('title2')</span>
                <select name="name" id="Language" style="margin-left:30%">
                    <option value="0">{{trans('public.Language')}}</option>
                    <option value="cn">{{trans('public.Chinese')}}</option>
                    <option value="en">{{trans('public.English')}}</option>
                </select>
                <a href="/help/index" style="margin-left: 50px;">帮助手册</a>
                <button id="log_out" class="btn btn-info"><a
                            href="/index.php/log_out">{{trans('left.base.out_log')}}</a></button>
            </div>
        </div>
        @yield('content')
    </div>

    <!--/main-->
</div>
@yield('js')
</body>
<script>
    $(document).on('click', '#log_out', function () {
        if (confirm("{{trans('left.base.is_out_log')}}") == false) {
            return false;
        }
        //$.get("/index.php/log_out");
        $.get("/index.php/log_out", function (data) {
            window.location.href = "/index.php/login";
        });
        return false;
    })
    var url = window.location.href;
    var urls = url.substring(25);
    $("a").each(function () {
        if ($(this).attr("href") == urls) {
            $(this).parent("li").parent(".sub-menu").removeClass("hidd");
        }
    });

    $("#Language").change(function () {
        var type = $("#Language ").val();
        console.log(type);
        if (type == '0') {

        } else {
            window.location.href = "/lang?type=" + type + "";
        }


    });

</script>
</html>