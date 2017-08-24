<div id="detail-comment">
    <div class="write-comment-main" style="text-align:center;padding-top:50px;">评论加载中，请稍等...</div>
    <script type="text/javascript">
        $(document).ready(function(){
            $.get('<?php echo route("home", ["class" => "comment", "action" => "ls", "objectid" => $objectId]); ?>', function(data){
                $('#detail-comment').html(data);
            });
        });
    </script>
</div>

<script type="text/javascript">
    function reloadComment() {
        $.get('<?php echo route("home", ["class" => "comment", "action" => "ls", "objectid" => $objectId]); ?>', function(data){
            $('#detail-comment').html(data);
        });
    }
</script>