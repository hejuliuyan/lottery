<!doctype html>
<html lang="zh-cn"><head>
    <meta charset="utf-8">
    <title>管理系统</title>
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" type="text/css" href="<?php echo loadStatic('/lib/bootstrap/css/bootstrap.css'); ?>">
    <link rel="stylesheet" href="<?php echo loadStatic('/lib/font-awesome/css/font-awesome.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo loadStatic('/stylesheets/theme.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo loadStatic('/stylesheets/premium.css'); ?>">
    <style type="text/css">
        #line-chart {
            height:300px;
            width:800px;
            margin: 0px auto;
            margin-top: 1em;
        }
        .navbar-default .navbar-brand, .navbar-default .navbar-brand:hover { 
            color: #fff;
        }
        .none {
            display: none;
        }
        .notic {
            color: red;
            display: none;
        }
        ul.pagination {
            margin:10px 0;
        }
    </style>
    <script src="<?php echo loadStatic('/lib/jquery-1.11.1.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo loadStatic('/lib/jquery.cookie.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo loadStatic('/lib/blockui.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo loadStatic('/lib/common.js'); ?>" type="text/javascript"></script>

    <!-- 弹出窗口 -->
    <link rel="stylesheet" href="<?php echo loadStatic('/lib/artdialog/css/ui-dialog.css'); ?>">
    <script src="<?php echo loadStatic('/lib/artdialog/dist/dialog-plus-min.js'); ?>"></script>

    <!-- ztree -->
    <link rel="stylesheet" href="<?php echo loadStatic('/lib/zTree_v3/css/zTreeStyle/zTreeStyle.css'); ?>" type="text/css">
    <script type="text/javascript" src="<?php echo loadStatic('/lib/zTree_v3/js/jquery.ztree.core-3.5.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo loadStatic('/lib/zTree_v3/js/jquery.ztree.excheck-3.5.js'); ?>"></script>

    <script type="text/javascript">
        var SYS_DOMAIN = '<?php echo $domain['domain']; ?>';
        var SYS_IMG_DOMAIN = '<?php echo $domain['img_domain']; ?>';
    </script>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="<?php echo loadStatic('/lib/html5.js'); ?>"></script>
    <![endif]-->
</head>
<body class="theme-3" style="min-width:350px;">
