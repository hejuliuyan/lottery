<?php namespace App\Services\Admin\Content;

use Lang;
use App\Models\Admin\Content as ContentModel;
use App\Models\Admin\TagsRelation as TagsRelationModel;
use App\Models\Admin\Tags as TagsModel;
use App\Models\Admin\ClassifyRelation as ClassifyRelationModel;
use App\Models\Admin\ContentDetail as ContentDetailModel;
use App\Models\Admin\PositionRelation as PositionRelationModel;
use App\Models\Admin\SearchIndex as SearchIndexModel;
use App\Services\Admin\Content\Validate\Content as ContentValidate;
use App\Services\Admin\SC;
use App\Libraries\Spliter;
use App\Services\Admin\BaseProcess;

/**
 * 文章处理
 *
 * @author jiang <mylampblog@163.com>
 */
class Process extends BaseProcess
{
    /**
     * 文章模型
     * 
     * @var object
     */
    private $contentModel;

    /**
     * 文章副表模型
     * 
     * @var object
     */
    private $contentDetailModel;

    /**
     * 文章表单验证对象
     * 
     * @var object
     */
    private $contentValidate;

    /**
     * 初始化
     *
     * @access public
     */
    public function __construct()
    {
        if( ! $this->contentModel) $this->contentModel = new ContentModel();
        if( ! $this->contentDetailModel) $this->contentDetailModel = new ContentDetailModel();
        if( ! $this->contentValidate) $this->contentValidate = new ContentValidate();
    }

    /**
     * 增加新的文章
     *
     * @param string $data
     * @access public
     * @return boolean true|false
     */
    public function addContent(\App\Services\Admin\Content\Param\ContentSave $data)
    {
        if( ! $this->contentValidate->add($data))
        {
            $unValidateMsg = $this->contentValidate->getErrorMessage();
            return $this->setErrorMsg($unValidateMsg);
        }

        $object = new \stdClass();
        $object->time = time();
        $object->userId = SC::getLoginSession()->id;

        try
        {
            $result = \DB::transaction(function() use ($data, $object)
            {
                $object->contentAutoId = $this->saveContent($data, $object);
                $this->saveContentDetail($data, $object);
                $this->saveArticleTags($object, $data['tags']);
                $this->saveArticleClassify($object, $data['classify']);
                $this->saveSeachFullText($object, $data);
                return true;
            });
        }
        catch (\Exception $e)
        {
            $result = false;
        }

        if( ! $result) return $this->setErrorMsg(Lang::get('common.action_error'));

        return true;
    }

    /**
     * 编辑文章，因为使用了事务，如果没有成功请手动抛出异常
     *
     * @param string $data
     * @access public
     * @return boolean true|false
     */
    public function editContent(\App\Services\Admin\Content\Param\ContentSave $data, $id)
    {
        if( ! $this->contentValidate->edit($data))
        {
            $unValidateMsg = $this->contentValidate->getErrorMessage();
            return $this->setErrorMsg($unValidateMsg);
        }

        $object = new \stdClass();
        $object->contentAutoId = $id;

        try
        {
            $result = \DB::transaction(function() use ($data, $id, $object)
            {
                $this->updateContent($data, $id);
                $this->updateContentDetail($data, $id);
                $this->saveArticleTags($object, $data['tags']);
                $this->saveArticleClassify($object, $data['classify']);
                $this->saveSeachFullText($object, $data, true);
                return true;
            });
        }
        catch (\Exception $e)
        {
            $result = false;
        }

        if( ! $result)
        {
            return $this->setErrorMsg(Lang::get('common.action_error'));
        }
        return true;
    }

