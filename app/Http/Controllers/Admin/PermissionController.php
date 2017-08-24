<?php

namespace App\Http\Controllers\Admin;

use App\Models\Permission;
use App\Models\Admin\Access as AccessModel;
use Request;
use DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests;

/**
 * 权限管理
 * @task 91
 * @author zhou 2016-7-8 16：02
 */
class PermissionController extends Controller
{

    /**
     * @var array
     * 验证规则
     */
    private $rules = [
        'name' => 'required',
        'display_name' => 'required',
        'description' => 'required',
    ];
    private $messages = [
        'required' => '不能为空',
    ];

    protected $fields = [
        'name' => '',
        'display_name' => '',
        'description' => '',
    ];

    /**
     * 权限管理
     */
    public function index()
    {
        $Model = new Permission ();
        $lists = $Model->lists();//获取权限列表
        return view('admin.rbac.per.index')->with('lists', $lists);
    }

    /**
     * @return $this
     * 权限添加
     */
    public function add()
    {
        $id = isset($_GET['id']) ? $_GET['id'] : '0';
        return view('admin.rbac.per.add')->with('pid', $id);
    }

    /**
     *
     * 添加类别
     */
    public function store()
    {
        $data = Request::all();
        //error_log(print_r($data,true));
//        验证输入数据
        $validator = Validator::make(
            $data,
            $this->rules,
            $this->messages
        );
        if ($validator->fails()) {
            return $validator->errors();
            exit();
        }
        $per = new Permission();
        $per->name = $data['name'];
        $per->display_name = $data['display_name'];
        $per->description = $data['description'];
        $per->pid = $data['pid'];
        $res = $per->save();//添加操作
        if ($res) {
            echo '1';
        } else {
            echo '0';
        }
        exit();
    }

    /**
     * @return string
     * 删除权限
     */
    public function destroy()
    {
        $id = $_GET['id'];
        $per = new Permission();
        $res = $per->del($id);
        if ($res == '1') {
            return '2';
            exit();
        }
        $permission = Permission::find((int)$id);//获取权限id
//        删除权限
        if ($permission) {
            $permission->delete();
        } else {
            return '0';
            exit();
        }
        return '1';
        exit();
    }

    /**
     * @return $this
     * 修改权限页面
     */
    public function edit()
    {
        $id = $_GET['id'];
        $per = new Permission();
        $lists = $per->edit($id);//权限修改
        return view('admin.rbac.per.edit')->with('data', $lists);
    }

    /**
     * @return mixed
     * 修改权限执行
     */
    public function save()
    {
        $id = $_POST['id'];
        $data = $_POST;
        //验证输入数据
        $validator = Validator::make(
            $data,
            $this->rules,
            $this->messages
        );
        if ($validator->fails()) {
            return $validator->errors();
            exit();
        }
        $permission = Permission::find((int)$id);//获取权限id
        //修改权限
        foreach (array_keys($this->fields) as $field) {
            $permission->$field = $data[$field];
        }
        $result = $permission->save();
        echo $result;
    }

}