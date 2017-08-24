<?php echo widget('Admin.Common')->header(); ?>
    <?php echo widget('Admin.Common')->top(); ?>
    <?php echo widget('Admin.Menu')->leftMenu(); ?>
    <div class="content">
        <?php echo widget('Admin.Menu')->contentMenu(); ?>
        <?php echo widget('Admin.Common')->crumbs('Content'); ?>
        <div class="main-content">
        <div id="sys-list">
          <div class="row">
              <div class="col-md-12">
                <form method="get" action="" class="form-inline">
                  <div class="form-group input-group-sm f-g">
                    <label for="search-keyword"></label>
                    <input type="text" value="<?php if(isset($search['keyword'])) echo $search['keyword']; ?>" name="keyword" id="search-keyword" class="form-control" placeholder="请输入关键词" >
                  </div>

                  <div class="form-group input-group-sm f-g">
                    <label for="search-username">作者</label>
                    <select name="username" id="DropDownTimezone" class="form-control">
                      <option value="">请选择</option>
                      <?php if(isset($users) and is_array($users)): ?>
                        <?php foreach($users as $key => $value): ?>
                            <option value="<?php echo $value['id'];?>" <?php if(isset($search['username']) && $search['username'] == $value['id']) echo 'selected'; ?>><?php echo $value['name'];?></option>
                        <?php endforeach; ?>
                      <?php endif;?>
                    </select>
                  </div>

                  <div class="form-group input-group-sm f-g">
                    <label for="search-classify">分类</label>
                    <select name="classify" id="DropDownTimezone" class="form-control">
                      <option value="">请选择</option>
                      <?php if(isset($classifyInfo) and is_array($classifyInfo)): ?>
                        <?php foreach($classifyInfo as $key => $value): ?>
                            <option value="<?php echo $value['id'];?>" <?php if(isset($search['classify']) && $search['classify'] == $value['id']) echo 'selected'; ?>><?php echo $value['name'];?></option>
                        <?php endforeach; ?>
                      <?php endif;?>
                    </select>
                  </div>

                  <div class="form-group input-group-sm f-g">
                    <label for="search-position">推荐位</label>
                    <select name="position" id="DropDownTimezone" class="form-control zdy-form-select zdy-form-select-obj">
                      <option value="">请选择</option>
                      <?php if(isset($positionInfo) and is_array($positionInfo)): ?>
                        <?php foreach($positionInfo as $key => $value): ?>
                            <option value="<?php echo $value['id'];?>" <?php if(isset($search['position']) && $search['position'] == $value['id']) echo 'selected'; ?>><?php echo $value['name'];?></option>
                        <?php endforeach; ?>
                      <?php endif;?>
                    </select>
                  </div>

                  <div class="form-group input-group-sm f-g">
                    <label for="search-tag">标签</label>
                    <select name="tag" id="DropDownTimezone" class="form-control">
                      <option value="">请选择</option>
                      <?php if(isset($tagInfo) and is_array($tagInfo)): ?>
                        <?php foreach($tagInfo as $key => $value): ?>
                            <option value="<?php echo $value['id'];?>" <?php if(isset($search['tag']) && $search['tag'] == $value['id']) echo 'selected'; ?>><?php echo $value['name'];?></option>
                        <?php endforeach; ?>
                      <?php endif;?>
                    </select>
                  </div>

                  <div class="form-group input-group-sm f-g">
                    <label for="search-time">写作时间</label>
                    <input type="text" value="<?php if(isset($search['timeFrom'])) echo $search['timeFrom']; ?>" name="time_from" id="search-time" class="form-control">
                    到
                    <input type="text" value="<?php if(isset($search['timeTo'])) echo $search['timeTo']; ?>" name="time_to" id="search-time-to" class="form-control">
                  </div>

                  <div class="form-group btn-group-sm f-g">
                    <input class="btn btn-default" type="submit" value="查询">
                  </div>
                </form>
              </div>
              <div style="margin-bottom:5px; clear:both;"></div>
              <div class="col-md-12" id="ajax-reload">
                  <div class="panel panel-default">
                    <div class="table-responsive">
                      <table class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th>选择</th>
                            <th width="50%">标题</th>
                            <th>分类</th>
                            <th>作者</th>
                            <th>写作时间</th>
                            <th>状态</th>
                            <th width="70">操作</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php if( ! empty($list)): ?>
                          <?php foreach($list as $key => $value): ?>
                            <tr>
                              <td><input autocomplete="off" type="checkbox" name="ids[]" class="ids" value="<?php echo $value['id']; ?>"></td>
                              <td><a target="_blank" href="<?php echo route('home', ['class' => 'index', 'action' => 'detail', 'id' => $value['id']]); ?>"><?php echo $value['title']; ?></a></td>
                              <td><?php echo $value['classnames']; ?></td>
                              <td><?php echo $value['name']; ?></td>
                              <td><?php echo date('Y-m-d H:i', $value['write_time']); ?></td>
                              <td>
                                <?php echo $value['status'] == 1 ? '<i class="fa fa-check" style="color:green;"></i>' : '<i class="fa fa-times" style="color:red;"></i>'; ?>
                              </td>
                              <td>
                                <?php echo widget('Admin.Content')->edit($value); ?>
                                <?php echo widget('Admin.Content')->delete($value); ?>
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
          <?php echo $deleteSelectButton = widget('Admin.Content')->deleteSelect(); ?>
          <?php echo $positionButton = widget('Admin.Content')->position(); ?>
          <?php echo $page; ?>
        </div>
        <?php echo widget('Admin.Common')->footer(); ?>
            
        </div>
    </div>
    <!-- js css -->
    <link rel="stylesheet" type="text/css" href="<?php echo loadStatic('/lib/datepicker/bootstrap-datetimepicker.min.css'); ?>">
    <script src="<?php echo loadStatic('/lib/datepicker/bootstrap-datetimepicker.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo loadStatic('/lib/datepicker/locales/bootstrap-datetimepicker.zh-CN.js'); ?>" type="text/javascript"></script>
    <script type="text/javascript">
      $('#search-time').datetimepicker({
          language:  'zh-CN',
          format: "yyyy-mm-dd hh:ii:ss",
          weekStart: 1,
          todayBtn:  1,
          autoclose: 1,
          todayHighlight: 1,
          startView: 2,
          forceParse: 0
      });

      $('#search-time-to').datetimepicker({
          language:  'zh-CN',
          format: "yyyy-mm-dd hh:ii:ss",
          weekStart: 1,
          todayBtn:  1,
          autoclose: 1,
          todayHighlight: 1,
          startView: 2,
          forceParse: 0
      });

      <?php if( ! empty($deleteSelectButton)): ?>
        $('.pl-delete').click(function() {
            var ids = plSelectValue('ids');
            if(ids.length == 0) {
                alertNotic('请先选择需要删除的文章');
                return false;
            }
            confirmNotic('确定删除吗？', function() {
              var url = '<?php echo R('common', 'blog.content.delete'); ?>';
              var params = {id:ids};
              Atag_Ajax_Submit(url, params, 'POST', $('.pl-delete'), 'ajax-reload');
            });
        });
      <?php endif; ?>

      <?php if( ! empty($positionButton)): ?>
        $('.pl-position').click(function() {
            var ids = plSelectValue('ids');
            if(ids.length == 0) {
                alertNotic('请先选择需要关联的文章');
                return false;
            }
            var _content = <?php echo widget('Admin.Content')->positionDialogContent(); ?>;
            var _d = dialog({
                title: '关联推荐位',
                id: 'pl-position',
                fixed: true,
                content: _content.content,
                okValue: '确定',
                ok: function() {
                  var pids = plSelectValue('pl-position-id');
                  if(pids.length == 0) {
                    alertNotic('请先选择需要关联的推荐位');
                    return false;
                  }
                  var url = '<?php echo R('common', 'blog.content.position'); ?>';
                  var params = {ids:ids,pids:pids};
                  Atag_Ajax_Submit(url, params, 'POST', $('.pl-position'), 'ajax-reload', true);
                },
                cancelValue: '取消',
                cancel: function () {}
            });
            _d.showModal();
        });
      <?php endif; ?>

    </script>
<?php echo widget('Admin.Common')->htmlend(); ?>