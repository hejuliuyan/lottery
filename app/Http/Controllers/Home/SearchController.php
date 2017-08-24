<?php namespace App\Http\Controllers\Home;

use App\Models\Home\Search as SearchModel;
use App\Services\Home\Search\Process;
use Request;

/**
 * 博客首页-搜索
 *
 * @author jiang <mylampblog@163.com>
 */
class SearchController extends Controller
{
    /**
     * 博客首页
     */
    public function index()
    {
        $object = new \stdClass();
        $object->keyword = Request::input('keyword');
        $searchProcess = new Process();
        $keywordUnicode = $searchProcess->prepareKeyword($object->keyword);
        $object->sphinxResult_ArticleIds = $searchProcess->sphinxSearch($keywordUnicode);
        $articleList = (new SearchModel())->activeArticleInfoBySearch($object);
        $page = '';
        if( ! empty($articleList)) $page = $articleList->setPath('')->appends(Request::all())->render();
        return view('home.index.index', compact('articleList', 'page', 'object'));
    }

}