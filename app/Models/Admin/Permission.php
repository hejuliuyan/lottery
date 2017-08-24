<?php namespace App\Models\Admin;

use App\Models\Admin\Base;

/**
 * 权限表模型
 *
 * @author jiang 2016-5-19 9:33
 */
class Permission extends Base
{
    /**
     * 权限表名
     * 
     * @var string
     */
    protected $table = 'permission';

    /**
     * 定义可以集体赋值的字段
     * 
     * @var array
     */
    protected $fillable = array('id', 'module', 'class', 'action', 'name', 'display', 'pid', 'add_time', 'mark', 'level', 'sort');
    
    /**
     * 取得所有的权限信息
     * 
     * @return array
     */
    public function getAllAccessPermissionByPage()
    {
        $currentQuery = $this->orderBy('sort', 'desc')->orderBy('id', 'desc')->paginate(12);
        return $currentQuery;
    }
    
    /**
     * 取得所有的权限信息
     * 
     * @return array
     */
    public function getAllAccessPermission()
    {
        return $this->orderBy('sort', 'desc')->orderBy('id', 'asc')->get()->toArray();
    }

    /**
     * 增加权限功能
     * 
     * @param array $data 所需要插入的信息
     */
    public function addPermission(array $data)
    {
        return $this->create($data);
    }

    /**
     * 修改权限功能
     * 
     * @param array $data 所需要插入的信息
     */
    public function editPermission(array $data, $id)
    {
        return $this->where('id', '=', intval($id))->update($data);
    }
    
    /**
     * 删除权限功能
     * 
     * @param array $id 权限功能的ID
     */
    public function deletePermission(array $ids)
    {
        return $this->destroy($ids);
    }

    /**
     * 取得指定ID权限功能信息
     * 
     * @param intval $id 权限功能的ID
     * @return array
     */
    public function getOnePermissionById($id)
    {
        return $this->where('id', '=', intval($id))->first();
    }
    
    /**
     * 对指定ID的功能进行排序
     * 
     * @param array $aclId 权限功能的ID
     * @param array $sort 排序值
     * @return boolean
     */
    public function sortPermission($aclId, $sort)
    {
        return $this->where('id', '=', intval($aclId))->update(array('sort' => $sort));
    }
    
    /**
     * 检测记录是否已经存在，用于增加来修该权限的时候的检测
     * 
     * @param array $module 模块
     * @param array $class 类
     * @param array $function 函数
     * @param array $checkSelf 当编辑的时候是否检测自己
     * @return boolean
     */
    public function checkIfIsExists($module, $class, $function, $checkSelf = true, $selfId = false)
    {
        $search = $this->where('module', '=', $module)->where('class', '=', $class)->where('action', '=', $function);
        if( ! $checkSelf) $search->where('id', '!=', intval($selfId));
        return $search->first();
    }

    /**
     * 查找指定ID的子项目
     * 
     * @return array
     */
    public function getSon($ids)
    {
        return $this->whereIn('pid', $ids)->get()->toArray();
    }
    
}
