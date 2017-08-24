<?php echo widget('Admin.Common')->header(); ?>

  <style type="text/css">
    body {background: none;}
  </style>

  <!--引入CSS-->
  <link rel="stylesheet" type="text/css" href="<?php echo loadStatic('/lib/webuploader/webuploader.css'); ?>">
  <!--引入JS-->
  <script type="text/javascript" src="<?php echo loadStatic('/lib/webuploader/webuploader.min.js'); ?>"></script>

  <div class="main-content">
    <div id="sys-list" style="padding-left:20px; padding-right:20px;">
      <div class="row">
        
        <!--dom结构部分-->
        <div id="uploader-comtainer">

            <div class="col-tab">
                  
                  <div class="upload-content pad-10 on" id="div_swf_1">
                      <div>
                          <div id="addnew" class="addnew"></div>
                          <div id="filePicker" class="select-upload-file-buttom">选择图片</div>
                          <div style="float:left;">
                            <a class="btn btn-primary" id="upload-btn-save" style="font-size: 12px;" >
                              立即上传
                            </a>
                          </div>
                          <div class="clear"></div>
                          <div class="onShow" id="nameTip">最多上传 <font color="red"> <?php echo (isset($args['nums']) and $args['nums']) ? intval($args['nums']) : 1; ?></font> 个附件,单文件最大 <font color="red"><?php echo (isset($args['filesize']) and $args['filesize']) ? intval($args['filesize']) : 2;?> MB</font></div>
                          <div class="bk3"></div>
                          
                          <div class="lh24">支持 <font style="font-family: Arial, Helvetica, sans-serif"><?php echo $args['alowexts']; ?></font> 格式</div><span style="display: none"><input type="checkbox" onclick="change_params()" value="1" id="watermark_enable"> 是否添加水印</span>
                      </div>  
                      <div class="bk10"></div>
                      <fieldset id="swfupload" class="blue pad-10">
                      <legend>列表</legend>
                          <!--用来存放item-->
                        <div id="fileList" class="uploader-list"></div>  
                      </fieldset>
                  </div>
            </div>

        </div>


        <script type="text/javascript">
          $(function() {
            var $list = $('#fileList'),
                // 优化retina, 在retina下这个值是2
                ratio = window.devicePixelRatio || 1,
                // 缩略图大小
                thumbnailWidth = 100 * ratio,
                thumbnailHeight = 100 * ratio,
                // Web Uploader实例
                uploader;
                // 初始化Web Uploader
                uploader = WebUploader.create({
                    // 自动上传。
                    auto: false,
                    runtimeOrder: 'html5,flash',
                    //上传域的名字
                    fileVal: 'file',
                    //允许上传的文件数
                    fileNumLimit: <?php echo (isset($args['nums']) and $args['nums']) ? intval($args['nums']) : 1; ?>,
                    //文件单个大小限制
                    fileSingleSizeLimit: <?php echo (isset($args['filesize']) and $args['filesize']) ? intval($args['filesize']) : 2;?>*1024*1024,
                    //防止重复文件加入列队
                    duplicate: true,
                    formData: {args:'<?php echo $parpams['args']; ?>', authkey:'<?php echo $parpams['authkey']; ?>'},
                    // swf文件路径
                    swf: SYS_DOMAIN + '/lib/webuploader/Uploader.swf',
                    // 文件接收服务端。
                    server: '<?php echo R('common', 'foundation.upload.process'); ?>',
                    // 选择文件的按钮。可选。
                    // 内部根据当前运行是创建，可能是input元素，也可能是flash.
                    pick: '#filePicker',
                    // 只允许选择文件，可选。
                    accept: {
                        title: 'all',
                        extensions: '<?php echo $args['alowexts']; ?>'
                    }
                });

                // 当有文件添加进来的时候
                uploader.on( 'fileQueued', function( file ) {
                    var $li = $(
                            '<div id="' + file.id + '" class="file-item thumbnail" title="' + file.name + '">' +
                                '<img>' +
                                '<div class="' + file.id + '-remove web-upload-remove" title="删除"><i class="fa fa-times-circle"></i></div>'+
                            '</div>'
                            ),
                        $img = $li.find('img');

                    $list.append( $li );

                    // 创建缩略图
                    uploader.makeThumb( file, function( error, src ) {
                        var $fileExt = fileExt(file.ext);
                        if ( error ) {
                            //$img.replaceWith('<span>不能预览</span>');
                            $img.attr( 'src', SYS_DOMAIN+'/images/ext/'+ $fileExt+'.png');
                            $img.attr('width', thumbnailWidth).attr('height',thumbnailHeight);
                            return;
                        }

                        $img.attr( 'src', src );
                    }, thumbnailWidth, thumbnailHeight );

                    removeImage(file);
                    
                });

                //删除图片
                uploader.on('fileDequeued', function (file) {
                    removeImageView(file);
                });

                // 文件上传过程中创建进度条实时显示。
                uploader.on( 'uploadProgress', function( file, percentage ) {
                    var $li = $( '#'+file.id ),
                        $percentP = $li.find('.progress'),
                        $percent = $li.find('.progress span');

                    // 避免重复创建
                    if ( !$percent.length ) {
                        $percent = $('<p class="progress"><span class="text-show-yes">上传中...</span></p>')
                                .appendTo( $li )
                                .find('span');
                    }
                    $percent.css( 'width', percentage * 100 + '%' );
                    $percentP.css( 'width', percentage * 100 + '%' );
                });

                // 文件上传成功，给item添加成功class, 用样式标记上传成功。
                uploader.on( 'uploadSuccess', function( file, response ) {
                    //保存服务器返回的真实的保存路径
                    $( '#'+file.id ).addClass('upload-state-done').append('<input type="hidden" class="upload-reponse" value="'+response.file+'" />');
                    $('.progress .text-show-yes').html('上传成功');
                });

                // 文件上传失败，现实上传出错。
                uploader.on( 'uploadError', function( file ) {
                    var $li = $( '#'+file.id ),
                        $error = $li.find('div.error');

                    // 避免重复创建
                    if ( !$error.length ) {
                        $error = $('<div class="error"></div>').appendTo( $li );
                    }

                    $error.text('上传失败');
                });

                uploader.on('error', function (code, file) {
                    if (code == 'Q_TYPE_DENIED' || code == 'F_EXCEED_SIZE') {
                        removeImage(file);
                    }
                });

                // 完成上传完了，成功或者失败，先删除进度条。
                uploader.on( 'uploadComplete', function( file ) {
                    setTimeout(function(){
                      $( '#'+file.id ).find('.progress').remove();
                    }, 800 );
                });

                //删除图片
                function removeImage(file) {
                  $(document).on('click', '.' + file.id + '-remove', function(){
                    uploader.removeFile(file);
                  });
                }

                //删除图片view
                function removeImageView(file) {
                  var $div = $('#' + file.id);
                  $div.remove();
                }

                //立即上传
                $('#upload-btn-save').click(function(){
                  uploader.upload();
                });

                //返回非图片的预览图
                function fileExt(fileext) {
                    if(fileext == 'zip' || fileext == 'rar') fileext = 'rar';
                    else if(fileext == 'doc' || fileext == 'docx') fileext = 'doc';
                    else if(fileext == 'xls' || fileext == 'xlsx') fileext = 'xls';
                    else if(fileext == 'ppt' || fileext == 'pptx') fileext = 'ppt';
                    else if (fileext == 'flv' || fileext == 'swf' || fileext == 'rm' || fileext == 'rmvb') fileext = 'flv';
                    else fileext = 'do';
                    return fileext;
                }
                
            });
        </script>

      </div>
    </div>
  </div>
<?php echo widget('Admin.Common')->htmlend(); ?>