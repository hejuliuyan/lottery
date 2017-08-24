<?php namespace App\Models\Home;

use Illuminate\Database\Eloquent\Model;
use App\Models\Home\SearchDict as SearchDictModel;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * 文章表模型
 *
 * @author jiang
 */
class Search extends Model
{
    /**
     * 文章未删除的标识
     */
    CONST IS_DELETE_NO = 1;

    /**
     * 文章发布的标识
     */
    CONST STATUS_YES = 1;

    /**
     * 文章数据表名
     *
     * @var string
     */
    protected $table = 'article_main';

    /**
     * 表前缀
     * 
     * @var string
     */
    private $prefix;

    /**
     * dict model object
     * 
     * @var object
     */
    private $dictModelObject;

    /**
     * 临时保存，避免多次查询
     * 
     * @var [type]
     */
    private $dictDataCache;

    /**
     * 搜索查询取得文章列表信息
     * 
     * @return array
     */
    public function activeArticleInfoBySearch($object)
    {
        //\DB::connection()->enableQueryLog();
        if( ! isset($object->sphinxResult_ArticleIds) or ! is_array($object->sphinxResult_ArticleIds)) return [];
        $this->prefix = \DB:: getTablePrefix();
        $currentQuery = $this->select(\DB::raw($this->prefix.'article_main.*, group_concat(DISTINCT '.$this->prefix.'article_classify.name) as classnames, group_concat(DISTINCT '.$this->prefix.'article_tags.name) as tagsnames'))
                        ->leftJoin('article_classify_relation', 'article_classify_relation.article_id', '=', 'article_main.id')
                        ->leftJoin('article_classify', 'article_classify_relation.classify_id', '=', 'article_classify.id')
                        ->leftJoin('article_tag_relation', 'article_tag_relation.article_id', '=', 'article_main.id')
                        ->leftJoin('article_tags', 'article_tag_relation.tag_id', '=', 'article_tags.id')
                        ->where('article_main.is_delete', self::IS_DELETE_NO)->where('article_main.status', self::STATUS_YES)
                        ->whereIn('article_main.id', $object->sphinxResult_ArticleIds)
                        ->groupBy('article_main.id')
                        ->orderBy('article_main.id', 'desc');

        $total = $currentQuery->get()->count();
        $currentQuery->forPage(
            $page = Paginator::resolveCurrentPage(),
            $perPage = 20
        );

        $data = $currentQuery->get()->all();
        //$queries = \DB::getQueryLog();
        //dd($total, $queries);

        return new LengthAwarePaginator($data, $total, $perPage, $page, [
            'path' => Paginator::resolveCurrentPath()
        ]);
    }



}
