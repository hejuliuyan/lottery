<?php namespace App\Models\Admin;

use App\Models\Admin\Base;

/**
 * 文章副表模型
 *
 * @author jiang <mylampblog@163.com>
 */
class ContentDetail extends Base
{
    /**
     * 文章数据表名
     *
     * @var string
     */
    protected $table = 'article_detail';

    /**
     * 可以被集体附值的表的字段
     *
     * @var string
     */
    protected $fillable = array('id', 'user_id', 'article_id', 'content', 'time');

    /**
     * 增加文章
     * 
     * @param array $data 所需要插入的信息
     */
    public function addContentDetail(array $data)
    {
        return $this->create($data);
    }

    /**
     * 修改文章
     * 
     * @param array $data 所需要插入的信息
     */
    public function editContentDetail(array $data, $id)
    {
        return $this->where('article_id', '=', intval($id))->update($data);
    }

}