    /**
     * 删除文章，因为使用了事务，如果没有成功请手动抛出异常
     * 
     * @param array $ids 要删除的文章的id
     * @access public
     * @return boolean true|false
     */
    public function detele($ids)
    {
        if( ! is_array($ids)) return false;
        $data['is_delete'] = ContentModel::IS_DELETE_YES;
        try
        {
            $result = \DB::transaction(function() use ($data, $ids)
            {
                $this->contentModel->solfDeleteContent($data, $ids);
                $this->deleteArticleClassifyById($ids);
                $this->deleteArticleTagsById($ids);
                $this->deleteArticlePositionById($ids);
                return true;
            });
        }
        catch (\Exception $e)
        {
            $result = false;
        }

        if( ! $result) return $this->setErrorMsg(Lang::get('common.action_error'));

        return $result;
    }

    /**
     * 文章和推荐位的关联
     * 
     * @param  array $ids  文章的ID
     * @param  array $pids 推荐位的ID
     * @return return       true|false
     */
    public function articlePositionRelation($ids, $pids)
    {
        $model = new PositionRelationModel();
        return $model->articlePositionRelation($ids, $pids);
    }

    /**
     * 保存到主表，因为使用了事务，如果没有成功请手动抛出异常
     * 
     * @param  array $data
     * @return int 自增的ID
     */
    private function saveContent(\App\Services\Admin\Content\Param\ContentSave $data, $object)
    {
        $dataContet['is_delete'] = ContentModel::IS_DELETE_NO;
        $dataContet['write_time'] = $object->time;
        $dataContet['user_id'] = $object->userId;
        $dataContet['title'] = $data['title'];
        $dataContet['status'] = $data['status'];
        $dataContet['summary'] = $data['summary'];
        $insertObject = $this->contentModel->addContent($dataContet);
        if( ! $insertObject->id)
        {
            throw new \Exception("save content error");
        }
        return $insertObject->id;
    }

    /**
     * 保存到副表，因为使用了事务，如果没有成功请手动抛出异常
     * 
     * @param  array $data
     * @return object
     */
    private function saveContentDetail(\App\Services\Admin\Content\Param\ContentSave $data, $object)
    {
        $detailData['content'] = $data['content'];
        $detailData['user_id'] = $object->userId;
        $detailData['time'] = $object->time;
        $detailData['article_id'] = $object->contentAutoId;
        $insertObject = $this->contentDetailModel->addContentDetail($detailData);
        if( ! $insertObject)
        {
            throw new \Exception("save content detail error");
        }
        return $insertObject;
    }

    /**
     * 保存文章的分类，因为使用了事务，如果没有成功请手动抛出异常
     * 
     * @param object $object 文章的信息
     * @param array $classify 分类
     */
    private function saveArticleClassify($object, $classify)
    {
        $this->deleteArticleClassifyById(array($object->contentAutoId));

        $insertData = [];
        foreach($classify as $key => $classifyId)
        {
            $insertData[] = array(
                'article_id' => intval($object->contentAutoId),
                'classify_id' => intval($classifyId),
                'time' => time()
            );
        }

        $model = new ClassifyRelationModel();
        $result = $model->addClassifyArticleRelations($insertData);

        if( ! $result) throw new \Exception("add classify article relation error.");
    }

    /**
     * 根据文章的ID删除它的分类关系，因为使用了事务，如果没有成功请手动抛出异常
     *
     * @param array $articleIds 文章的id组
     * @return boolean true|false
     */
    private function deleteArticleClassifyById($articleIds)
    {
        if( ! is_array($articleIds)) throw new \Exception("article ids is not array.");
        $articleIds = array_map('intval', $articleIds);
        $result = with(new ClassifyRelationModel())->deleteClassifyRelation($articleIds);
        if($result === false)
        {
            throw new \Exception("delete article classify error.");
        }
        return $result;
    }

