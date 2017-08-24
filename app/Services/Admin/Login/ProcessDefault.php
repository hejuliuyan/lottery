<?php namespace App\Services\Admin\Login;

use App\Models\Admin\User as UserModel;
use App\Models\Admin\Permission as PermissionModel;
use App\Services\Admin\SC;
use App\Services\Admin\Login\AbstractProcess;
use Validator, Lang;
use Request;

/**
 * 登录处理
 *
 * @author jiang <mylampblog@163.com>
 */
class ProcessDefault extends AbstractProcess {

    /**
     * 用户模型
     * 
     * @var object
     */
    private $userModel;

    /**
     * 权限模型
     * 
     * @var object
     */
    private $permissionModel;

    /**
     * 初始化
     *
     * @access public
     */
    public function __construct()
    {
        if( ! $this->userModel) $this->userModel = new UserModel();
        if( ! $this->permissionModel) $this->permissionModel = new PermissionModel();
    }

    /**
     * 登录验证
     *
     * @param string $username 用户名
     * @param string $password 密码
     * @access public
     * @return boolean false|用户的信息
     */
    public function check($username, $password)
    {
        $userInfo = $this->userModel->InfoByName($username);
        $sign = md5($userInfo['password'].$this->getPublicKey());
        $this->delPublicKey();
        if($sign == strtolower($password))
        {
            $data['last_login_time'] = time();
            $data['last_login_ip'] = Request::ip();
            $this->userModel->updateLastLoginInfo($userInfo->id, $data);
            SC::setLoginSession($userInfo);
            SC::setAllPermissionSession($this->permissionModel->getAllAccessPermission());
            event(new \App\Events\Admin\ActionLog(Lang::get('login.login_sys'), ['userInfo' => $userInfo]));
            return $userInfo;
        }
        return false;
    }

    /**
     * 检测post过来的数据
     * 
     * @param string $username 用户名
     * @param string $password 密码
     * @access public
     * @return false|string
     */
    public function validate($username, $password)
    {
        $this->checkCsrfToken();
        $data = array( 'username' => $username, 'password' => $password );
        $rules = array( 'username' => 'required|min:1', 'password' => 'required|min:1' );
        $messages = array(
            'username.required' => Lang::get('login.please_input_username'),
            'username.min' => Lang::get('login.please_input_username'),
            'password.required' => Lang::get('login.please_input_password'),
            'password.min' => Lang::get('login.please_input_password')
        );
        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails())
        {
            return $validator->messages()->first();
        }
        return false;
    }

    /**
     * 手动的验证csrftoken
     */
    private function checkCsrfToken()
    {
        $csrf = new \App\Services\Admin\CsrfValidate();
        $csrf->tokensMatch();
    }

    /**
     * 设置并返回加密密钥
     *
     * @return string 密钥
     */
    public function setPublicKey()
    {
        return SC::setPublicKey();
    }

    /**
     * 取得刚才设置的加密密钥
     * 
     * @return string 密钥
     */
    public function getPublicKey()
    {
        return SC::getPublicKey();
    }

    /**
     * 删除密钥
     * 
     * @return void
     */
    public function delPublicKey()
    {
        return SC::delPublicKey();
    }

    /**
     * 判断是否已经登录
     *
     * @return boolean true|false
     */
    public function hasLogin()
    {
        return SC::getLoginSession();
    }

    /**
     * 登录退出
     *
     * @return void
     */
    public function logout()
    {
        return SC::delLoginSession();
    }

}