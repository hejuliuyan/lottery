<?php

namespace App\Widget\Admin;

use Config;
use App\Services\Admin\Upload\Process as UploadManager;

/**
 * 上传小组件
 *
 * @author jiang <mylampblog@163.com>
 */
class Upload
{
    /**
     * 上传的配置
     * 
     * @var array
     */
    private $config = [
        'id' => '', //必传,表单id
        'callback' => '', //必传,回调函数
        'alowexts' => '', //允许图片格式
        'nums' => '', //最多可以上传多少个文件
        //缩略图配置
        //<code>
        //  thumbSettin的值为：
        //  $thumbSetting = array(
        //      ['width' => 111, 'height' => 222],//多个值就生成多个缩略图
        //      ['width' => 111, 'height' => 222]
        //  );
        //</code>
        'thumbSetting' => '',
        'waterSetting' => '', //true|false 水印
        'waterImage' => '', // 如果开启了水印，那么必需传入这个水印图，否则读取配置的。
        'uploadPath' => '', //上传的路径
        'filesize' => '',
    ];

    /**
     * 上传的配置
     *
     * @param array $config 上传的配置
     */
    public function setConfig(array $config)
    {
        foreach($config as $key => $value)
        {
            if(isset($this->config[$key])) $this->config[$key] = $value;
        }
        return $this;
    }

    /**
     * 输出上传图片按钮，调用上传窗口
     */
    public function uploadButton()
    {
        $config = $this->config;
        if( ! isset($config['alowexts']) or empty($config['alowexts'])) $config['alowexts'] = 'jpg,jpeg,gif,bmp,png,doc,docx';
        $uploadObject = new UploadManager();
        if( ! isset($config['uploadPath']) or empty($config['uploadPath'])) $config['uploadPath'] = Config::get('sys.sys_upload_path').'/';
        $config['uploadPath'] = base64url_encode($config['uploadPath']);

        $config['uploadUrl'] = R('common', 'foundation.upload.index');
        //生成密钥，附止表单被修改。
        $authkey = $uploadObject->setParam($config)->uploadKey();
        return view('admin.widget.uploadbutton',
            compact('config', 'authkey')
        );
    }

}