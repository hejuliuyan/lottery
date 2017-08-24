<div class="col-sm-3 sidebar">
    <div class="widget">
    <h3 style="margin-top: 0px;">文章分类</h3>
        <div class="widget-body">
            <ul class="icons list-unstyled">
                <?php foreach($classifyInfo as $key => $value): ?>
                    <li><a href="<?php echo route('home', ['class' => 'index', 'action' => 'index', 'category' => $value['id']]); ?>"><i class="icon-angle-right"></i> <?php echo $value['name']; ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <div class="widget">

        <h3>标签</h3>
        <p class="widget-body">
            <?php foreach($tagsInfo as $key => $value): ?>
                <a href="<?php echo route('home', ['class' => 'index', 'action' => 'index', 'tag' => $value['id']]); ?>"><span class="large label tag label-info"><?php echo $value['name']; ?></span></a>
            <?php endforeach; ?>
        </p>

    </div>

</div>