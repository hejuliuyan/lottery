<?php namespace App\Http\Controllers\Admin\Blog;

use Request, Lang, Session;
use App\Models\Admin\Category as CategoryModel;
use App\Services\Admin\Category\Process as CategoryActionProcess;
use App\Libraries\Js;
use App\Http\Controllers\Admin\Controller;

/**
 * 文章分类相关
 *
 * @author jiang <mylampblog@163.com>
 */
class CategoryController extends Controller
{
    /**
     * 显示分类列表
     */
    public function index()
    {
        Session::flashInput(['http_referer' => Request::fullUrl()]);
        $manager = new CategoryActionProcess();
    	$list = $manager->unDeleteCategory();
    	$page = $list->setPath('')->appends(Request::all())->render();
        return view('admin.content.classify', compact('list', 'page'));
    }

    /**
     * 增加文章分类
     */
    public function add()
    {
    	if(Request::method() == 'POST') return $this->saveDatasToDatabase();
        $formUrl = R('common', 'blog.category.add');
        return view('admin.content.classifyadd', compact('formUrl'));
    }

    /**
     * 增加文章分类入库处理
     *
     * @access private
     */
    private function saveDatasToDatabase()
    {
        $data = (array) Request::input('data');
        $param = new \App\Services\Admin\Category\Param\CategorySave();
        $param->setAttributes($data);
        $manager = new CategoryActionProcess();
        if($manager->addCategory($param) !== false) return Js::locate(R('common', 'blog.category.index'), 'parent');
        return Js::error($manager->getErrorMessage());
    }

    /**
     * 编辑文章分类
     */
    public function edit()
    {
    	if(Request::method() == 'POST') return $this->updateDatasToDatabase();
        Session::flashInput(['http_referer' => Session::getOldInput('http_referer')]);
        $id = Request::input('id');
        if( ! $id or ! is_numeric($id)) return Js::error(Lang::get('common.illegal_operation'));
        $info = (new CategoryModel())->getOneById($id);
        if(empty($info)) return Js::error(Lang::get('category.not_found'));
        $formUrl = R('common', 'blog.category.edit');
        return view('admin.content.classifyadd', compact('info', 'formUrl', 'id'));
    }

    /**
     * 编辑文章分类入库处理
     *
     * @access private
     */
    private function updateDatasToDatabase()
    {
        $httpReferer = Session::getOldInput('http_referer');
        $data = Request::input('data');
        if( ! $data or ! is_array($data)) return Js::error(Lang::get('common.illegal_operation'));
        $param = new \App\Services\Admin\Category\Param\CategorySave();
        $param->setAttributes($data);
        $manager = new CategoryActionProcess();
        if($manager->editCategory($param)) 
        {
            $backUrl = ( ! empty($httpReferer)) ? $httpReferer : R('common', 'blog.category.index');
            return Js::locate($backUrl, 'parent');
        }
        return Js::error($manager->getErrorMessage());
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
        $manager = new CategoryActionProcess();
        if($manager->detele($id)) return responseJson(Lang::get('common.action_success'), true);
        return responseJson($manager->getErrorMessage());
    }

}