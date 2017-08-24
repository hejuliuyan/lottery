<?php namespace App\Services\Admin\Tags;

use Lang;
use App\Models\Admin\Tags as TagsModel;
use App\Models\Admin\TagsRelation as TagsRelationModel;
use App\Services\Admin\BaseProcess;

/**
 * 文章标签处理
 *
 * @author jiang <mylampblog@163.com>
 */
class Process extends BaseProcess
{
    /**
     * 标签模型
     * 
     * @var object
     */
    private $tagsModel;

    /**
     * 初始化
     *
     * @access public
     */
    public function __construct()
    {
        if( ! $this->tagsModel) $this->tagsModel = new TagsModel();
    }

    /**
     * 删除标签
     * 
     * @param array $ids
     * @access public
     * @return boolean true|false
     */
    public function delete($ids)
    {
        if( ! is_array($ids)) return false;
        $data['is_delete'] = TagsModel::TAGS_LIB_IS_DELETE_YES;
        if($this->tagsModel->deleteTags($data, $ids) !== false) return true;
        return $this->setErrorMsg(Lang::get('common.action_error'));
    }

    /**
     * 取得标签列表信息
     */
    public function undeleteTagsList()
    {
        $tags = $this->tagsModel->undeleteTagsList();
        $tagsIds = [];
        foreach ($tags as $key => $value) {
            $tagsIds[] = $value['id'];
        }
        $articleNums = with(new TagsRelationModel())->articleNumsGroupByTagId($tagsIds);
        foreach ($tags as $key => $value) {
            foreach ($articleNums as $articleNum) {
                if($articleNum->tag_id == $value['id']) {
                    $tags[$key]['articleNums'] = $articleNum->total;
                }
            }
        }
        return $tags;
    }

}