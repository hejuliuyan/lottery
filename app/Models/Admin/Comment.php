<?php namespace App\Models\Admin;

use App\Models\Admin\Base;

/**
 * 文章评论模型
 *
 * @author jiang <mylampblog@163.com>
 */
class Comment extends Base
{
    /**
     * 文章数据表名
     *
     * @var string
     */
    protected $table = 'comment';

    /**
     * 可以被集体附值的表的字段
     *
     * @var string
     */
    protected $fillable = array('id', 'object_type', 'object_id', 'nickname', 'content', 'reply_ids', 'time');

    /**
     * 代表文章的标识
     */
    CONST OBJECT_TYPE = 1;

    /**
     * 取得评论信息
     *
     * @return array
     */
    public function allComment()
    {
        $currentQuery = $this->where('object_type', self::OBJECT_TYPE)->orderBy('id', 'desc')->paginate(self::PAGE_NUMS);
        return $currentQuery;
    }

    /**
     * 删除文章评论
     * @param  array $ids 评论的id
     * @return boolean
     */
    public function deleteComment(array $ids)
    {
        return $this->destroy($ids);
    }

    /**
     * 根据ID取得评论的内容
     * 
     * @return array
     */
    public function getCommentById($id)
    {
        return $this->where('id', $id)->first()->toArray();
    }

    /**
     * 根据ID组取得评论的内容
     * 
     * @return array
     */
    public function getCommentsByObjectIds($objectIds, $objectType = self::OBJECT_TYPE)
    {
        return $this->where('object_type', $objectType)->whereIn('id', $objectIds)->get()->toArray();
    }

    /**
     * 增加评论
     * 
     * @param array $data 所需要插入的信息
     */
    public function addComment(array $data)
    {
        return $this->create($data);
    }

}
