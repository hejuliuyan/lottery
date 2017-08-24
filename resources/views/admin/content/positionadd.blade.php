<?php echo widget('Admin.Common')->header(); ?>
    <?php echo widget('Admin.Common')->top(); ?>
    <?php echo widget('Admin.Menu')->leftMenu(); ?>
    <div class="content">
        <?php echo widget('Admin.Menu')->contentMenu(); ?>
        <?php echo widget('Admin.Common')->crumbs(); ?>
        <div class="main-content">

          <ul class="nav nav-tabs">
            <li class="active"><a href="#home" data-toggle="tab">填写文章推荐位信息</a></li>
          </ul>

          <div class="row">
            <div class="col-md-4">
              <br>
              <div id="myTabContent" class="tab-content">
                <div class="tab-pane active in" id="home">
                  <form id="tab" target="hiddenwin" method="post" action="<?php echo $formUrl; ?>">
                    <div class="form-group input-group-sm">
                      <label>推荐位名字</label>
                      <input type="text" value="<?php if(isset($info['name'])) echo $info['name']; ?>" name="data[name]" class="form-control">
                    </div>
                    <div class="form-group input-group-sm">
                      <label>是否激活</label>
                      <label class="radio-inline"><input type="radio" id="genderm" <?php if(isset($info['is_active']) && $info['is_active'] == 1) echo 'checked="checked"'; ?> value="1" name="data[is_active]"> 是</label>
                      <label class="radio-inline"><input type="radio" id="genderf" <?php if(isset($info['is_active']) && $info['is_active'] == 0) echo 'checked="checked"'; ?> value="0" name="data[is_active]"> 否</label>
                    </div>
                    <div class="btn-toolbar list-toolbar">
                      <a class="btn btn-sm btn-primary sys-btn-submit" data-loading="保存中..." ><i class="fa fa-save"></i> <span class="sys-btn-submit-str">保存</span></a>
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