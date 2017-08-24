<?php

namespace App\Http\Controllers\Admin\Foundation;

use App\Http\Controllers\Admin\Controller;
use App\Models\Admin\ActionLog as ActionLogModel;
use Request, Lang;
use App\Libraries\Js;

/**
 * 操作日志
 *
 * @author jiang <mylampblog@163.com>
 */
class LogController extends Controller
{
    /**
     * 列表
     *
     * @access public
     */
    public function action()
    {
        $data['username'] = strip_tags(Request::input('username'));
        $data['realname'] = strip_tags(Request::input('realname'));
        $data['timeFrom'] = strip_tags(Request::input('time_from'));
        $data['timeTo'] = strip_tags(Request::input('time_to'));

        $model = new ActionLogModel();
        $list = $model->getAllByPage($data);
        $page = $list->setPath('')->appends(Request::all())->render();
        return view('admin.log.index', compact('list', 'page', 'data'));
    }
    
}