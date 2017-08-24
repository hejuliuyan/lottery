<?php echo widget('Home.Common')->header(); ?>
    <div class="content col-md-9">
        <?php echo widget('Home.Common')->top(); ?>
        <?php if( (isset($object->category) and ! empty($object->category)) or (isset($object->tag) and ! empty($object->tag)) or (isset($object->keyword))): ?>
            <div class="tag-category-title" style="color:#ccc;padding-bottom:10px;">以下为分类（标签）的筛选数据：</div>
        <?php endif; ?>
        <div class="main-content">
          <div class="row">
            <div class="col-sm-9 main-content">

                <div id="blog-posts">
                    <?php foreach($articleList as $key => $value): ?>
                    <div class="row padding-bottom">
                        <div class="col-md-12">
                            <div class="post-summary">      
                                <h3 class="h_h3" style="margin-top: 0px;">
                                    <a href="<?php echo route('home', ['class' => 'index', 'action' => 'detail', 'id' => $value['id']]); ?>">
                                        <?php echo $value['title']; ?>
                                    </a>
                                </h3>
                                <p class="text-sm p_h_info">
                                  <span class="span_h_info">分类：</span><?php echo $value['classnames']; ?> &nbsp&nbsp&nbsp
                                  <span class="span_h_info">标签：</span><?php echo $value['tagsnames']; ?> &nbsp&nbsp&nbsp
                                  <span class="span_h_info">发布时间：</span><?php echo showWriteTime($value['write_time']); ?></p>
                                <p class="p_h_summary">
                                  <?php echo $value['summary']; ?>
                                </p>
                                <p><a href="<?php echo route('home', ['class' => 'index', 'action' => 'detail', 'id' => $value['id']]); ?>" class="btn btn-default btn-xs">查看详情</a></p>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <div style="text-align: center;">
                    <?php echo $page; ?>
                </div>
            </div>
            <?php echo widget('Home.Common')->right(); ?>
          </div>
        <?php echo widget('Home.Common')->footer(); ?>
            
        </div>
    </div>
<?php echo widget('Home.Common')->htmlend(); ?>