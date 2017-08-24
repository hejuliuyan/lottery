<!doctype html>
<html lang="zh-cn"><head>
    <meta charset="utf-8">
    <title>风一样的世界---专注PHP开发</title>
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php if(isset($headerObject->description)) { echo $headerObject->description; } else { echo '风一样的世界，专注PHP开发，在这里，你可以看到我的一些学习的分享。'; } ?>">
    <meta name="author" content="jiang">
    <link rel="stylesheet" type="text/css" href="<?php echo loadStatic('/lib/bootstrap/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo loadStatic('/lib/font-awesome/css/font-awesome.min.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo loadStatic('/stylesheets/t.min.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo loadStatic('/stylesheets/premium.css'); ?> ">
    <link rel="stylesheet" type="text/css" href="<?php echo loadStatic('/home/home.css'); ?>">
    <style type="text/css">
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
    <script src="<?php echo loadStatic('/home/lib.js'); ?>" type="text/javascript"></script>
    <!-- 弹出窗口 -->
    <link rel="stylesheet" href="<?php echo loadStatic('/lib/artdialog/css/ui-dialog.css'); ?>">
    <script src="<?php echo loadStatic('/lib/artdialog/dist/dialog-plus-min.js'); ?>"></script>
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="<?php echo loadStatic('/lib/html5.js'); ?>"></script>
    <![endif]-->
</head>
<body class="theme-3">
    