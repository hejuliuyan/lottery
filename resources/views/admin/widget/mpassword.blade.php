<div class="none modify-password-content">
  <div class="form-group  input-group-sm">
    <label>旧密码</label>
    <input type="password" value="" name="old_password" class="form-control">
  </div>
  <div class="form-group  input-group-sm">
    <label>新密码</label>
    <input type="password" value="" name="new_password" class="form-control">
  </div>
  <div class="form-group  input-group-sm">
    <label>确认新密码</label>
    <input type="password" value="" name="new_password_repeat" class="form-control">
  </div>
</div>
<script type="text/javascript">
  var __mpass = {
    postUrl: '<?php echo R('common', 'foundation.user.mpassword'); ?>',
    mpobj: $('.modify-password'),
    mpcontent: $('.modify-password-content'),
    dialogConf: {
      width: 390,
      height: 230,
      title: '修改密码',
      okValue: '确定',
      cancelValue: '取消',
      doingValue: '提交中…'
    },
    init: function() {
      var _this = __mpass;
      _this.mpobj.click(_this.dialog);
    },
    dialog: function() {
      var _this = __mpass;
      var _d = dialog({
        title: _this.dialogConf.title,
        id: _this.mpobj.attr('data-dialog-id'),
        fixed: true,
        content: _this.mpcontent.html(),
        width: _this.dialogConf.width,
        height: _this.dialogConf.height,
        okValue: _this.dialogConf.okValue,
        ok: function() {
          return _this.okCallback(this);
        },
        cancelValue: _this.dialogConf.cancelValue,
        cancel: function () {}
      });
      _d.showModal();
    },
    okCallback: function(dialogObj) {
      var _this = __mpass;
      dialogObj.title(_this.dialogConf.doingValue);
      var old_password = $('input[name="old_password"]:visible').val();
      var new_password = $('input[name="new_password"]:visible').val();
      var new_password_repeat = $('input[name="new_password_repeat"]:visible').val();
      $.post(_this.postUrl, {old_password:old_password,new_password:new_password,new_password_repeat:new_password_repeat}, function(data) {
          alertNotic(data.message);
          dialogObj.title(_this.dialogConf.title);
          if(data.result == 'success') {
            dialogObj.close().remove();
            window.location.href = '/';
          }
        }
      );
      return false;
    }
  };

  $(document).ready(function() {
    __mpass.init();
  });
</script>