    /**
     * 保存文章的标签，因为使用了事务，如果没有成功请手动抛出异常
     *
     * @param int $object->contentAutoId 文章的ID
     * @param array $tags 标签
     */
    private function saveArticleTags($object, $tags)
    {
        $this->deleteArticleTagsById(array($object->contentAutoId));

        $insertData = [];
        foreach($tags as $tagName)
        {
            $tagInfo = with(new TagsModel())->addTagsIfNotExistsByName($tagName);
            if( ! $tagInfo->id) throw new \Exception("add tags if not exists by name error.");

            $insertData[] = [
                'article_id' => $object->contentAutoId,
                'tag_id' => $tagInfo->id,
                'time' => time()
            ];
        }

        $result = with(new TagsRelationModel())->addTagsArticleRelations($insertData);
        if( ! $result) throw new \Exception("add tags article relation error.");

        return $result;
    }

    /**
     * 根据文章的ID删除它的标签，，因为使用了事务，如果没有成功请手动抛出异常
     * 
     * @return boolean true|false
     */
    private function deleteArticleTagsById($articleIds)
    {
        if( ! is_array($articleIds)) throw new \Exception("article ids is not array.");
        $articleIds = array_map('intval', $articleIds);
        $result = with(new TagsRelationModel())->deleteTagsRelation($articleIds);
        if($result === false)
        {
            throw new \Exception("delete article tags error.");
        }
        return $result;
    }

    /**
     * 根据文章的ID删除它的推荐位的文章，因为使用了事务，如果没有成功请手动抛出异常
     *
     * @param array $articleIds 文章的id组
     * @return boolean true|false
     */
    private function deleteArticlePositionById($articleIds)
    {
        if( ! is_array($articleIds)) throw new \Exception("article ids is not array.");
        $articleIds = array_map('intval', $articleIds);
        $result = with(new PositionRelationModel())->deletePositionRelation($articleIds);
        if($result === false)
        {
            throw new \Exception("delete article position error.");
        }
        return $result;
    }

    /**
     * 保存到主表，因为使用了事务，如果没有成功请手动抛出异常
     * 
     * @param  array $data
     * @return int 自增的ID
     */
    private function updateContent(\App\Services\Admin\Content\Param\ContentSave $data, $id)
    {
        $dataContet['title'] = $data['title'];
        $dataContet['status'] = $data['status'];
        $dataContet['summary'] = $data['summary'];
        $result = $this->contentModel->editContent($dataContet, $id);
        if($result === false)
        {
            throw new \Exception("save content error");
        }
        return $result;
    }

    /**
     * 保存到副表，因为使用了事务，如果没有成功请手动抛出异常
     * 
     * @param  array $data
     * @return object
     */
    private function updateContentDetail(\App\Services\Admin\Content\Param\ContentSave $data, $id)
    {
        $detailData['content'] = $data['content'];
        $result = $this->contentDetailModel->editContentDetail($detailData, $id);
        if($result === false) throw new \Exception("save content detail error");
        return $result;
    }

    /**
     * 更新查询索引表，因为使用了事务，如果没有成功请手动抛出异常
     * 
     * @param  object $object
     * @param  array $data
     * @param boolean $isEdit false的时候为增加，true的时候为edit
     * @return boolean
     */
    private function saveSeachFullText($object, \App\Services\Admin\Content\Param\ContentSave $data, $isEdit = false)
    {
        $spliterObject = new Spliter();
        $titleSplited   = $spliterObject->utf8Split($data['title']);
        $index['title']   = $titleSplited['words'];
        $contentSplited = $spliterObject->utf8Split(strip_tags($data['content']));
        $index['content'] = $contentSplited['words'];
        $summarySplited = $spliterObject->utf8Split(strip_tags($data['summary']));
        $index['summary'] = $summarySplited['words'];
        $index['article_id'] = $checkIndex['article_id'] = $object->contentAutoId;
        
        if($isEdit === false) $index['added_date'] = $index['edited_date'] = time();
        if($isEdit === true) $index['edited_date'] = time();

        $indexModel = new SearchIndexModel();
        $result = $indexModel->saveIndex($checkIndex, $index);
        if($result === false)
        {
            throw new Exception("save article dict index error.");
        }
    }

}