<?php echo widget('Admin.Common')->header(); ?>
    <?php echo widget('Admin.Common')->top(); ?>
    <?php echo widget('Admin.Menu')->leftMenu(); ?>
    <div class="content">
        <?php echo widget('Admin.Menu')->contentMenu(); ?>
        <?php echo widget('Admin.Common')->crumbs('Workflow'); ?>
        <div class="main-content">
          <div id="sys-list">
          <div class="row">
              <div class=" col-md-12">
                  <div class="panel panel-default">
                    <div class="table-responsive">
                      <table class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th>调用代码(<a href="#" title="主要用于接口调用">?</a>)</th>
                            <th>类型(<a href="#" title="主要分为：1）多层级审核，即多人同时参与的层级审核，低等级的用户审核通过后会提交给高等级人用户审核。2）辅助权限，当普通的用户权限管理不能满足时，它可以用来处理更细化的权限管理需求。和普通的用户权限结合成多级权限管理。">?</a>)</th>
                            <th>工作流名字</th>
                            <th>备注</th>
                            <th>增加的时间</th>
                            <th>详情</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php if(isset($list)): ?>
                          <?php foreach($list as $key => $value): ?>
                            <tr>
                              <td><?php echo $value['code']; ?></td>
                              <td><?php echo $value['type'] == App\Models\Admin\Workflow::W_TYPE_TIER ? '多层级审核' : '辅助权限'; ?></td>
                              <td><?php echo $value['name']; ?></td>
                              <td><?php echo $value['description']; ?></td>
                              <td><?php echo date('Y-m-d', $value['addtime']); ?></td>
                              <td>
                                <?php echo widget('Admin.Workflow')->edit($value); ?>
                                <?php echo widget('Admin.Workflow')->detail($value); ?>
                                <?php echo widget('Admin.Workflow')->delete($value); ?>
                              </td>
                            </tr>
                          <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                      </table>
                      </div>
                  </div>
              </div>
          </div>
          <?php echo isset($page) ? $page : ''; ?>
          </div>
          <?php echo widget('Admin.Common')->footer(); ?>
        </div>
    </div>
<?php echo widget('Admin.Common')->htmlend(); ?>