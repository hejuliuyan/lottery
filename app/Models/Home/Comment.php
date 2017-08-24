<?php namespace App\Models\Home;

use Illuminate\Database\Eloquent\Model;

/**
 * 评论表模型
 *
 * @author jiang
 */
class Comment extends Model
{
    /**
     * 表名
     *
     * @var string
     */
    protected $table = 'comment';

    /**
     * 代表文章的标识
     */
    CONST OBJECT_TYPE = 1;

    /**
     * 可以被集体附值的表的字段
     *
     * @var string
     */
    protected $fillable = array('id', 'object_type', 'object_id', 'nickname', 'content', 'reply_ids', 'time');

    /**
     * 关闭自动维护updated_at、created_at字段
     * 
     * @var boolean
     */
    public $timestamps = false;

    /**
     * 根据ID取得评论的内容
     * 
     * @return array
     */
    public function getContentByObjectId($objectId, $objectType = self::OBJECT_TYPE)
    {
        return $this->where('object_type', $objectType)->orderBy('id', 'desc')->where('object_id', $objectId)->get()->toArray();
    }

    /**
     * 根据ID组取得评论的内容
     * 
     * @return array
     */
    public function getContentsByObjectIds($objectIds, $objectType = self::OBJECT_TYPE)
    {
        return $this->where('object_type', $objectType)->whereIn('id', $objectIds)->get()->toArray();
    }

    /**
     * 根据ID取得评论的内容
     * 
     * @return array
     */
    public function getOneContentById($id)
    {
        return $this->where('id', $id)->first()->toArray();
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
