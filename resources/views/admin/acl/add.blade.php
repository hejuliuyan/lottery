<?php echo widget('Admin.Common')->header(); ?>
    <?php echo widget('Admin.Common')->top(); ?>
    <?php echo widget('Admin.Menu')->leftMenu(); ?>
    <div class="content">
        <?php echo widget('Admin.Menu')->contentMenu(); ?>
        <?php echo widget('Admin.Common')->crumbs(); ?>
        <div class="main-content">

          <ul class="nav nav-tabs">
            <li class="active"><a href="#home" data-toggle="tab">填写功能信息</a></li>
          </ul>

          <div class="row">
            <div class="col-md-4">
              <br>
              <div id="myTabContent" class="tab-content">
                <div class="tab-pane active in" id="home">
                  <form id="tab" target="hiddenwin" method="post" action="<?php echo $formUrl; ?>">
                    <div class="form-group input-group-sm">
                      <label>功能名</label>
                      <input type="text" value="<?php if(isset($permissionInfo['name'])) echo $permissionInfo['name']; ?>" name="data[name]" class="form-control">
                    </div>
                    <div class="form-group input-group-sm">
                      <label>模块名</label>
                      <input type="text" value="<?php if(isset($permissionInfo['module'])) echo $permissionInfo['module']; ?>" name="data[module]" class="form-control" placeholder="一般为子文件夹的名字。" >
                    </div>
                    <div class="form-group input-group-sm">
                      <label>类名</label>
                      <input type="text" value="<?php if(isset($permissionInfo['class'])) echo $permissionInfo['class']; ?>" name="data[class]" class="form-control" placeholder="一般为Contrller的类名。" >
                    </div>
                    <div class="form-group input-group-sm">
                      <label>函数名</label>
                      <input type="text" value="<?php if(isset($permissionInfo['action'])) echo $permissionInfo['action']; ?>" name="data[action]" class="form-control" placeholder="一般为Contrller的函数名。" >
                    </div>
                    <div class="form-group input-group-sm">
                      <label>父级功能</label>
                      <select class="form-control" name="data[pid]">
                        <option value="0">请选择父级功能</option>
                        <?php echo $select;?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>备注</label>
                      <textarea name="data[mark]" rows="3" class="form-control"><?php if(isset($permissionInfo['mark'])) echo $permissionInfo['mark']; ?></textarea>
                    </div>
                    <div class="form-group input-group-sm">
                      <label>是否显示为菜单</label>
                      <label class="radio-inline"><input type="radio" id="genderm" <?php if(isset($permissionInfo['display']) && $permissionInfo['display'] == 1) echo 'checked="checked"'; ?> value="1" name="data[display]"> 是</label>
                      <label class="radio-inline"><input type="radio" id="genderf" <?php if(isset($permissionInfo['display']) && $permissionInfo['display'] == 0) echo 'checked="checked"'; ?> value="0" name="data[display]"> 否</label>
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