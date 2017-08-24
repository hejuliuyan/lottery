<div class="write-comment-main">
	<h3>说几句吧：</h3>
    <div id="comment-form">
	<form target="hiddenwin" method="post" action="<?php echo route('home', ['class' => 'comment', 'action' => 'add', 'objectid' => $objectID, 'object_type' => $objectType]); ?>" >
		<textarea name="comment" rows="3" class="form-control" placeholder="三人行，必有我师。"></textarea>
        <br/>
		<input class="form-control input-sm" name="nickname" placeholder="如何称呼您？" style="width:200px;float:left;" />
        <div class="btn-toolbar list-toolbar" style="float:right;margin:0;">
          <a class="btn btn-primary btn-sm sys-btn-submit" data-loading="保存中..." ><span class="sys-btn-submit-str">提交</span></a>
        </div>
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
	</form>
    </div>
</div>
<div style="clear:both;"></div>
<?php if(isset($commentList) and is_array($commentList) and ! empty($commentList)): ?>
<?php
	//递归输出评论引用内容
	if( ! function_exists('showCommentReply'))
	{
		function showCommentReply($replyComment)
		{
			if( ! isset($replyComment[0]) or ! is_array($replyComment[0]) or empty($replyComment)) return '';
			$html = '';
			$value = $replyComment[0]; unset($replyComment[0]);
			$html .= '<div class="comment">';
			$nextValue = array_values($replyComment);
			if( ! empty($nextValue))
			{
				$html .= showCommentReply($nextValue);
			}
			if( ! empty($value))
			{
				$html .= '<div class="comment-content"><span class="blue f12"><span class="comment-nickname">'.($value['nickname'] == '__blog.author__' ? '<span style="color:red;">博主</span>' : $value['nickname']).'</span><span class="comment-date">于 '.showWriteTime($value['time']).'发布</span></span><br/><span>'.$value['content'].'</span></div>';
			}
			else
			{
				$html .= '<div class="comment-content"><span class="delete-reply-comment">此评论已经被删除了，请合理发言。</span></div>';
			}
			$html .= '</div>';
			return $html;
		}
	}
?>
<div id="detail-comment-list">
	<h3>评论内容：</h3>
</div>
	<?php foreach($commentList as $key => $value): ?>
	<div class="comment-main" id="comment-<?php echo $value['id']; ?>">
		<?php $replyComment = $value['reply_content']; ?>
		<?php if($replyComment !== false and is_array($replyComment) and ! empty($replyComment)): ?>
			<?php echo showCommentReply($replyComment); ?>
		<?php endif; ?>
		<div class="main">
			<span><?php echo $value['content']; ?></span>
			<div class="pull-right small comment-action" style="width:100%;text-align:right;">
				<span class="color-hui"><span class="comment-nickname"><?php echo $value['nickname'] == '__blog.author__' ? '<span style="color:red;">博主</span>' : $value['nickname']; ?></span>于 <?php echo showWriteTime($value['time']); ?>发布</span>
				<a data-reply-id="<?php echo $value['id']; ?>" class="comment-reply" href="javascript:void(0)">回复</a>
				<!--<a href="javascript:void(0)">支持</a>（<font id="support_3">0</font>）-->
			</div>
		</div>
        <div style="clear:both;"></div>
		<div style="display:block;overflow: hidden;margin-top:10px;margin-bottom:10px;" class="quick-comment"></div>
	</div>
    <div style="clear:both;"></div>
	<?php endforeach; ?>
    <script type="text/javascript">
        $('.comment-reply').on('click', function() {
            var commentstr = $('#comment-form').html();
            var replyid = $(this).attr('data-reply-id');
            $(this).parents('.comment-main').find('.quick-comment').html(commentstr);
            $(this).parents('.comment-main').find('.quick-comment form').append('<input name="replyid" type="hidden" value="'+replyid+'" />');
        });
    </script>
<?php endif; ?>