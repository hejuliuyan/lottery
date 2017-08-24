<?php namespace App\Models\Admin;

use App\Models\Admin\Base;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * 文章表模型
 *
 * @author jiang
 */
class Content extends Base
{
    /**
     * 文章数据表名
     *
     * @var string
     */
    protected $table = 'article_main';

    /**
     * 可以被集体附值的表的字段
     *
     * @var string
     */
    protected $fillable = array('id', 'user_id', 'title', 'summary', 'head_pic', 'little_head_pic', 'write_time', 'is_delete', 'status');

    /**
     * 文章未删除的标识
     */
    CONST IS_DELETE_NO = 1;

    /**
     * 文章删除的标识
     */
    CONST IS_DELETE_YES = 0;
    
    /**
     * 取得未删除的信息
     *
     * @return array
     * @todo 数据量多时，查找属于指定分类，推荐位，标签三个的文章时使用redis集合交集处理，避免查询消耗。
     */
    public function AllContents($search = [])
    {
        $prefix = \DB:: getTablePrefix();
        $currentQuery = $this->select(\DB::raw('distinct '.$prefix.'article_main.*, '.$prefix.'users.name, '.'group_concat(DISTINCT '.$prefix.'article_classify.name) as classnames'))
                             ->leftJoin('users', 'article_main.user_id', '=', 'users.id')
                             ->leftJoin('article_classify_relation', 'article_main.id', '=', 'article_classify_relation.article_id')
                             ->leftJoin('article_classify', 'article_classify_relation.classify_id', '=', 'article_classify.id')
                             ->leftJoin('article_position_relation', 'article_main.id', '=', 'article_position_relation.article_id')
                             ->leftJoin('article_tag_relation', 'article_main.id', '=', 'article_tag_relation.article_id')
                             ->orderBy('article_main.id', 'desc')->where('article_main.is_delete', self::IS_DELETE_NO)
                             ->groupBy('article_main.id');
        if(isset($search['keyword']) && ! empty($search['keyword'])) $currentQuery->where('article_main.title', 'like', "%{$search['keyword']}%");
        if(isset($search['username']) && ! empty($search['username'])) $currentQuery->where('article_main.user_id', $search['username']);
        if(isset($search['classify']) && ! empty($search['classify'])) $currentQuery->where('article_classify_relation.classify_id', $search['classify']);
        if(isset($search['position']) && ! empty($search['position'])) $currentQuery->where('article_position_relation.position_id', $search['position']);
        if(isset($search['tag']) && ! empty($search['tag'])) $currentQuery->where('article_tag_relation.tag_id', $search['tag']);
        if(isset($search['timeFrom'], $search['timeTo']) and ! empty($search['timeFrom']) and ! empty($search['timeTo']))
        {
            $search['timeFrom'] = strtotime($search['timeFrom']);
            $search['timeTo'] = strtotime($search['timeTo']);
            $currentQuery->whereBetween('article_main.write_time', [$search['timeFrom'], $search['timeTo']]);
        }
        $total = count($currentQuery->get()->all());
        $currentQuery->forPage(
            $page = Paginator::resolveCurrentPage(),
            $perPage = self::PAGE_NUMS
        );
        $result = $currentQuery->get()->all();
        return new LengthAwarePaginator($result, $total, $perPage, $page, [
            'path' => Paginator::resolveCurrentPath()
        ]);
    }

    /**
     * 取得未删除的信息
     *
     * @return array
     * @todo 数据量多时，查找属于指定分类，推荐位，标签三个的文章时使用redis集合交集处理，避免查询消耗。
     */
    public function positionArticle($positionId)
    {
        $currentQuery = $this->select(array('article_position_relation.id', 'article_main.title', 'article_position_relation.sort', 'article_position_relation.article_id'))
                             ->leftJoin('article_position_relation', 'article_main.id', '=', 'article_position_relation.article_id')
                             ->where('article_position_relation.position_id', $positionId)
                             ->where('article_main.is_delete', self::IS_DELETE_NO)
                             ->orderBy('article_position_relation.sort', 'desc');
        return $currentQuery->paginate(self::PAGE_NUMS);
    }

    /**
     * 增加文章
     * 
     * @param array $data 所需要插入的信息
     */
    public function addContent(array $data)
    {
        return $this->create($data);
    }

    /**
     * 修改文章
     * 
     * @param array $data 所需要插入的信息
     */
    public function editContent(array $data, $id)
    {
        return $this->where('id', '=', intval($id))->update($data);
    }

    /**
     * 取得指定ID信息
     * 
     * @param intval $id 文章的ID
     * @return array
     */
    public function getOneById($id)
    {
        return $this->where('id', '=', intval($id))->first();
    }

    /**
     * 批量软删除
     */
    public function solfDeleteContent(array $data, array $ids)
    {
        return $this->whereIn('id', $ids)->update($data);
    }

    /**
     * 取得一篇文章主表和副表的信息
     *
     * @param int $articleId 文章的ID
     * @return array
     */
    public function getContentDetailByArticleId($articleId)
    {
        $articleId = (int) $articleId;
        $currentQuery = $this->select(array('article_main.*','article_detail.content'))
                ->leftJoin('article_detail', 'article_main.id', '=', 'article_detail.article_id')
                ->where('article_main.id', $articleId)->first();
        $info = $currentQuery->toArray();
        return $info;
    }

    /**
     * 取得文章所属的标签
     * 
     * @param int $articleId 文章的ID
     * @return  array 文章的分类
     */
    public function getArticleClassify($articleId)
    {
        $articleId = (int) $articleId;
        $currentQuery = $this->from('article_classify_relation')->select(array('article_classify_relation.classify_id','article_classify.name'))
                ->leftJoin('article_classify', 'article_classify_relation.classify_id', '=', 'article_classify.id')
                ->where('article_classify_relation.article_id', $articleId)->get();
        $classify = $currentQuery->toArray();
        return $classify;
    }

    /**
     * 取得文章所属的标签
     * 
     * @param int 文章的ID
     * @return  array 文章的标签
     */
    public function getArticleTag($articleId)
    {
        $articleId = (int) $articleId;
        $currentQuery = $this->from('article_tag_relation')->select(array('article_tag_relation.tag_id', 'article_tags.name'))
              ->leftJoin('article_tags', 'article_tag_relation.tag_id', '=', 'article_tags.id')
              ->where('article_tag_relation.article_id', $articleId)->get();
        $tags = $currentQuery->toArray();
        return $tags;
    }

}
