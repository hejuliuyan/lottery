<?php namespace App\Models\Admin;

use App\Models\Admin\Base;

/**
 * 用户组表模型
 *
 * @author jiang
 */
class Category extends Base
{
    /**
     * 用户组数据表名
     *
     * @var string
     */
    protected $table = 'article_classify';

    /**
     * 可以被集体附值的表的字段
     *
     * @var string
     */
    protected $fillable = array('id', 'name', 'sort', 'is_active', 'is_delete', 'time');

    /**
     * 文章分类未删除的标识
     */
    CONST IS_DELETE_NO = 1;

    CONST IS_DELETE_YES = 0;

    CONST IS_ACTIVE_YES = 1;
    
    /**
     * 取得未删除的分类信息
     *
     * @return array
     */
    public function unDeleteCategory()
    {
        $currentQuery = $this->orderBy('id', 'desc')->where('is_delete', self::IS_DELETE_NO)->paginate(15);
        return $currentQuery;
    }

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

    /**
     * 取得所有的分类信息
     *
     * @return array
     */
    public function allCategory()
    {
        return $this->get()->toArray();
    }

    /**
     * 增加文章分类
     * 
     * @param array $data 所需要插入的信息
     */
    public function addCategory(array $data)
    {
        return $this->create($data);
    }

    /**
     * 修改文章分类
     * 
     * @param array $data 所需要插入的信息
     */
    public function editCategory(array $data, $id)
    {
        return $this->where('id', '=', intval($id))->update($data);
    }

    /**
     * 取得指定ID信息
     * 
     * @param intval $id 用户组的ID
     * @return array
     */
    public function getOneById($id)
    {
        return $this->where('id', '=', intval($id))->first();
    }

    /**
     * 批量删除分类
     */
    public function deleteCategorys(array $data, array $ids)
    {
        return $this->whereIn('id', $ids)->update($data);
    }

}
