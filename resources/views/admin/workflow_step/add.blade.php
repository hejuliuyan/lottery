<?php echo widget('Admin.Common')->header(); ?>
    <?php echo widget('Admin.Common')->top(); ?>
    <?php echo widget('Admin.Menu')->leftMenu(); ?>
    <div class="content">
        <?php echo widget('Admin.Menu')->contentMenu(); ?>
        <?php echo widget('Admin.Common')->crumbs(); ?>
        <div class="main-content">

          <ul class="nav nav-tabs">
            <li class="active"><a href="#home" data-toggle="tab">填写工作流步骤信息</a></li>
          </ul>

          <div class="row">
            <div class="col-md-4">
              <br>
              <div id="myTabContent" class="tab-content">
                <div class="tab-pane active in" id="home">
                  <form id="tab" target="hiddenwin" method="post" action="<?php echo $formUrl; ?>">
                    <div class="form-group input-group-sm">
                      <label>工作流步骤名字</label>
                      <input type="text" value="<?php if(isset($info['name'])) echo $info['name']; ?>" name="data[name]" class="form-control">
                    </div>
                    <?php $isTier = ($workflowInfo['type'] == App\Models\Admin\Workflow::W_TYPE_TIER); ?>
                    <?php if($isTier): ?>
                      <div class="form-group input-group-sm">
                        <label>工作流步骤</label>
                        <select name="data[step_level]" id="DropDownTimezone" class="form-control">
                          <?php if(isset($stepList) and is_array($stepList)): ?>
                            <?php foreach($stepList as $key => $value): ?>
                                <option value="<?php echo $value['step_level'];?>" <?php if(isset($info['step_level']) && $info['step_level'] == $value['step_level']) echo 'selected'; ?>><?php echo $value['title'];?></option>
                            <?php endforeach; ?>
                          <?php endif;?>
                        </select>
                      </div>
                    <?php else: ?>
                      <div class="form-group input-group-sm">
                        <label>调用代码<small style="color:#bbb;padding-left:10px;">用于程序结合的调用，请保持唯一性，一但确定不要更改。</small></label>
                        <input type="text" placeholder="建议格式：W_xxx" value="<?php if(isset($info['code'])) echo $info['code']; ?>" name="data[code]" <?php if(isset($stepId)): ?>readonly<?php endif; ?> class="form-control">
                      </div>
                    <?php endif; ?>
                    <div class="form-group">
                      <label>备注</label>
                      <textarea name="data[description]" rows="3" class="form-control"><?php if(isset($info['description'])) echo $info['description']; ?></textarea>
                    </div>
                    <div class="btn-toolbar list-toolbar">
                      <a class="btn btn-primary btn-sm sys-btn-submit" data-loading="保存中..." ><i class="fa fa-save"></i> <span class="sys-btn-submit-str">保存</span></a>
                    </div>
                    <?php if(isset($workflowId)): ?>
                      <input name="workflow_id" type="hidden" value="<?php echo $workflowId;?>" />
                      <input type="hidden" name="_form_hash" value="<?php echo form_hash([ 'workflow_id' => $workflowId ]); ?>" />
                    <?php endif; ?>
                    <?php if(isset($stepId, $workflow_Id)): ?>
                      <input name="workflow_step_id" type="hidden" value="<?php echo $stepId;?>" />
                      <input name="workflow_id" type="hidden" value="<?php echo $workflow_Id;?>" />
                      <input type="hidden" name="_form_hash" value="<?php echo form_hash([ 'workflow_step_id' => $stepId, 'workflow_id' => $workflow_Id ]); ?>" />
                    <?php endif; ?>
                  </form>
                </div>
              </div>
            </div>
          </div>

          <?php echo widget('Admin.Common')->footer(); ?>
        </div>
    </div>
<?php echo widget('Admin.Common')->htmlend(); ?>