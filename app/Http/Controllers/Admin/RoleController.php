<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use Request;
use DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Admin\Controller;
use App\Models\Permission;

/**
 * 角色管理
 * @task 91
 * @author zhou 2016-7-8 17:49
 */
class RoleController extends Controller
{
    /**
     * @var array
     * 验证规则
     */
    private $rules = [
        'name' => 'required',
        'display_name' => 'required',
        'description' => 'required'
    ];
    private $messages = [
        'required' => '不能为空'
    ];
    protected $fields = [
        'name' => '',
        'display_name' => '',
        'description' => ''
    ];

    /**
     * 角色管理显示页面
     */
    public function index(Request $request)
    {
        $Model = new Role ();
        $lists = $Model->lists();//获取角色列表
        return view('admin.rbac.role.index')->with('lists', $lists);
    }

    /**
     * 创建角色页面
     */
    public function create()
    {
        return view('admin.rbac.role.add');
    }

    /**
     * @return mixed
     * 分配权限
     */
    public function store()
    {
        $input = Request::all();
        //验证输入数据
        $validator = Validator::make($input, $this->rules, $this->messages);
        if ($validator->fails()) {
            return $validator->errors();
            exit ();
        }
        $role = new Role ();
        foreach (array_keys($this->fields) as $field) {
            $role->$field = $input [$field];
        }
        $result = $role->save();
        echo $result;
    }

    /**
     * @return $this
     * 修改角色页面
     */
    public function edit()
    {
        $id = $_GET ['id'];
        $per = new Role ();
        $lists = $per->edit($id);
        return view('admin.rbac.role.edit')->with('data', $lists);
    }

    /**
     * @return mixed
     * 修改角色执行方法
     */
    public function save()
    {
        $id = $_POST ['id'];
        $data = $_POST;
        //验证输入数据
        $validator = Validator::make($data, $this->rules, $this->messages);
        if ($validator->fails()) {
            return $validator->errors();
            exit ();
        }
        $role = Role::find(( int )$id);
        foreach (array_keys($this->fields) as $field) {
            $role->$field = $data [$field];
        }
        $result = $role->save();
        echo $result;
    }

    /**
     * 删除角色
     */
    public function destroy()
    {
        $id = $_GET ['id'];
        $role = Role::find(( int )$id);
        if ($role) {
            $role->delete();
        } else {
            return '0';
            exit ();
        }
        return '1';
        exit ();
    }

    /**
     * @return $this
     * 分配权限页面
     */
    public function per()
    {
        $role = new Role ();
        $arr = $role->per($_GET ['id']);
        return view('admin.rbac.role.per')->with('data', $arr)->with('id', $_GET ['id']);
    }

    /**
     * @return string
     * 执行分配权限方法
     */
    public function doper()
    {
        $arr = Request::all();//获取数据
        $id = $arr ['id'];
        if(empty($arr ['per_list'])){
            $role = new Role();
            $role->del_per($id);
            return '1';
            exit();
        }
        $data = $arr ['per_list'];
        $role = Role::find(( int )$id);
        $role->givePermissionsTo($data);
        return '1';
    }
}