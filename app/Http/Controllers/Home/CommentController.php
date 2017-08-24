<?php namespace App\Http\Controllers\Home;

use App\Services\Home\Comment\Process as CommentProcess;
use Request;
use App\Libraries\Js;

/**
 * 
 * @author jiang <mylampblog@163.com>
 */
class CommentController extends Controller
{
    /**
     * 评论的列表，用于异步加载
     */
    public function ls()
    {
        $objectId = (int) Request::input('objectid');
        $view = widget('Home.Common')->comment($objectId);
        return response($view);
    }

    /**
     * 评论
     */
    public function add()
    {
        $data['object_id'] = (int) Request::input('objectid');
        $data['object_type'] = (int) Request::input('object_type');
        $data['nickname'] = strip_tags(Request::input('nickname'));
        $data['content'] = strip_tags(Request::input('comment'));
        $data['replyid'] = (int) Request::input('replyid');

        $commentProcess = new CommentProcess();
        if($commentProcess->addComment($data) !== false) return response(Js::execute('window.parent.reloadComment();'));
        return response(Js::error($commentProcess->getErrorMessage()));
    }

}