<?php namespace App\Http\Controllers\Home;
use App\Models\Home\Content as ContentModel;
use Request;

/**
 * 首页
 *
 * @author deng 2016‎年‎8‎月‎16‎日，‏‎11:55:37
 */
class HiscpController extends Controller
{
    /**
     * 开奖信息
     */
    public function index(){
    	$contentModel = new ContentModel();
		$cp['lists'] = $contentModel->cphis();
		echo json_encode($cp);
    }
	
	
	/**
     * 大乐透开奖历史
     */
    public function cpdlt(){
    	$contentModel = new ContentModel();
		$cpdlt['lists'] = $contentModel->cpdlt($_GET);
		echo json_encode($cpdlt);
    }

    /**
     * 大乐透开奖时间
     */
    public function cpdlt_time(){
        $contentModel = new ContentModel();
        $kj_time = $contentModel->cpdlt_time();
        echo json_encode($kj_time);
    }

    /**
     * 大乐透停售时间
     */
    public function cpdlt_endtime(){
        $contentModel = new ContentModel();
        $end_time = $contentModel->cpdlt_endtime($_GET);
        echo json_encode($end_time);
    }

}