<?php

namespace App\Http\Controllers\Admin\Foundation;

use Request, Config, Lang;
use App\Services\Admin\Upload\Process as UploadManager;
use App\Http\Controllers\Admin\Controller;

/**
 * 弹出窗口上传
 *
 * @author jiang <mylampblog@163.com>
 */
class UploadController extends Controller
{
    /**
     * 上传弹出窗口
     */
    public function index()
    {
        $parpams = Request::only('args', 'authkey');
        $args = @ unserialize(base64url_decode($parpams['args']));
        $uploadObject = new UploadManager();
        if( ! $uploadObject->setParam($args)->checkUploadToken($parpams['authkey'])) return abort(500);
        return view('admin.upload.index', compact('parpams', 'args'));
    }

    /**
     * 处理上传
     */
    public function process()
    {
        $parpams = Request::only('authkey', 'args');
        $config = @ unserialize(base64url_decode($parpams['args']));
        //检测请求是否合法
        $uploadObject = new UploadManager();
        if( ! $uploadObject->setParam($config)->checkUploadToken($parpams['authkey'])) return abort(500);
        //开始处理上传
        $file = Request::file('file');
        $returnFileUrl = $uploadObject->setFile($file)->upload();
        if( ! $returnFileUrl) return abort(500);
        return response()->json(['file'=>$returnFileUrl]);
    }

}