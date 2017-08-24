<?php echo widget('Admin.Common')->header(); ?>
    <?php echo widget('Admin.Common')->top(); ?>
    <?php echo widget('Admin.Menu')->leftMenu(); ?>
    <div class="content">
        <?php echo widget('Admin.Menu')->contentMenu(); ?>
        <?php echo widget('Admin.Common')->crumbs(); ?>
        <div class="main-content">
          
        <!-- 上传的示例 -->
        上传的示例：<?php echo widget('Admin.Upload')->setConfig(['id' => 'id', 'callback' => 'returnUpload', 'thumbSetting' => [['width' => 50, 'height' => 50],['width' => 70, 'height' => 70]], 'waterSetting' => true ])->uploadButton();?>
        <script type="text/javascript">
            //示例的回调函数
            function returnUpload(uploadid, itemId) {
                var $dialog_id = uploadid;
                var $response = $(".upload-reponse", window.frames[$dialog_id].document);
                alert($response.val());
            }
        </script>

        <?php echo widget('Admin.Common')->footer(); ?>
            
        </div>
    </div>

<?php echo widget('Admin.Common')->htmlend(); ?>