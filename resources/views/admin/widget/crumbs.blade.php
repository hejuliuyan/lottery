<div class="header">
    <?php if($btnGroup !== false): ?>
        <?php echo widget('Admin.'.$btnGroup)->navBtn(); ?>
    <?php endif;?>
    <ul class="breadcrumb">
        <li><a href="<?php echo R('common', 'foundation.index.index'); ?>">首页</a></li>
        <?php if( ! empty($topMenu) and isset($topMenu['name'])): ?>
            <li class="active"><?php echo $topMenu['name']; ?></li>
        <?php endif; ?>
        <?php if( ! empty($currentMCAinfo) and isset($currentMCAinfo['name'])): ?>
            <li class="active"><?php echo $currentMCAinfo['name']; ?></li>
        <?php endif; ?>
    </ul>
</div>