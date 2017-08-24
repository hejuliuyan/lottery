<?php echo widget('Admin.Common')->header(); ?>
    <?php echo widget('Admin.Common')->top(); ?>
    <?php echo widget('Admin.Menu')->leftMenu(); ?>
    <div class="content">
        <?php echo widget('Admin.Menu')->contentMenu(); ?>
        <?php echo widget('Admin.Common')->crumbs(); ?>
        <div class="main-content">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#home" data-toggle="tab">填写文章信息</a></li>
          </ul>

          <div class="row">
            <div class="col-md-8">
              <br>
              <div id="myTabContent" class="tab-content">
                <div class="tab-pane active in" id="home">
                  <form id="tab" target="hiddenwin" method="post" action="<?php echo $formUrl; ?>">
                    <div class="form-group input-group-sm">
                      <label>标题</label>
                      <input type="text" value="<?php if(isset($info['title'])) echo $info['title']; ?>" name="data[title]" class="form-control">
                    </div>

                    <div class="form-group">
                      <label>简介</label>
                      <textarea name="data[summary]" rows="3" class="form-control"><?php if(isset($info['summary'])) echo $info['summary']; ?></textarea>
                    </div>

                    <div class="form-group input-group-sm">
                      <label>标签</label>
                      <input type="text" value="<?php if(isset($info['tagsInfo'])) echo implode(';', $info['tagsInfo']); ?>" name="data[tags]" class="form-control" placeholder="标签与标签之间请用“;”符号隔开。例如：PHP;LAMP">
                    </div>

                    <div class="form-group input-group-sm">
                      <label>类别</label><br/>
                      <select data-placeholder="请选择分类" class="form-control chosen-select" multiple name="data[classify][]">
                          <option value=""></option>
                          <?php if(isset($classifyInfo) && is_array($classifyInfo)): ?>
                              <?php foreach($classifyInfo as $key => $value): ?>
                                <option value="<?php echo $value['id']; ?>" <?php if(isset($info['classifyInfo']) and in_array($value['id'], $info['classifyInfo'])) echo 'selected'; ?> ><?php echo $value['name']; ?></option>;
                              <?php endforeach; ?>
                            <?php endif; ?>
                      </select>
                    </div>

                    <div class="form-group input-group-sm">
                      <label>正文</label>
                      <script id="container" name="data[content]" type="text/plain"><?php if(isset($info['content'])) echo $info['content']; ?></script>
                    </div>

                    <div class="form-group input-group-sm">
                      <label>是否发布</label>
                      <label class="radio-inline"><input type="radio" id="genderm" <?php if(isset($info['status']) && $info['status'] == 1) echo 'checked="checked"'; ?> value="1" name="data[status]"> 是</label>
                      <label class="radio-inline"><input type="radio" id="genderf" <?php if(isset($info['status']) && $info['status'] == 0) echo 'checked="checked"'; ?> value="0" name="data[status]"> 否</label>
                    </div>
                    <div class="btn-toolbar list-toolbar">
                      <a id="save-buttom" class="btn btn-primary btn-sm sys-btn-submit" data-loading="保存中..." ><i class="fa fa-save"></i> <span class="sys-btn-submit-str">保存</span></a>
                    </div>
                    <?php if(isset($id)): ?>
                      <input name="id" type="hidden" value="<?php echo $id;?>" />
                    <?php endif; ?>
                  </form>
                </div>
              </div>
            </div>
          </div>
        <?php echo widget('Admin.Common')->footer(); ?>
            
        </div>
    </div>
    <link rel="stylesheet" type="text/css" href="/lib/chosen/min.css">
    <script src="/lib/chosen/min.js" type="text/javascript"></script>
    <script src="/lib/ueditor/ueditor.config.js" type="text/javascript"></script>
    <script src="/lib/ueditor/ueditor.all.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        var config = {
          '.chosen-select'           : {},
          '.chosen-select-deselect'  : {allow_single_deselect:true},
          '.chosen-select-no-single' : {disable_search_threshold:10},
          '.chosen-select-no-results': {no_results_text:'没有找到！'},
          '.chosen-select-width'     : {width:"95%"}
        }
        for (var selector in config) {
          $(selector).chosen(config[selector]);
        }
    </script>
    <script type="text/javascript">
        var ue = UE.getEditor('container', {
          autoHeight: false,
          initialFrameHeight: 500,
          autoFloatEnabled: true
        });

        $(document).keydown(function(e){
          // ctrl + s
          if( e.ctrlKey  == true && e.keyCode == 83 ){
            $('#save-buttom').trigger('click');
            return false; // 截取返回false就不会保存网页了
          }
        });
    </script>
<?php echo widget('Admin.Common')->htmlend(); ?>