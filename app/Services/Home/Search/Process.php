<?php namespace App\Services\Home\Search;

use Lang;
use App\Services\Home\Search\Sphinx;
use App\Libraries\Spliter;
use App\Services\Home\BaseProcess;

/**
 * 搜索处理
 *
 * @author jiang <mylampblog@163.com>
 */
class Process extends BaseProcess
{
    /**
     * 初始化sphinx客户端
     */
    public function sphinxSearch($keyword)
    {
        $sphinx = (new Sphinx())->initSphinxClient();
        $result = $sphinx->query($keyword, '*');
        return $this->prepareSphinxResult($result);
    }

    /**
     * 处理sphinx的返回结果
     */
    private function prepareSphinxResult($result)
    {
        if( ! isset($result['matches'])) return false;
        $result = arraySort($result['matches'], 'weight', 'desc');
        $articleIds = [];
        foreach($result as $key => $value)
        {
            $articleIds[] = $value['attrs']['article_id'];
        }
        return $articleIds;
    }

    /**
     * 取得keyword的unicode码
     * 
     * @param  string $keyword
     * @return string        
     */
    public function prepareKeyword($keyword)
    {
        $spliter = new Spliter();
        $keywords = explode(' ', $keyword);
        $against = '';
        foreach($keywords as $kw)
        {
            $splitedWords = $spliter->utf8Split($kw);
            $against .= $splitedWords['words']; 
        }
        return $against;
    }

}