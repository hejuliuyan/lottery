<?php namespace App\Http\Controllers\Home;
use App\Models\Home\Content as ContentModel;
use Request;
use Log;
/**
 * 首页
 *
 * @author wang <775720867@qq.com>
 */
class IndexController extends Controller
{
    /**
     * 首页
     */
    public function index(){
    	return response(view('home.index.index'));
    }

    public function pic(){
    	$Model = new ContentModel ();
    	$data = $Model->pic_lun();
    	return $data;
    }
    public function get_loc(){
        $data = file_get_contents("http://api.map.baidu.com/geoconv/v1/?coords=".$_POST['lon'].",".$_POST['lat']."&form=1&to=5&ak=3N9hsSctbasaQ9cP7cATdEQOg0SDaDA3");
        return json_decode($data,true);
    }

}