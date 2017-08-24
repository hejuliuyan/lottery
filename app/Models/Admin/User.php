<?php namespace App\Models\Admin;

use App\Models\Admin\Base;

/**
 * 用户表模型
 */
class User extends Base
{
    /**
     * 数据表名
     * 
     * @var string
     */
    protected $table = 'users';

    /**
     * 可以被集体附值的表的字段
     *
     * @var string
     */
    protected $fillable = array('id', 'name', 'password', 'group_id', 'realname', 'token',
                                'add_time', 'modify_time', 'mobile', 'status', 'mark',
                                'last_login_ip', 'last_login_time'
                            );

    /**
     * 取得用户的信息，根据用户名
     * 
     * @param string $username 用户名
     */
    public function InfoByName($username)
    {
        return $this->where('name', $username)->first();
    }

    /**
     * 取得所有的用户
     *
     * @return array
     */
    public function getAllUser($param = [])
    {
        $query = $this->leftJoin('group', 'users.group_id', '=', 'group.id');
        if(isset($param['group_id'])) $query->where('users.group_id', '=', intval($param['group_id']));
        $nums = isset($param['nums']) ? $param['nums'] : self::PAGE_NUMS;
        $currentQuery = $query->select(array('*','users.id as id'))->orderBy('users.id', 'desc')->paginate($nums);
        return $currentQuery;
    }

    /**
     * 取得所有的用户的名字和id
     *
     * @return array
     */
    public function userNameList()
    {
        return $this->get()->toArray();
    }

    /**
     * 增加用户
     * 
     * @param array $data 所需要插入的信息
     */
    public function addUser(array $data)
    {
        return $this->create($data);
    }
    
    /**
     * 修改用户
     * 
     * @param array $data 所需要插入的信息
     */
    public function editUser(array $data, $id)
    {
        return $this->where('id', '=', intval($id))->update($data);
    }
    
    /**
     * 删除用户
     * 
     * @param array $id 权限功能的ID
     */
    public function deleteUser(array $ids)
    {
        return $this->destroy($ids);
    }
    
    /**
     * 取得指定ID用户信息
     * 
     * @param intval $id 用户的ID
     * @return array
     */
    public function getOneUserById($id)
    {
        return $this->where('id', '=', intval($id))->first();
    }
    
    /**
     * 取得指定用户名的信息
     * 
     * @param string $name 用户名
     * @return array
     */
    public function getOneUserByName($name)
    {
        return $this->where('name', '=', $name)->first();
    }

    /**
     * 更新最后登录时间
     * 
     * @param int $userId 登录用户的ID
     * @param int $data 更新的数据
     */
    public function updateLastLoginInfo($userId, $data)
    {
        $updateDatas = [];
        if(isset($data['last_login_time'])) $updateDatas['last_login_time'] = $data['last_login_time'];
        if(isset($data['last_login_ip'])) $updateDatas['last_login_ip'] = $data['last_login_ip'];
        if(empty($updateDatas)) return false;
        return $this->where('id', '=', intval($userId))->update($updateDatas);
    }

    /**
     * 取得指定ID组的用户信息
     * 
     * @param intval $ids 用户的ID
     * @return array
     */
    public function getUserInIds($ids)
    {
        if( ! is_array($ids)) return false;
        return $this->whereIn('id', $ids)->get()->toArray();
    }

}
