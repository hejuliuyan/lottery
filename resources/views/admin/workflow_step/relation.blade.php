<?php echo widget('Admin.Common')->header(); ?>
    <?php echo widget('Admin.Common')->top(); ?>
    <?php echo widget('Admin.Menu')->leftMenu(); ?>
    <div class="content">
        <?php echo widget('Admin.Menu')->contentMenu(); ?>
        <?php echo widget('Admin.Common')->crumbs(); ?>
        <div class="main-content">
          <div class="function-bar-text"><h5>设置关联人员：<span style="color:#999;"><?php if(isset($info['name'])) echo $info['name']; ?></span></h5></div>
          <div id="sys-list">
          <form id="listForm" target="hiddenwin" method="post" action="<?php echo R('common', 'workflow.step.relation');?>">
          <div class="row">
              <div class=" col-md-12">
                  <div class="panel panel-default">
                    <div class="table-responsive">
                      <table class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th>选择</th>
                            <th>真实姓名</th>
                            <th>用户名</th>
                            <th>电话</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php if(isset($userList)): ?>
                          <?php foreach($userList as $key => $value): ?>
                            <tr>
                              <td><input type="checkbox" name="ids[]" class="ids" value="<?php echo $value['id']; ?>" <?php if($value['selected']) echo 'checked'; ?> ></td>
                              <td><?php echo $value['realname']; ?></td>
                              <td><?php echo $value['name']; ?></td>
                              <td><?php echo $value['mobile']; ?></td>
                            </tr>
                          <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                      </table>
                      </div>
                  </div>
              </div>
          </div>
          <input type="hidden" name="stepId" value="<?php echo $stepId; ?>" >
          <input type="hidden" name="workflowId" value="<?php echo $workflowId; ?>" >
          <input type="hidden" name="_form_hash" value="<?php echo form_hash([ 'stepId' => $stepId, 'workflowId' => $workflowId ]); ?>" />
          <?php echo widget('Admin.WorkflowStep')->selected(); ?>
          </form>
          <?php echo isset($page) ? $page : ''; ?>
          </div>
          <?php echo widget('Admin.Common')->footer(); ?>
        </div>
    </div>
<?php echo widget('Admin.Common')->htmlend(); ?>