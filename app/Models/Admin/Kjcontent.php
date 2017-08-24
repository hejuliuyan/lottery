<?php namespace App\Models\Admin;

use App\Models\Admin\Base;
use DB;
use Log;

/**
 * 文章表模型
 *
 * @author wang
 */
class Kjcontent extends Base
{

    /**
     * 获取开奖结果列表
     *
     * @param array $data 所需要插入的信息
     */
    public function lists($types = 1)
    {
        //$data = DB::table('cp_draw_result')->select('id','name', 'num','numbers')->get();
        $data = DB::select('select id, name, num, numbers, types, from_unixtime(notice_date) as notice_date, from_unixtime(deadline) as deadline from cp_draw_result where active=1 order by id desc');
        //$data = DB::table('cp_draw_result')->orderBy('id','desc')->paginate(3);
        return $data;
        //return $this->create($data);
    }

    /**
     * 读取信息
     *
     * @param array $data 所需要插入的信息
     */
    public function edit($data)
    {
        //$users = DB::table('cp_draw_result')->where('id', $data['id'])->get();
        $users = DB::select('select id, name, num, numbers, types, from_unixtime(notice_date) as notice_date, from_unixtime(deadline) as deadline from cp_draw_result where id =' . $data['id'] . '');

        if ($users[0]->types == 1) {
            $num = $users[0]->numbers;
            $num = explode('|', $num);
            $num_q = explode(',', $num[0]);
            $num_h = explode(',', $num[1]);
            $users['num_q'] = $num_q;
            $users['num_h'] = $num_h;

            return $users;
        }

        if ($users[0]->types == 2) {
            $num = $users[0]->numbers;
            $num = explode(',', $num);
            $users['new_num'] = $num;

            return $users;
        }

        if ($users[0]->types == 3) {
            $num = $users[0]->numbers;
            $num = explode(',', $num);
            $users['new_num'] = $num;

            return $users;
        }

        if ($users[0]->types == 4) {
            $num = $users[0]->numbers;
            $num = explode(',', $num);
            $users['new_num'] = $num;

            return $users;
        }
        if (!$users) {
            Log::info('编辑开奖结果异常，sql执行未成功');
        }


    }

    /**
     * 修改信息
     *
     */
    public function saves($data)
    {

        $data = DB::update('update cp_draw_result set num = ' . $data['num'] . ', numbers = "' . $data['numbers'] . '", name = "' . $data['name'] . '", types = "' . $data['types'] . '",    notice_date = ' . strtotime($data['notice_date']) . ', deadline = ' . strtotime($data['deadline']) . ' where id = ' . $data['id'] . '');
        if ($data) {
            return true;
        } else {
            return false;
        }


        //$data = DB::table('cp_draw_result')->where('id', $data['id'])->update(array('num' => $data['num'],'numbers'=>$data['numbers'],'name' => $data['name'],'types' => $data['types'],'notice_date'=>UNIX_TIMESTAMP($data['notice_date']),'deadline' => UNIX_TIMESTAMP($data['deadline'])));
        //return $data;

    }

    /**
     * 删除信息
     *
     */
    public function del($data)
    {
        $users = DB::table('cp_draw_result')->where('id', $data['id'])->update(['active'=>'0']);
        $res = DB::table('cp_winning_cash')->where('mon_id', $data['id'])->update(['active'=>'0']);
        if (!$res || !$users) {
            Log::info('开奖结果删除出现异常，sql执行未成功');
        }
        return $users;
    }

    /**
     * 发布开奖结果
     *
     */
    public function ad_kjnews($data)
    {
        $res = DB::table('cp_draw_result')->where('types', '=', $data['types'])->where('num', '=', $data['num'])->get();
        if ($res) {
            return 'cz';
        } else {
            $notice_date = strtotime($data['notice_date']);
            $deadline = strtotime($data['deadline']);
            if(mb_strlen($data['types'])<2){
                $type='0'.$data['types'];
            }else{
                $type=$data['types'];
            }
            $users = DB::table('cp_draw_result')->insert(array('num' => $data['num'], 'numbers' => $data['numbers'], 'name' => $data['name'], 'types' => $type, 'notice_date' => $notice_date, 'deadline' => $deadline));
            if ($users) {
                return true;
            } else {
                return false;
            }
        }


    }

    /**
     * 检索信息
     *
     */
    public function search($data)
    {
        $data = DB::select('select id, name, num, numbers, types, from_unixtime(notice_date) as notice_date, from_unixtime(deadline) as deadline from cp_draw_result where types = ' . $data['types'] . ' order by id desc');
        return $data;
    }

    /**
     * 金额添加
     *
     */
    public function mon_saves($data)
    {
        if ($data['mid'] == 0) {
            $count = DB::select('select winning_id, mon_id, level, cash, cash_add from cp_winning_cash where active=1 and mon_id = ' . $data['id']);
            $yesno = DB::select('select winning_id from cp_winning_cash where active=1 and mon_id = ' . $data['id'] . ' and level=' . $data['level']);
            if (count($yesno) > 0) {
                $users = 2;
            } else {
                $users = DB::table('cp_winning_cash')->insert(array('mon_id' => $data['id'], 'level' => $data['level'], 'cash' => $data['cash'], 'cash_add' => $data['cash_add']));
            }

        } else {
            $users = DB::table('cp_winning_cash')->where('winning_id', $data['mid'])->update(array('level' => $data['level'], 'cash' => $data['cash'], 'cash_add' => $data['cash_add']));
        }

        return $users;
    }

    /**
     * 当期开奖金额列表
     *
     */
    //task119 ZHOUGANG save 2016/8/12 START
    public function mon_lists($data)
    {
        $data = DB::select('select winning_id, mon_id, level, cash, cash_add from cp_winning_cash where active=1 and mon_id = ' . $data['id'] . '  order by winning_id asc');
        return $data;
    }
    //task119 ZHOUGANG save 2016/8/12 end
    /**
     * 当期开奖金额列表
     *
     */

    public function mon_edit($data)
    {
        $data = DB::select('select winning_id, mon_id, level, cash, cash_add from cp_winning_cash where winning_id = ' . $data['id']);
        return $data;
    }

    /**
     * 当期开奖金额列表
     *
     */
    //task119 ZHOUGANG save 2016/8/12 START
    public function mon_del($data)
    {
        $data = DB::table('cp_winning_cash')->where('winning_id', $data['id'])->update(['active'=>'0']);
        if (!$data) {
            Log::info('当期开奖金额列表异常，sql执行不正常');
        }
        return $data;
    }
    //task119 ZHOUGANG save 2016/8/12 end

    /**/


//	/**
//   * 增加文章
//   * 
//   * @param array $data 所需要插入的信息
//   */
//  public function addContent(array $data)
//  {
//      return $this->create($data);
//  }
//
//  /**
//   * 修改文章
//   * 
//   * @param array $data 所需要插入的信息
//   */
//  public function editContent(array $data, $id)
//  {
//      return $this->where('id', '=', intval($id))->update($data);
//  }
//
//  /**
//   * 取得指定ID信息
//   * 
//   * @param intval $id 文章的ID
//   * @return array
//   */
//  public function getOneById($id)
//  {
//      return $this->where('id', '=', intval($id))->first();
//  }
//
//  /**
//   * 批量软删除
//   */
//  public function solfDeleteContent(array $data, array $ids)
//  {
//      return $this->whereIn('id', $ids)->update($data);
//  }
//
//  

}
