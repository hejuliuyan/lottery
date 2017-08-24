<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\EntrustRole;
use DB;

/**
 * Class Role
 * @package App\Models
 * @task 91
 * @author zhou 2016-7-5 20:45
 */
class Role extends EntrustRole
{
    protected $guarded = [];

    public function lists()
    {
        $data = DB::table('roles')->get();
        return $data;
    }

    public function edit($id)
    {
        $data = DB::table('roles')->where('id', $id)->get();
        return $data;
    }

    public function per($id)
    {
        $data = DB::table('permission_role')->where('role_id', $id)->get();
        $arr = DB::table('permissions')->get();
        //error_log(print_r($arr,true));
        foreach ($data as $v) {
            foreach ($arr as $val) {
                if ($v->permission_id == $val->id) {
                    $val->state = 'checked';
                }
            }
        }
        $res = array();
        foreach($arr as $k=>$val){
            if($val->pid == '0'){
                $res[$k] = $val;
                foreach($arr as $key=>$v){
                    if($v->pid == $val->id){
                        $res[$k]->lists[$key] = $v;
                    }
                }
            }
        }
        //error_log(print_r($res,true));
        return $res;
    }
    /**
     * update
     * @param array $PermissionsId
     */
    public function givePermissionsTo(array $PermissionsId){
        $this->detachPermissions($this->perms);
        $this->attachPermissionToId($PermissionsId);
    }

    /**
     * Attach multiple $PermissionsId to a user
     *
     *
     */
    public function attachPermissionToId($PermissionsId)
    {
        foreach ($PermissionsId as $pid) {
            $this->attachPermission($pid);
        }
    }
    public function del_per($id){
        $data = DB::table('permission_role')->where('role_id', $id)->delete();
    }

}
