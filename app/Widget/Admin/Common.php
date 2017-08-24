<?php

namespace App\Widget\Admin;

use App\Services\Admin\SC;
use Request, Config;

/**
 * 菜单小组件
 *
 * @author jiang <mylampblog@163.com>
 */
class Common
{
    /**
     * footer
     */
    public function footer()
    {
        return view('admin.widget.footer');
    }

    /**
     * header
     */
    public function header(array $widgetHeaderConfig = array())
    {
        $domain['domain'] = Request::root();
        $domain['img_domain'] = Config::get('sys.sys_images_domain');
        return view('admin.widget.header', compact('widgetHeaderConfig', 'domain'));
    }

    /**
     * top
     */
    public function top()
    {
        $username = SC::getLoginSession()->name;
        return view('admin.widget.top', compact('username'));
    }

    /**
     * crumbs
     */
    public function crumbs($btnGroup = false)
    {
        $mcaName = \App\Services\Admin\MCAManager::MAC_BIND_NAME;
        $MCA = app()->make($mcaName);
        $currentMCAinfo = $MCA->getCurrentMCAInfo();
        $topMenu = $MCA->getCurrentMCAfatherMenuInfo();
        return view('admin.widget.crumbs',
            compact('btnGroup', 'currentMCAinfo', 'topMenu')
        );
    }

    /**
     * htmlend
     */
    public function htmlend()
    {
        return '</body></html>';
    }

    /**
     * 修改密码
     */
    public function mpassword()
    {
        return view('admin.widget.mpassword');
    }

    /**
     * 功能地图
     */
    public function menumap()
    {
        $zTreeNode = widget('Admin.Menu')->ztreeNode();
        return view('admin.widget.menumap', compact('zTreeNode'));
    }

}