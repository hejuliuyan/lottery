<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\AdminUser as UserModel;
use App\Models\Admin\Access as AccessModel;
use Request;
use DB;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Role;

/**
 * 管理员管理
 * @task 91
 * @author zhou 2016-7-8 13:19
 */
class UserController extends Controller
{
    /**
     * @var array
     * 验证规则
     */
    private $rules = [
        'name' => 'required',
        'email' => 'required|email',
        'password' => 'required'
    ];
    private $messages = [
        'required' => '不能为空',
        'email' => '请输入正确邮箱格式'
    ];
    protected $fields = [
        'name' => '',
        'email' => '',
        'roles' => []
    ];

    /**
     * 管理员列表页面
     */
    public function index()
    {
        $Model = new UserModel ();
        // $data=$_GET['where']!=''?$_GET['where']:'';
        $lists = $Model->lists();
        return view('admin.rbac.users.index')->with('lists', $lists);
    }

    /**
     * 添加管理员页面
     */
    public function add()
    {
        return view('admin.rbac.users.add');
    }

    /**
     * @return string
     * 执行管理员添加方法
     */
    public function doadd()
    {
        $data = $_POST;
        // error_log(print_r($data,true));
        $validator = Validator::make($data, $this->rules, $this->messages);
        if ($validator->fails()) {
            return $validator->errors();
        }
        $Model = new UserModel ();
        $res = $Model->add($data);
        if ((isset ($res)) && (!empty ($res)) && ($res != false)) {
            return '1';
        } else {
            return '0';
        }
    }

    /**
     * 修改管理员信息
     */
    public function edit()
    {
        $Model = new UserModel ();
        $data = $Model->edit($_GET ['id']);
        // $data_lists = $Model->mon_lists ( $_GET );
        // error_log(print_r($data,true));
        return view('admin.rbac.users.edit')->with('data', $data);
    }

    /**
     * 保存管理员信息方法
     */
    public function save()
    {
        $data = Request::all();
        $validator = Validator::make($data, $this->rules, $this->messages);
        if ($validator->fails()) {
            return $validator->errors();
        }
        $Model = new UserModel ();
        $res = $Model->saves($data);
        if ((isset ($res)) && (!empty ($res)) && ($res != false)) {
            return '1';
        } else {
            return '0';
        }
    }

    /**
     * 删除管理员
     */
    public function del()
    {
        $Model = new UserModel ();

        $del = $Model->del($_GET ['id']);
        if ($del) {
            return '1';
        }
        die ();
    }

    /**
     * @return $this
     * 管理员角色分配页面
     */
    public function role()
    {
        $id = $_GET ['id'];
        $user = User::find(( int )$id);
        // if (!$user) return redirect('/admin/user')->withErrors("找不到该用户!");
        $roles = [];
        if ($user->roles) {
            foreach ($user->roles as $v) {
                $roles [] = $v->id;
            }
        }
        $user->roles = $roles;
        foreach (array_keys($this->fields) as $field) {
            $data [$field] = old($field, $user->$field);
        }
        $data ['rolesAll'] = Role::all()->toArray();
        $data ['id'] = ( int )$id;
        // error_log(print_r($data,true));
        return view('admin.rbac.users.role')->with('data', $data)->with('id', $id);
    }

    /**
     * @return string
     * 分配角色给管理员
     */
    public function add_role()
    {
        $id = $_POST['id'];
        $user = User::find((int)$id);
        if (empty($_POST['role_list'])) {
            $res = $user->del_role($id);
            return '1';
            exit();
        }
        $data = $_POST['role_list'];
        $res = $user->del_role($id);
        foreach ($data as $v) {
            $user->roles()->attach($v); //只需传递id即可
        }
        return '1';


    }
}