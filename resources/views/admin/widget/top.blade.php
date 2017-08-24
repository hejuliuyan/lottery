<div class="navbar navbar-default" role="navigation">
<div class="navbar-header">
  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
    <span class="sr-only">Toggle navigation</span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
  </button>
  <a class="" href="/"><span class="navbar-brand">管理系统</span></a></div>

<div class="navbar-collapse collapse" style="height: 1px;">
  <ul id="main-menu" class="nav navbar-nav navbar-right">
    <li class="dropdown hidden-xs">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <span class="glyphicon glyphicon-user padding-right-small" style="position:relative;top: 3px;"></span> <?php echo $username; ?>
            <i class="fa fa-caret-down"></i>
        </a>

      <ul class="dropdown-menu">
        <li><a tabindex="-1" href="javascript:;" data-dialog-id="modify-password" class="modify-password">修改密码</a></li>
        <li><a tabindex="-1" href="javascript:;" data-dialog-id="menu-map" class="menu-map">功能地图</a></li>
        <li class="divider"></li>
        <li><a tabindex="-1" href="<?php echo route('foundation.login.out'); ?>">退出</a></li>
      </ul>

    </li>
  </ul>

</div>
</div>
<?php echo widget('Admin.Common')->mpassword(); ?>
<?php echo widget('Admin.Common')->menumap(); ?>