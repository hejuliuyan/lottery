<?php echo widget('Admin.Common')->header(); ?>
    <?php echo widget('Admin.Common')->top(); ?>
    <?php echo widget('Admin.Menu')->leftMenu(); ?>
    <div class="content">
        <?php echo widget('Admin.Menu')->contentMenu(); ?>
        <?php echo widget('Admin.Common')->crumbs('Acl'); ?>
        <style type="text/css">
          table.table-striped th, table.table-striped td {background-color:#fff!important;border-bottom-width:1px!important;}
        </style>
        <div class="main-content">
          <div id="sys-list">
          <div class="row">
            <div class="col-md-12">
              <div id="featurebar" style="padding:0px;">
                <div class="heading">设置权限 : <?php echo isset($info['name']) ? $info['name'] : ''; ?><?php echo isset($info['group_name']) ? $info['group_name'] : ''; ?></div>
              </div>
              <?php
                $zTree_Node = json_encode($zTree);
              ?>
              <div id="zTree-container" class="ztree"></div>
              <script type="text/javascript">
                var __zTree_Node = <?php echo $zTree_Node; ?>;
                var __setting = {
                  check: {
                    enable: true,
                    chkboxType: { "Y" : "p", "N" : "ps" }
                  },
                  data: {
                    simpleData: {
                      enable: true
                    }
                  }
                };
                $(document).ready(function(){

                  $.fn.zTree.init($("#zTree-container"), __setting, __zTree_Node);

                  //获取所有选中节点的值
                  function getCheckedAll() {
                      var treeObj = $.fn.zTree.getZTreeObj("zTree-container");
                      var nodes = treeObj.getCheckedNodes(true);
                      var checkNodes = new Array();
                      for (var i = 0; i < nodes.length; i++) {
                          checkNodes.push(nodes[i].id);
                      }
                      return checkNodes;
                  }

                  //save
                  $('.sys-ajax-btn-submit').click(function(){
                    var _url = '<?php echo R('common', 'foundation.acl.'.$router); ?>';
                    var _id = $('input[name="id"]').val();
                    var _all = $('input[name="all"]').val();
                    var _form_hash = $('input[name="_form_hash"]').val();
                    var _nodes = getCheckedAll();
                    var params = {permission:_nodes, id:_id, all:_all, _form_hash:_form_hash};
                    Atag_Ajax_Submit(_url, params, 'POST', $(this));
                  });

                });
              </script>
              <div class="btn-toolbar list-toolbar">
                <a class="btn btn-primary btn-sm sys-ajax-btn-submit" data-loading="保存中..." ><i class="fa fa-save"></i> <span class="sys-btn-submit-str">保存</span></a>
                <button class="btn btn-default btn-sm" onclick="javascript:history.go(-1);" type="button">返回</button>
                <input type="hidden" name="id" value="<?php echo $id;?>" />
                <input type="hidden" name="all" value="<?php echo implode(',', $all); ?>" />
                <input type="hidden" name="_form_hash" value="<?php echo form_hash([ 'id' => $id, 'all' => implode(',', $all) ]); ?>" />
              </div>
            </div>
          </div>
          </div>
          <?php echo widget('Admin.Common')->footer(); ?>
        </div>
    </div>
<?php echo widget('Admin.Common')->htmlend(); ?>