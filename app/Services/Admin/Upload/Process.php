<?php namespace App\Services\Admin\Upload;

use App\Services\Admin\BaseProcess;

/**
 * 上传处理
 *
 * @author jiang <mylampblog@163.com>
 */
class Process extends BaseProcess
{
    /**
     * 用于上传的加密密钥
     * 
     * @var string
     */
    private $uploadToken = 'jiang';

    /**
     * 文件上传表单的名字
     * 
     * @var string
     */
    private $fileFormName = 'file';

    /**
     * 上传的文件对象
     * 
     * @var object
     */
    private $file;

    /**
     * 上传需要的参数
     * 
     * @var array
     */
    private $params;

    /**
     * 所要保存的文件名
     * 
     * @var string
     */
    private $saveFileName;

    /**
     * 配置文件中所定的文件保存的路径
     * 
     * @var string
     */
    private $configSavePath;

    /**
     * 设置上传需要的参数
     */
    public function setParam($params)
    {
        $this->params = $params;
        return $this;
    }

    /**
     * 文件上传的对象
     */
    public function setFile($file)
    {
        $this->file = $file;
        return $this;
    }

    /**
     * 生成上传附件验证，防止表单修改
     */
    public function uploadKey()
    {
        $uploadToken = md5($this->uploadToken.$_SERVER['HTTP_USER_AGENT']);
        $authkey = md5(serialize($this->params).$uploadToken);
        return $authkey;
    }

    /**
     * 检测token是否匹配
     * 
     * @return boolean
     */
    public function checkUploadToken($uploadToken)
    {
        if($this->uploadKey() != $uploadToken) return false;
        return true;
    }

    /**
     * 开始处理上传
     *
     * @return false|string
     */
    public function upload()
    {
        //是否上传出错
        if ( ! $this->file->isValid() or $this->file->getError() != UPLOAD_ERR_OK) return false;
        //保存的路径
        $savePath = $this->setSavePath();
        //保存的文件名
        $saveFileName = $this->getSaveFileName().'.'.$this->file->getClientOriginalExtension();
        //保存
        $this->file->move($savePath, $saveFileName);
        //文件是否存在
        $realFile = $savePath.$saveFileName;
        if( ! file_exists($realFile)) return false;

        //是否加上水印
        if(isset($this->params['waterSetting']) and $this->params['waterSetting'] === true)
        {
            $waterImage = $this->params['waterImage'];
            if( ! isset($this->params['waterImage']) or empty($this->params['waterImage']))
            {
                $waterImage = $this->getWaterFile();
            }
            $this->waterImage($realFile, $waterImage);
        }

        //返回文件
        $realFileUrl[] = str_replace('/', '', str_replace($this->getConfigSavePath(), '', $realFile));
        $thumbRealFileUrl = [];

        //是否要裁剪
        if(isset($this->params['thumbSetting']) and ! empty($this->params['thumbSetting']))
        {
            $thumbRealFileUrl = $this->cutImage($realFile, $savePath);
        }

        $returnFileUrl = implode('|', array_merge($realFileUrl, $thumbRealFileUrl));

        return $returnFileUrl;
    }

    /**
     * 加上水印
     * 
     * @param  string $realFile 所要处理的图片的位置
     * @param string $waterImage 所要加上的水印图
     * @return void
     */
    private function waterImage($realFile, $waterImage)
    {
        $imagine = new \Imagine\Gd\Imagine();
        $watermark = $imagine->open($waterImage);
        $image = $imagine->open($realFile);
        $size = $image->getSize();
        $wSize = $watermark->getSize();
        $bottomRight = new \Imagine\Image\Point($size->getWidth() - $wSize->getWidth(), $size->getHeight() - $wSize->getHeight());
        $image->paste($watermark, $bottomRight);
        $image->save($realFile);
    }

    /**
     * 开始处理裁剪
     *
     * @param  string $realFile 所要处理的图片的位置
     * @param  string $savePath 所要保存的位置
     * @return string           处理后的图片
     */
    private function cutImage($realFile, $savePath)
    {
        if( ! isImage($this->file->getClientOriginalExtension())) throw new \Exception("Image thumb must be images.");
        $imagine = new \Imagine\Gd\Imagine();
        $mode = \Imagine\Image\ImageInterface::THUMBNAIL_INSET;
        $result = [];
        foreach($this->params['thumbSetting'] as $key => $value)
        {
            if(isset($value['width'], $value['height']) and is_numeric($value['width']) and is_numeric($value['height']))
            {
                $size = new \Imagine\Image\Box($value['width'], $value['height']);
                $saveName = $savePath.$this->getSaveFileName().'_'.$value['width'].'_'.$value['height'].'_thumb.'.$this->file->getClientOriginalExtension();
                $imagine->open($realFile)->thumbnail($size, $mode)->save($saveName);
                $result[] = str_replace('/', '', str_replace($this->getConfigSavePath(), '', $saveName));
            }
        }
        return $result;
    }

    /**
     * 设置保存的路径
     *
     * @access private
     */
    private function setSavePath()
    {
        $savePath = base64url_decode($this->params['uploadPath']);
        if( ! is_dir($savePath))
        {
            //如果保存路径不存在，那么建立它
            dir_create($savePath);
        }
        return $savePath;
    }

    /**
     * 所要保存的文件名
     * 
     * @return string
     */
    private function getSaveFileName()
    {
        if( ! $this->saveFileName) $this->saveFileName = md5(uniqid('pre', TRUE).mt_rand(1000000,9999999));
        return $this->saveFileName;
    }

    /**
     * 配置文件中的图片所保存的路径
     * 
     * @return string
     */
    private function getConfigSavePath()
    {
        if( ! $this->configSavePath) $this->configSavePath = \Config::get('sys.sys_upload_path');
        return $this->configSavePath;
    }

    /**
     * 取得要加水印的图片
     */
    private function getWaterFile()
    {
        return \Config::get('sys.sys_water_file');
    }

}