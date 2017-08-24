<?php

namespace App\Http\Controllers\Home;

use App\Models\Home\Wallet as WalletModel;
use Request;
use DB;
use Log;

/**
 * 走势图数据抓取
 * @task 134
 * @author zhou 2016-8-19 15:50
 */
class ChartController extends Controller
{
    /**
     * 大乐透
     */
    public function lotto()
    {
        $html = file_get_contents('mui/number.html');
        $qishu = file_get_contents('mui/qishu.txt');
        $data['html'] = $html;
        $data['qs'] =json_decode($qishu,true);
        return $data;
    }
}