<?php namespace App\Services\Admin\Category;

use Lang;
use App\Models\Admin\Category as CategoryModel;
use App\Models\Admin\ClassifyRelation as ClassifyRelationModel;
use App\Services\Admin\Category\Validate\Category as CategoryValidate;
use App\Services\Admin\BaseProcess;

/**
 * 文章分类处理
 *
 * @author jiang <mylampblog@163.com>
 */
class Process extends BaseProcess
{
    /**
     * 分类模型
     * 
     * @var object
     */
    private $categoryModel;

    /**
     * 分类表单验证对象
     * 
     * @var object
     */
    private $categoryValidate;

    /**
     * 初始化
     *
     * @access public
     */
    public function __construct()
    {
        if( ! $this->categoryModel) $this->categoryModel = new CategoryModel();
        if( ! $this->categoryValidate) $this->categoryValidate = new CategoryValidate();
    }

    /**
     * 增加新的分类
     *
     * @param array $data
     * @access public
     * @return boolean true|false
     */
    public function addCategory(\App\Services\Admin\Category\Param\CategorySave $data)
    {
        if( ! $this->categoryValidate->add($data)) return $this->setErrorMsg($this->categoryValidate->getErrorMessage());
        $data = $data->toArray();
        $data['is_delete'] = CategoryModel::IS_DELETE_NO;
        $data['time'] = time();
        if($this->categoryModel->addCategory($data) !== false) return true;
        return $this->setErrorMsg(Lang::get('common.action_error'));
    }

    /**
     * 删除分类
     * 
     * @param array $ids
     * @access public
     * @return boolean true|false
     */
    public function detele($ids)
    {
        if( ! is_array($ids)) return false;
        $data['is_delete'] = CategoryModel::IS_DELETE_YES;
        if($this->categoryModel->deleteCategorys($data, $ids) !== false) return true;
        return $this->setErrorMsg(Lang::get('common.action_error'));
    }

    /**
     * 编辑分类
     *
     * @param array $data
     * @access public
     * @return boolean true|false
     */
    public function editCategory(\App\Services\Admin\Category\Param\CategorySave $data)
    {
        if( ! isset($data['id'])) return $this->setErrorMsg(Lang::get('common.action_error'));
        $id = intval($data['id']); unset($data['id']);
        if( ! $this->categoryValidate->edit($data)) return $this->setErrorMsg($this->categoryValidate->getErrorMessage());
        if($this->categoryModel->editCategory($data->toArray(), $id) !== false) return true;
        return $this->setErrorMsg(Lang::get('common.action_error'));
    }

    /**
     * 取得分类列表信息
     */
    public function unDeleteCategory()
    {
        $category = $this->categoryModel->unDeleteCategory();
        $categoryIds = [];
        foreach ($category as $key => $value) {
            $categoryIds[] = $value['id'];
        }
        $articleNums = with(new ClassifyRelationModel())->articleNumsGroupByClassifyId($categoryIds);
        foreach ($category as $key => $value) {
            foreach ($articleNums as $articleNum) {
                if($articleNum->classify_id == $value['id']) {
                    $category[$key]['articleNums'] = $articleNum->total;
                }
            }
        }
        return $category;
    }

}