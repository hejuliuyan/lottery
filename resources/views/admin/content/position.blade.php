<?php echo widget('Admin.Common')->header(); ?>
    <?php echo widget('Admin.Common')->top(); ?>
    <?php echo widget('Admin.Menu')->leftMenu(); ?>
    <div class="content">
        <?php echo widget('Admin.Menu')->contentMenu(); ?>
        <?php echo widget('Admin.Common')->crumbs('Position'); ?>
        <div class="main-content">
        <div id="sys-list">
          <div class="row">
              <div class=" col-md-12">
                <div class="table-responsive">
                  <div class="panel panel-default">
                    <div class="table-responsive">
                      <table class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th>分类名字</th>
                            <th>状态</th>
                            <th>增加时间</th>
                            <th width="70">操作</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach($list as $key => $value): ?>
                            <tr>
                              <td><?php echo $value['name']; ?></td>
                              <td>
                                <?php echo $value['is_active'] == 1 ? '<i class="fa fa-check" style="color:green;"></i>' : '<i class="fa fa-times" style="color:red;"></i>'; ?>
                              </td>
                              <td><?php echo date('Y-m-d H:i', $value['time']); ?></td>
                              <td>
                                <?php echo widget('Admin.Position')->relation($value); ?>
                                <?php echo widget('Admin.Position')->edit($value); ?>
                                <?php echo widget('Admin.Position')->delete($value); ?>
                              </td>
                            </tr>
                          <?php endforeach; ?>
                        </tbody>
                      </table>
                      </div>
                      </div>
                  </div>
              </div>
          </div>
          <?php echo $page; ?>
        </div>
        <?php echo widget('Admin.Common')->footer(); ?>
            
        </div>
    </div>
<?php echo widget('Admin.Common')->htmlend(); ?>