<?php echo widget('Admin.Common')->header(); ?>
    <?php echo widget('Admin.Common')->top(); ?>
    <?php echo widget('Admin.Menu')->leftMenu(); ?>
    <div class="content">
        <?php echo widget('Admin.Menu')->contentMenu(); ?>
        <?php echo widget('Admin.Common')->crumbs(); ?>
        <div class="main-content">
        <div id="sys-list">
          <div class="row">
              <div class="col-md-12">
                <form method="get" action="" class="form-inline">

                  <div class="form-group input-group-sm f-g">
                    <label for="search-position">推荐位</label>
                    <select name="position" id="DropDownTimezone" class="form-control">
                      <?php if(isset($positionInfo) and is_array($positionInfo)): ?>
                        <?php foreach($positionInfo as $key => $value): ?>
                            <option value="<?php echo $value['id'];?>" <?php if(isset($positionId) && $positionId == $value['id']) echo 'selected'; ?>><?php echo $value['name'];?></option>
                        <?php endforeach; ?>
                      <?php endif;?>
                    </select>
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
                            <th width="60">选择</th>
                            <th width="70">排序</th>
                            <th>标题</th>
                            <th width="70">操作</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php if( ! empty($list)): ?>
                          <?php foreach($list as $key => $value): ?>
                            <tr>
                              <td><input autocomplete="off" type="checkbox" name="ids[]" class="ids" value="<?php echo $value['id']; ?>"></td>
                              <td><input type="text" class="pl-input-sort" data-prid="<?php echo $value['id']; ?>" value="<?php echo $value['sort']; ?>" style="width:50px;text-align:center;"></td>
                              <td><a target="_blank" href="<?php echo route('home', ['class' => 'index', 'action' => 'detail', 'id' => $value['article_id']]); ?>"><?php echo $value['title']; ?></a></td>
                              <td>
                                <?php echo widget('Admin.Position')->deleteRelation($value); ?>
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
          <?php echo $deleteSelectButton = widget('Admin.Position')->deleteSelectRelation(); ?>
          <?php echo $relationSortButton = widget('Admin.Position')->relationSort(); ?>
          <?php echo $page; ?>
        </div>
        <?php echo widget('Admin.Common')->footer(); ?>
            
        </div>
    </div>
    <!-- js css -->
    <script type="text/javascript">
      <?php if( ! empty($deleteSelectButton)): ?>
        $('.pl-delete').click(function() {
            var ids = plSelectValue('ids');
            if(ids.length == 0) {
                alertNotic('请先选择需要取消关联的文章');
                return false;
            }
            confirmNotic('确定取消关联吗？', function() {
              var url = '<?php echo R('common', 'blog.position.delrelation'); ?>';
              var params = {prid:ids};
              Atag_Ajax_Submit(url, params, 'POST', $('.pl-delete'), 'ajax-reload');
            });
        });
      <?php endif; ?>

      <?php if( ! empty($relationSortButton)): ?>
        $('.pl-sort').click(function() {
            var data = new Array();
            var json;
            $('.pl-input-sort').each(function(i, n){
              json = {"prid": $(n).attr('data-prid'), "sort": $(n).val()};
              data.push(json);
            });
            var url = '<?php echo R('common', 'blog.position.sortrelation'); ?>';
            var params = {data:data};
            Atag_Ajax_Submit(url, params, 'POST', $(this), 'ajax-reload');
        });
      <?php endif; ?>
    </script>
<?php echo widget('Admin.Common')->htmlend(); ?>