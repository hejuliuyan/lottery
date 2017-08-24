<?php

namespace App\Services;

use Request, Session;

/**
 * 主要用于防止表单篡改
 *
 * @author jiang <mylampblog@163.com>
 */
class Formhash
{
    /**
     * 缓存需要验证的信息
     * 
     * @param void $data 所要验证的数据，必须以最后提交的数据的数据结构一致。
     * @return string
     */
    public function hash($data)
    {
        $fullUrl = Request::fullUrl();
        $hashKey = md5($fullUrl.serialize($data));
        Session::put($hashKey, $data);
        return $hashKey;
    }

    /**
     * 校验表单
     */
    public function checkFormHash()
    {
        $formHash = Request::input('_form_hash');
        $formData = Request::all();
        if( ! $formHash) abort(500, 'form hash deny!');
        if( ! Session::has($formHash)) abort(500, 'form hash deny!');
        $hashData = Session::get($formHash);
        foreach($hashData as $key => $value)
        {
            if($formData[$key] != $value) abort(500, 'form hash deny!');
        }
        return true;
    }

}
