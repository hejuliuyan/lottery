<?php namespace App\Http\Controllers\Admin\Blog;

use Request, Lang;
use App\Models\Admin\Comment as CommentModel;
use App\Services\Admin\Comment\Process;
use App\Libraries\Js;
use App\Http\Controllers\Admin\Controller;

/**
 * 文章评论相关
 *
 * @author jiang <mylampblog@163.com>
 */
class CommentController extends Controller
{
    /**
     * 显示评论列表
     */
    public function index()
    {
        $list = with(new CommentModel())->allComment();
        $page = $list->setPath('')->appends(Request::all())->render();
        return view('admin.comment.index', compact('list', 'page'));
    }

    /**
     * 删除文章评论
     *
     * @access public
     */
    public function delete()
    {
        if( ! $id = Request::input('id')) return responseJson(Lang::get('common.action_error'));
        if( ! is_array($id)) $id = array($id);
        $id = array_map('intval', $id);
        $manager = new Process();
        if($manager->delete($id)) return responseJson(Lang::get('common.action_success'), true);
        return responseJson($manager->getErrorMessage());
    }

    /**
     * 评论
     *
     * @todo 和前台的使用通过的接口来，不用写两套代码。
     */
    public function reply()
    {
        if(Request::method() == 'POST') return $this->commentReply();
        $commentId = (int) Request::input('commentid');
        $manager = new Process();
        $view = $manager->getReplyInfo($commentId);
        return response($view);
    }

    /**
     * 回复评论
     */
    private function commentReply()
    {
        $data['object_id'] = (int) Request::input('objectid');
        $data['object_type'] = (int) Request::input('object_type');
        $data['nickname'] = strip_tags(Request::input('nickname'));
        $data['content'] = strip_tags(Request::input('comment'));
        $data['replyid'] = (int) Request::input('replyid');
        $manager = new Process();
        $insertId = $manager->addComment($data);
        if($insertId !== false) return Js::execute('window.parent.loadComment('.$insertId.');');
        return Js::error($manager->getErrorMessage());
    }

}