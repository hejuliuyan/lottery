<?php namespace App\Http\Controllers\Admin\Blog;

use Request, Lang, Session;
use App\Models\Admin\Position as PositionModel;
use App\Models\Admin\Content as ContentModel;
use App\Services\Admin\Position\Process as PositionActionProcess;
use App\Libraries\Js;
use App\Http\Controllers\Admin\Controller;

/**
 * 文章推荐位相关
 *
 * @author jiang <mylampblog@163.com>
 */
class PositionController extends Controller
{
    /**
     * 显示推荐位列表
     */
    public function index()
    {
        Session::flashInput(['http_referer' => Request::fullUrl()]);
    	$list = (new PositionModel())->unDeletePosition();
    	$page = $list->setPath('')->appends(Request::all())->render();
        return view('admin.content.position', compact('list', 'page'));
    }

    /**
     * 增加推荐位分类
     */
    public function add()
    {
    	if(Request::method() == 'POST') return $this->saveDatasToDatabase();
        $formUrl = R('common', 'blog.position.add');
        return view('admin.content.positionadd', compact('formUrl'));
    }

    /**
     * 增加推荐位入库处理
     *
     * @access private
     */
    private function saveDatasToDatabase()
    {
        $data = (array) Request::input('data');
        $param = new \App\Services\Admin\Position\Param\PositionSave();
        $param->setAttributes($data);
        $manager = new PositionActionProcess();
        if($manager->addPosition($param) !== false) return Js::locate(R('common', 'blog.position.index'), 'parent');
        return Js::error($manager->getErrorMessage());
    }

    /**
     * 编辑文章推荐位
     */
    public function edit()
    {
    	if(Request::method() == 'POST') return $this->updateDatasToDatabase();
        Session::flashInput(['http_referer' => Session::getOldInput('http_referer')]);
        $id = Request::input('id');
        if( ! $id or ! is_numeric($id)) return Js::error(Lang::get('common.illegal_operation'));
        $info = (new PositionModel())->getOneById($id);
        if(empty($info)) return Js::error(Lang::get('position.not_found'));
        $formUrl = R('common', 'blog.position.edit');
        return view('admin.content.positionadd', compact('info', 'formUrl', 'id'));
    }

    /**
     * 编辑推荐位入库处理
     *
     * @access private
     */
    private function updateDatasToDatabase()
    {
        $httpReferer = Session::getOldInput('http_referer');
        $data = Request::input('data');
        if( ! $data or ! is_array($data)) return Js::error(Lang::get('common.illegal_operation'));
        $param = new \App\Services\Admin\Position\Param\PositionSave();
        $param->setAttributes($data);
        $manager = new PositionActionProcess();
        if($manager->editPosition($param))
        {
            $backUrl = ( ! empty($httpReferer)) ? $httpReferer : R('common', 'blog.position.index');
            return Js::locate($backUrl, 'parent');
        }
        return Js::error($manager->getErrorMessage());
    }

    /**
     * 删除文章推荐位
     *
     * @access public
     */
    public function delete()
    {
        if( ! $id = Request::input('id')) return responseJson(Lang::get('common.action_error'));
        if( ! is_array($id)) $id = array($id);
        $manager = new PositionActionProcess();
        if($manager->detele($id)) return responseJson(Lang::get('common.action_success'), true);
        return responseJson($manager->getErrorMessage());
    }

    /**
     * 查看文章关联
     */
    public function relation()
    {
        $positionId = (int) Request::input('position');
        $list = (new ContentModel())->positionArticle($positionId);
        $page = $list->setPath('')->appends(Request::all())->render();
        $positionInfo = (new PositionModel())->activePosition();
        return view('admin.content.positionarticle',
            compact('list', 'page', 'positionInfo', 'positionId')
        );
    }

    /**
     * 删除推荐位关联文章
     */
    public function delrelation()
    {
        if( ! $prid = Request::input('prid')) return responseJson(Lang::get('common.action_error'));
        if( ! is_array($prid)) $prid = array($prid);
        $manager = new PositionActionProcess();
        if($manager->delRelation($prid)) return responseJson(Lang::get('common.action_success'), true);
        return responseJson($manager->getErrorMessage());
    }

    /**
     * 排序关联的文章
     */
    public function sortrelation()
    {
        $data = (array) Request::input('data');
        foreach($data as $key => $value)
        {
            if(with(new PositionActionProcess())->sortRelation($value['prid'], $value['sort']) === false) $err = true;
        }
        if(isset($err)) return responseJson(Lang::get('common.action_error'));
        return responseJson(Lang::get('common.action_success'), true);
    }

}