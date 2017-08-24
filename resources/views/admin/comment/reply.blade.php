<?php if(isset($comment) and is_array($comment) and ! empty($comment)): ?>
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
<div class="artitle-comment-reply-main">
    <?php $replyComment = $comment['reply_content']; ?>
    <?php if($replyComment !== false and is_array($replyComment) and ! empty($replyComment)): ?>
        <?php echo showCommentReply($replyComment); ?>
    <?php endif; ?>
    <div class="main">
        <span><?php echo $comment['content']; ?></span>
        <div class="pull-right small comment-action" style="width:100%;text-align:right;">
            <span class="color-hui"><span class="comment-nickname"><?php echo $comment['nickname'] == '__blog.author__' ? '<span style="color:red;">博主</span>' : $comment['nickname']; ?></span>于 <?php echo showWriteTime($comment['time']); ?>发布</span>
        </div>
    </div>
    <div style="clear:both;"></div>
    <div style="display:block;overflow: hidden;margin-top:10px;margin-bottom:10px;" class="quick-comment">
        <div id="comment-form">
            <form id="article-comment-reply-form" target="hiddenwin" method="post" action="<?php echo R('common', 'blog.comment.reply', ['objectid' => $comment['object_id'], 'object_type' => $objectType]); ?>" >
                <textarea name="comment" rows="3" class="form-control" placeholder="填写回复内容"></textarea>
                <input name="nickname" type="hidden" value="__blog.author__" />
                <input name="replyid" type="hidden" value="<?php echo $comment['id']; ?>" />
            </form>
        </div>
    </div>
</div>
<?php endif; ?>