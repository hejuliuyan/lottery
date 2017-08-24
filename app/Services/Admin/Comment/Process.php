<?php namespace App\Services\Admin\Comment;

use Lang;
use App\Models\Admin\Comment as CommentModel;
use App\Services\Admin\BaseProcess;
use App\Services\Admin\Comment\Validate\Comment as CommentValidate;

/**
 * 文章评论处理
 *
 * @author jiang <mylampblog@163.com>
 */
class Process extends BaseProcess
{
    /**
     * 评论模型
     * 
     * @var object
     */
    private $commentModel;

    /**
     * 初始化
     *
     * @access public
     */
    public function __construct()
    {
        if( ! $this->commentModel) $this->commentModel = new CommentModel();
    }

    /**
     * 删除评论
     * 
     * @param array $ids
     * @access public
     * @return boolean true|false
     */
    public function delete($ids)
    {
        if( ! is_array($ids)) return false;
        if($this->commentModel->deleteComment($ids) !== false) return true;
        return $this->setErrorMsg(Lang::get('common.action_error'));
    }

    /**
     * 取得回复评论的详细的信息
     *
     * @param int $commentId 评论的id
     */
    public function getReplyInfo($commentId, $objectType = \App\Models\Admin\Comment::OBJECT_TYPE)
    {
        $comment = $this->commentModel->getCommentById($commentId);
        $replyIds = $this->prepareReplyIds($comment);
        $replyComments = $this->commentModel->getCommentsByObjectIds($replyIds, $objectType);
        $comment = $this->joinReplyComments($comment, $replyComments);
        return view('admin.comment.reply', compact('comment', 'objectType'));
    }

    /**
     * 增加评论
     */
    public function addComment($data)
    {
        $validate = new CommentValidate();
        if( ! $validate->add($data)) return $this->setErrorMsg($validate->getErrorMessage());
        if( ! empty($data['replyid']))
        {
            $replyInfo = $this->commentModel->getCommentById($data['replyid']);
            if(empty($replyInfo)) return $this->setErrorMsg(Lang::get('comment.reply_comment_not_exist'));
            $data['reply_ids'] = ! empty($replyInfo['reply_ids']) ? $data['replyid'].','.$replyInfo['reply_ids'] : $data['replyid'];
            unset($data['replyid']);
        }
        $data['time'] = time();
        $result = $this->commentModel->addComment($data);
        if($result === false) return $this->setErrorMsg(Lang::get('comment.action_error'));
        return $result->id;
    }

    /**
     * 整理相关的评论Id
     *
     * @param array $comment 评论的信息
     */
    private function prepareReplyIds($comment)
    {
        if( ! is_array($comment) or ! isset($comment['reply_ids']) or empty($comment['reply_ids'])) return [];
        $replyIds = [];
        $ids = explode(',', $comment['reply_ids']);
        $replyIds = array_merge($replyIds, $ids);
        return array_values(array_unique($replyIds));
    }

    /**
     * 附加评论所评论的内容到评论中
     */
    private function joinReplyComments($comment, $replyComments)
    {
        if( ! is_array($comment)) return [];
        $comment['reply_content'] = $this->findReplyContents($comment['reply_ids'], $replyComments);
        return $comment;
    }

    /**
     * 从相关评论中根据key拿回详细的信息
     */
    private function findReplyContents($replyIdsString, $replyComments)
    {
        if( ! is_array($replyComments) or empty($replyIdsString)) return [];
        $replyIds = explode(',', $replyIdsString);
        $result = [];
        foreach($replyIds as $replyIdKey => $replyIdValue)
        {
            $find = [];
            foreach($replyComments as $replyCommentsKey => $replyCommentsValue)
            {
                if($replyIdValue == $replyCommentsValue['id'])
                {
                    $find = $replyCommentsValue;
                    break;
                }
            }
            $result[] = $find;
        }
        return $result;
    }

}