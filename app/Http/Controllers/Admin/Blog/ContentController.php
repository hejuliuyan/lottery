<?php namespace App\Http\Controllers\Admin\Blog;

use Request, Lang, Session;
use App\Models\Admin\Content as ContentModel;
use App\Models\Admin\Category as CategoryModel;
use App\Models\Admin\User as UserModel;
use App\Models\Admin\Position as PositionModel;
use App\Models\Admin\Tags as TagsModel;
use App\Services\Admin\Content\Process as ContentActionProcess;
use App\Libraries\Js;
use App\Http\Controllers\Admin\Controller;

/**
 * 登录相关
 *
 * @author jiang <mylampblog@163.com>
 */
class ContentController extends Controller
{
    /**
     * 显示首页
     */
    public function index()
    {
        Session::flashInput(['http_referer' => Request::fullUrl()]);

        $search['keyword'] = strip_tags(Request::input('keyword'));
        $search['username'] = strip_tags(Request::input('username'));
        $search['classify'] = (int) Request::input('classify');
        $search['position'] = (int) Request::input('position');
        $search['tag'] = (int) Request::input('tag');
        $search['timeFrom'] = strip_tags(Request::input('time_from'));
        $search['timeTo'] = strip_tags(Request::input('time_to'));

        $list = (new ContentModel())->AllContents($search);
        $page = $list->setPath('')->appends(Request::all())->render();
        $users = (new UserModel())->userNameList();
        $classifyInfo = (new CategoryModel())->activeCategory();
        $positionInfo = (new PositionModel())->activePosition();
        $tagInfo = (new TagsModel())->activeTags();
        return view('admin.content.index',
            compact('list', 'page', 'users', 'classifyInfo', 'positionInfo', 'tagInfo', 'search')
        );
    }

    /**
     * 增加文章
     *
     * @access public
     */
    public function add()
    {
        if(Request::method() == 'POST') return $this->saveDatasToDatabase();
        $classifyInfo = (new CategoryModel())->activeCategory();
        $formUrl = R('common', 'blog.content.add');
        return view('admin.content.add', compact('formUrl', 'classifyInfo'));
    }
    
    /**
     * 增加文章入库处理
     *
     * @access private
     */
    private function saveDatasToDatabase()
    {
        $data = (array) Request::input('data');
        $data['tags'] = explode(';', $data['tags']);
        $param = new \App\Services\Admin\Content\Param\ContentSave();
        $param->setAttributes($data);
        $manager = new ContentActionProcess();
        if($manager->addContent($param) !== false) return Js::locate(R('common', 'blog.content.index'), 'parent');
        return Js::error($manager->getErrorMessage());
    }

    /**
     * 删除文章
     *
     * @access public
     */
    public function delete()
    {
        if( ! $id = Request::input('id')) return responseJson(Lang::get('common.action_error'));
        if( ! is_array($id)) $id = array($id);
        $manager = new ContentActionProcess();
        if($manager->detele($id)) return responseJson(Lang::get('common.action_success'), true);
        return responseJson($manager->getErrorMessage());
    }

    /**
     * 编辑文章
     *
     * @access public
     */
    public function edit()
    {
        if(Request::method() == 'POST') return $this->updateDatasToDatabase();
        Session::flashInput(['http_referer' => Session::getOldInput('http_referer')]);
        $id = Request::input('id');
        if( ! $id or ! is_numeric($id)) return Js::error(Lang::get('common.illegal_operation'));
        $info = (new ContentModel())->getContentDetailByArticleId($id);
        if(empty($info)) return Js::error(Lang::get('content.not_found'));
        $classifyInfo = (new CategoryModel())->activeCategory();
        $info = $this->joinArticleClassify($info);
        $info = $this->joinArticleTags($info);
        $formUrl = R('common', 'blog.content.edit');
        return view('admin.content.add', compact('info', 'formUrl', 'id', 'classifyInfo'));
    }

    /**
     * 取回当前文章的所属分类
     * 
     * @param  array $articleInfo 当前文章的信息
     * @return array              整合后的当前文章信息
     */
    private function joinArticleClassify($articleInfo)
    {
        $classifyInfo = (new ContentModel())->getArticleClassify($articleInfo['id']);
        $classifyIds = [];
        foreach ($classifyInfo as $key => $value)
        {
            $classifyIds[] = $value['classify_id'];
        }
        $articleInfo['classifyInfo'] = $classifyIds;
        return $articleInfo;
    }

    /**
     * 取回当前文章的所属标签
     * 
     * @param  array $articleInfo 当前文章的信息
     * @return array              整合后的当前文章信息
     */
    private function joinArticleTags($articleInfo)
    {
        $tagsInfo = (new ContentModel())->getArticleTag($articleInfo['id']);
        $tagsIds = [];
        foreach ($tagsInfo as $key => $value)
        {
            $tagsIds[] = $value['name'];
        }
        $articleInfo['tagsInfo'] = $tagsIds;
        return $articleInfo;
    }
    
    /**
     * 编辑文章入库处理
     *
     * @access private
     */
    private function updateDatasToDatabase()
    {
        $httpReferer = Session::getOldInput('http_referer');
        $data = (array) Request::input('data');
        $id = intval(Request::input('id'));
        $data['tags'] = explode(';', $data['tags']);
        $param = new \App\Services\Admin\Content\Param\ContentSave();
        $param->setAttributes($data);
        $manager = new ContentActionProcess();
        if($manager->editContent($param, $id) !== false)
        {
            $backUrl = ( ! empty($httpReferer)) ? $httpReferer : R('common', 'blog.content.index');
            return Js::locate($backUrl, 'parent');
        }
        return Js::error($manager->getErrorMessage());
    }

    /**
     * 把文章关联到推荐位
     */
    public function position()
    {
        $ids = array_map('intval', (array) Request::input('ids'));
        $pids = array_map('intval', (array) Request::input('pids'));
        $manager = new ContentActionProcess();
        if($manager->articlePositionRelation($ids, $pids) !== false)
        {
            return responseJson(Lang::get('common.action_success'), true);
        }
        return responseJson(Lang::get('common.action_error'));
    }

}