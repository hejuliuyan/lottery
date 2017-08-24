<div class="sidebar-wrap">
    <div class="sidebar-title">
        <h1>{{trans('left.menu')}}</h1>
    </div>
    <div class="sidebar-content">
        <ul class="sidebar-list">
            <li><a class="openPopover"><i class="icon-font">&#xe050;</i>{{trans('left.product')}}</a>
                <ul class="sub-menu hidd">
                    <li><a href="/index.php/ad_kjlist"><i class="icon-font">
                                &#xe005;</i>{{--开奖列表--}}{{trans('left.pro.kj')}}</a></li>
                    <li><a href="/index.php/zj_win"><i class="icon-font">&#xe005;</i>{{trans('left.pro.zjjg')}}</a></li>
                    <li><a href="/index.php/advert_pic"><i class="icon-font">&#xe017;</i>{{trans('left.pro.guangg')}}
                        </a></li>

                </ul>
            </li>
            <li><a class="openPopover"><i class="icon-font">&#xe014;</i>{{trans('left.member_list')}}</a>
                <ul class="sub-menu hidd">
                    <li><a href="/index.php/ad_members"><i class="icon-font">&#xe005;</i>{{trans('left.mem.list')}}</a>
                    </li>
                </ul>
            </li>
            <li><a class="openPopover"><i class="icon-font">&#xe040;</i>{{trans('left.shop_mgt')}}</a>
                <ul class="sub-menu hidd">
                    <li><a href="/index.php/ad_shop"><i class="icon-font">&#xe005;</i>{{trans('left.shop.list')}}</a>
                    </li>
                </ul>
            </li>
            <li><a class="openPopover"><i class="icon-font">&#xe00b;</i>{{trans('left.Finance')}}</a>
                <ul class="sub-menu hidd">
                    {{--<li><a href="/index.php/ad_flat_show"><i class="icon-font">&#xe008;</i>{{trans('left.fin.flat_show')}}</a></li>
                    <li><a href="/index.php/ad_platform_show"><i class="icon-font">&#xe008;</i>{{trans('left.fin.flat_list')}}</a></li>--}}
                    <li><a href="/index.php/ad_personal_show"><i class="icon-font">
                                &#xe008;</i>{{trans('left.fin.mem_list')}}</a></li>
                    <li><a href="/index.php/ad_shopmoney_show"><i class="icon-font">
                                &#xe008;</i>{{trans('left.fin.shop_list')}}</a></li>
                </ul>
            </li>
            <li><a class="openPopover"><i class="icon-font">&#xe031;</i>{{trans('left.order_mgt')}}</a>
                <ul class="sub-menu  hidd">
                    <li><a href="/index.php/ad_order_list"><i class="icon-font">&#xe005;</i>{{trans('left.order.list')}}
                        </a></li>
                </ul>
            </li>
            <li><a class="openPopover"><i class="icon-font">&#xe018;</i>{{trans('left.system_mgt')}}</a>
                <ul class="sub-menu  hidd">
                    <li><a href="/index.php/ad_user"><i class="icon-font">&#xe014;</i>{{trans('left.system.users')}}</a>
                    </li>
                    <li><a href="/index.php/ad_role"><i class="icon-font">&#xe015;</i>{{trans('left.system.roles')}}</a>
                    </li>
                    <li><a href="/index.php/ad_per"><i class="icon-font">&#xe016;</i>{{trans('left.system.per')}}</a>
                    </li>
                    {{--<li><a href="/index.php/explain"><i class="icon-font">&#xe016;</i>使用说明</a>
                    </li>--}}
                </ul>
            </li>


        </ul>
    </div>
</div>