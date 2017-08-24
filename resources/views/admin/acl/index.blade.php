<?php echo widget('Admin.Common')->header(); ?>
    <?php echo widget('Admin.Common')->top(); ?>
    <?php echo widget('Admin.Menu')->leftMenu(); ?>
    <div class="content">
        <?php echo widget('Admin.Menu')->contentMenu(); ?>
        <?php echo widget('Admin.Common')->crumbs('Acl'); ?>
        <div class="main-content">
          <div id="sys-list">
          <form id="aclListForm" target="hiddenwin" method="post" action="<?php echo R('common', 'foundation.acl.sort');?>">
          <div class="row">
              <div class=" col-md-12">
                  <div id="featurebar">
                    <ul class="nav">
                      <li class="active">
                        <a href="<?php echo R('common', 'foundation.acl.index', ['pid' => 'all' ]); ?>">所有功能</a>
                      </li>
                      <?php
                        $son = App\Services\Admin\Tree::getSonKey();
                        $all = array();
                        foreach($list as $key => $value):
                          if( ! isset($value[$son])) continue;
                                      
                      ?>
                            <li class="active">
                              <a <?php if($pid == $value['id']) echo 'style="background: #ddd; color: #333"'; ?> href="<?php echo R('common', 'foundation.acl.index', ['pid' => $value['id'] ]); ?>"><?php echo $value['name']; ?></a>
                            </li>
                      <?php
                        endforeach;
                      ?>
                    </ul>
                  </div>

                  <div class="panel panel-default">
                    <div class="table-responsive">
                      <table class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th>排序</th>
                            <th>功能名字</th>
                            <th>功能代码（-为分隔线）</th>
                            <th>显示为菜单?</th>
                            <th>备注</th>
                            <th>操作</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php echo widget('Admin.Acl')->acllist($list, $pid); ?>
                        </tbody>
                      </table>
                      </div>
                  </div>
              </div>
          </div>
          <?php echo widget('Admin.Acl')->sort(); ?>
          </form>
          </div>
          <?php echo widget('Admin.Common')->footer(); ?>
        </div>
    </div>
<?php echo widget('Admin.Common')->htmlend(); ?>