<?php

namespace App\Http\Controllers\Admin;

use Request;
use DB;
use Illuminate\Support\Facades\Session;


/**
 * 语言包管理
 * @task 98
 * @author zhou 2016-8-2 17:46
 */
class LanguageController extends Controller
{
    /**
     * 用户选择语言
     */
    public function swap()
    {

        $lang = $_GET['type'];
        //error_log(print_r($lang,true));
        session()->put('locale', $lang);//记录用户选择的语言
        return redirect()->back();
    }
}