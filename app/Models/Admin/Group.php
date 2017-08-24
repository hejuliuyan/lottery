<?php namespace App\Models\Admin;

use App\Models\Admin\Base;

/**
 * 用户组表
 *
 * @author jiang
 */
class Group extends Base
{
    /**
     * 用户组数据表名
     *
     * @var string
     */
    protected $table = 'group';

    /**
     * 可以被集体附值的表的字段
     *
     * @var string
     */
    protected $fillable = array('id', 'group_name', 'mark', 'status', 'level');
    
    /**
     * 取得所有的用户组
     *
     * @return array
     */
    public function getAllGroupByPage()
    {
        $currentQuery = $this->orderBy('id', 'desc')->paginate(self::PAGE_NUMS);
        return $currentQuery;
    }

    /**
     * 取得所有的用户组
     *
     * @return array
     */
    public function getAllGroup()
    {
        return $this->all();
    }

    /**
     * 取得等级比当前用户等级低的用户组
     *
     * @return array
     */
    public function getGroupLevelLessThenCurrentUser($level)
    {
        return $this->where('level', '>', intval($level))->get()->toArray();
    }

    /**
     * 取得指定ID用户组信息
     * 
     * @param intval $id 用户组的ID
     * @return array
     */
    public function getOneGroupById($id)
    {
        return $this->where('id', '=', intval($id))->first();
    }

    /**
     * 增加用户组
     * 
     * @param array $data 所需要插入的信息
     */
    public function addGroup(array $data)
    {
        return $this->create($data);
    }
    
    /**
     * 修改用户组
     * 
     * @param array $data 所需要插入的信息
     */
    public function editGroup(array $data, $id)
    {
        return $this->where('id', '=', intval($id))->update($data);
    }
    
    /**
     * 删除用户组
     * 
     * @param array $id 权限功能的ID
     */
    public function deleteGroup(array $ids)
    {
        return $this->destroy($ids);
    }

    /**
     * 取得指定ID组的用户组信息
     * 
     * @param intval $ids 用户组的ID
     * @return array
     */
    public function getGroupInIds($ids)
    {
        if( ! is_array($ids)) return false;
        return $this->whereIn('id', $ids)->get()->toArray();
    }

}
