<?php namespace App\Models\Admin;

use App\Models\Admin\Base;

/**
 * 文章标签关系表模型
 *
 * @author jiang
 */
class TagsRelation extends Base
{
    /**
     * 数据表名
     *
     * @var string
     */
    protected $table = 'article_tag_relation';

    /**
     * 可以被集体附值的表的字段
     *
     * @var string
     */
    protected $fillable = array('id', 'article_id', 'tag_id', 'time');

    /**
     * 批量删除
     */
    public function deleteTagsRelation(array $ids)
    {
        return $this->whereIn('article_id', $ids)->delete();
    }

    /**
     * 增加数据
     */
    public function addTagsArticleRelation($articleId, $tagId)
    {
        $isertData = ['article_id' => $articleId, 'tag_id' => $tagId, 'time' => time()];
        return $this->create($isertData);
    }

    /**
     * 批量增加数据
     */
    public function addTagsArticleRelations(array $datas)
    {
        return $this->insert($datas);
    }

    /**
     * 取得所有指定标签的文章数
     */
    public function articleNumsGroupByTagId(array $tagIds)
    {
        $tagIds = array_map('intval', $tagIds);
        $tags = implode(',', $tagIds);
        $prefix = \DB:: getTablePrefix();
        $sqlString = "SELECT COUNT(1) AS total, tag_id FROM `{$prefix}article_tag_relation` WHERE tag_id IN ($tags) GROUP BY tag_id;";
        return \DB::select($sqlString);
    }

}
