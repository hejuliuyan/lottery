<?php namespace App\Http\Controllers\Admin\Blog;

use Request, Lang;
use App\Models\Admin\Tags as TagsModel;
use App\Services\Admin\Tags\Process;
use App\Libraries\Js;
use App\Http\Controllers\Admin\Controller;

/**
 * 文章标签相关
 *
 * @author jiang <mylampblog@163.com>
 */
class TagsController extends Controller
{
    /**
     * 显示标签列表
     */
    public function index()
    {
        $manager = new Process();
        $list = $manager->undeleteTagsList();
        $page = $list->setPath('')->appends(Request::all())->render();
        return view('admin.content.tags', compact('list', 'page'));
    }

    /**
     * 删除文章分类
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

}