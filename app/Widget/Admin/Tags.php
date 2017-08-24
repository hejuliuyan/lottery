<?php

namespace App\Widget\Admin;

use App\Widget\Admin\AbstractBase;

/**
 * 文章标签小组件
 *
 * @author jiang <mylampblog@163.com>
 */
class Tags extends AbstractBase
{
    /**
     * 文章标签列表删除操作
     *
     * @access public
     */
    public function delete($data)
    {
        $this->setCurrentAction('tags', 'delete', 'blog')->checkPermission();
        $url = R('common', $this->module.'.'.$this->class.'.'.$this->function, ['id' => $data['id']]);
        $html = $this->hasPermission ?
                    '<a href="javascript:ajaxDelete(\''.$url.'\', \'sys-list\', \'确定吗？\');"><i class="fa fa-trash-o"></i></a>'
                        : '<i class="fa fa-trash-o" style="color:#ccc"></i>';
        return $html;
    }

}