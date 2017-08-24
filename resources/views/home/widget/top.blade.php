<div class="header">
  <div class="input-group search pull-right hidden-sm hidden-xs">
    <div class="input-group">
      <input type="text" class="form-control input-sm" id="search-keyword" placeholder="搜索你想要的。" value="<?php if(isset($object->keyword)) echo $object->keyword; ?>">
      <span class="input-group-btn">
          <button type="button" class="btn btn-primary btn-sm" id="search"><i class="fa fa-search "></i></button>
      </span>
    </div>
  </div>
  <h1 class="page-title"><a href="/">风一样的世界</a></h1>
  <p>有追求才有实现，就像风一样去追寻自己的梦想。</p>
</div>
<script type="text/javascript">
  $(document).ready(function(){
    $('#search').on('click', function(){
      var keyword = $('#search-keyword').val();
      window.location.href = '<?php echo route("home", array("class" => "search", "action" => "index")); ?>?keyword='+keyword;
    });

    $('#search-keyword').keyup(function(event){
      if (event.keyCode == 13) {
        $('#search').trigger('click');
      }
    });
  });
</script>
