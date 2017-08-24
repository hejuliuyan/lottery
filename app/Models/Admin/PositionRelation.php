<?php namespace App\Models\Admin;

use App\Models\Admin\Base;

/**
 * 推荐位表和文章的关系模型
 *
 * @author jiang
 */
class PositionRelation extends Base
{
    /**
     * 推荐位数据表名
     *
     * @var string
     */
    protected $table = 'article_position_relation';

    /**
     * 可以被集体附值的表的字段
     *
     * @var string
     */
    protected $fillable = array('id', 'article_id', 'position_id', 'sort', 'time');
    
    /**
     * 批量根据文章id删除关联
     */
    public function deletePositionRelation(array $articleIds)
    {
        return $this->whereIn('article_id', $articleIds)->delete();
    }

    /**
     * 批量根据positionid删除关联
     */
    public function deletePositionRelationByPosId(array $posIds)
    {
        return $this->whereIn('position_id', $posIds)->delete();
    }

    /**
     * 批量根据id删除关联
     */
    public function deletePositionRelationById(array $prIds)
    {
        return $this->whereIn('id', $prIds)->delete();
    }

    /**
     * 关联文章的排序
     */
    public function sortRelation($prid, $sort)
    {
        return $this->where('id', '=', intval($prid))->update(array('sort' => $sort));
    }

    /**
     * 文章和推荐位的关联
     * 
     * @param  array $ids  文章的ID
     * @param  array $pids 推荐位的ID
     * @return return       true|false
     */
    public function articlePositionRelation($ids, $pids)
    {
        $prefix = \DB:: getTablePrefix();
        $sql = "INSERT IGNORE INTO {$prefix}article_position_relation VALUES (NULL, ?, ?, ?, ?)";
        $error = 0; $time = time();
        foreach($ids as $articleId)
        {
            foreach($pids as $positionId)
            {
                $data = [$articleId, $positionId, 0, $time];
                $result = \DB::insert($sql, $data);
                if($result === false) $error++;
            }
        }
        if($error !== 0) return false;
        return true;
    }

}
