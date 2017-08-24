<?php namespace App\Models\Home;

use Illuminate\Database\Eloquent\Model;

/**
 * 文章分类表模型
 *
 * @author jiang
 */
class Classify extends Model
{
    /**
     * 用户组数据表名
     *
     * @var string
     */
    protected $table = 'article_classify';
    
    /**
     * 文章分类未删除的标识
     */
    CONST IS_DELETE_NO = 1;

    CONST IS_DELETE_YES = 0;

    CONST IS_ACTIVE_YES = 1;

    /**
     * 取得未删除，已激活的分类信息
     *
     * @return array
     */
    public function activeCategory()
    {
        $currentQuery = $this->orderBy('id', 'desc')->where('is_delete', self::IS_DELETE_NO)->where('is_active', self::IS_ACTIVE_YES);
        return $currentQuery->get()->toArray();
    }

}
