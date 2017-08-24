<?php namespace App\Models\Admin;

use App\Models\Admin\Base;

/**
 * 操作日志表模型
 *
 * @author jiang
 */
class ActionLog extends Base
{
    /**
     * 操作日志数据表名
     *
     * @var string
     */
    protected $table = 'action_log';

    /**
     * 可以被集体附值的表的字段
     *
     * @var string
     */
    protected $fillable = array('id', 'username', 'user_id', 'ip', 'ip_adress', 'add_time', 'realname', 'content');
    
    /**
     * 增加操作日志
     * 
     * @param array $data 所需要插入的信息
     */
    public function add(array $data)
    {
        return $this->create($data);
    }

    /**
     * 取得所有的日志
     *
     * @return array
     */
    public function getAllByPage($data)
    {
        $currentQuery = $this->orderBy('id', 'desc');
        if(isset($data['username']) and ! empty($data['username'])) $currentQuery->where('username', $data['username']);
        if(isset($data['realname']) and ! empty($data['realname'])) $currentQuery->where('realname', $data['realname']);
        if(isset($data['timeFrom'], $data['timeTo']) and ! empty($data['timeFrom']) and ! empty($data['timeTo']))
        {
            $data['timeFrom'] = strtotime($data['timeFrom']);
            $data['timeTo'] = strtotime($data['timeTo']);
            $currentQuery->whereBetween('add_time', [$data['timeFrom'], $data['timeTo']]);
        }
        $result = $currentQuery->paginate(self::PAGE_NUMS);
        return $result;
    }

}
