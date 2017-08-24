<?php echo widget('Admin.Common')->header(); ?>
    <?php echo widget('Admin.Common')->top(); ?>
    <?php echo widget('Admin.Menu')->leftMenu(); ?>
    <div class="content">
        <?php echo widget('Admin.Menu')->contentMenu(); ?>
        <?php echo widget('Admin.Common')->crumbs(); ?>
        <div class="main-content">

          <ul class="nav nav-tabs">
            <li class="active"><a href="#home" data-toggle="tab">填写工作流信息</a></li>
          </ul>

          <div class="row">
            <div class="col-md-4">
              <br>
              <div id="myTabContent" class="tab-content">
                <div class="tab-pane active in" id="home">
                  <form id="tab" target="hiddenwin" method="post" action="<?php echo $formUrl; ?>">
                    <div class="form-group input-group-sm">
                      <label>工作流名字</label>
                      <input type="text" value="<?php if(isset($info['name'])) echo $info['name']; ?>" name="data[name]" class="form-control">
                    </div>
                    <div class="form-group input-group-sm">
                      <label>调用代码<small style="color:#bbb;padding-left:10px;">用于程序结合的调用，请保持唯一性，一但确定不要更改。</small></label>
                      <input type="text" placeholder="建议格式：W_xxx" value="<?php if(isset($info['code'])) echo $info['code']; ?>" name="data[code]" <?php if(isset($id)): ?>readonly<?php endif; ?> class="form-control">
                    </div>
                    <div class="form-group">
                      <label>备注</label>
                      <textarea name="data[description]" rows="3" class="form-control"><?php if(isset($info['description'])) echo $info['description']; ?></textarea>
                    </div>
                    <div class="form-group input-group-sm">
                      <label>工作流类型</label>
                      <select name="data[type]" class="form-control">
                        <option value="1" <?php if(isset($info['type']) && $info['type'] == 1) echo 'selected'; ?>>多层级审核</option>
                        <option value="2" <?php if(isset($info['type']) && $info['type'] == 2) echo 'selected'; ?>>辅助权限</option>
                      </select>
                    </div>
                    <div class="btn-toolbar list-toolbar">
                      <a class="btn btn-primary btn-sm sys-btn-submit" data-loading="保存中..." ><i class="fa fa-save"></i> <span class="sys-btn-submit-str">保存</span></a>
                    </div>
                    <?php if(isset($id)): ?>
                      <input name="data[id]" type="hidden" value="<?php echo $id;?>" />
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