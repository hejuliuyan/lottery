<?php
// 前端
Route::get('/', 'Home\IndexController@index');
Route::get('/lists', 'Home\IndexController@lists');
Route::get('/cpdlt_time', 'Home\HiscpController@cpdlt_time'); // 大乐透开奖时间
Route::get('/cpdlt_endtime', 'Home\HiscpController@cpdlt_endtime'); // 大乐透停售时间
Route::get('/cplist', 'Home\HiscpController@index'); // 开奖信息
Route::get('/cpdlt', 'Home\HiscpController@cpdlt'); // 大乐透开奖历史
Route::post('/register', 'Home\RegisterController@reg'); // 注册
Route::post('/login', 'Home\RegisterController@login'); // 登录
Route::post('/shop_login', 'Home\RegisterController@shop_login'); // 店铺登录
Route::post('/personaluser', 'Home\ContentController@user'); // 个人账号检查
Route::post('/shop_per', 'Home\ContentController@shop_per'); // 店铺账号检查
Route::post('/update_shop_info', 'Home\ContentController@update_shop_info'); // 完善店铺信息
Route::post('/personal', 'Home\ContentController@personal'); // 个人信息插入
Route::post('/shopslists', 'Home\ShopsController@lists'); // 店铺列表
Route::post('/info_d', 'Home\ContentController@info_d'); // 读取用户默认彩店
Route::post('/order', 'Home\OrderController@order'); // 创建订单
Route::post('/order_tz_type', 'Home\OrderController@order_tz_type'); // 创建订单
Route::post('/order_detail', 'Home\OrderController@order_detail'); // 读取订单详情
Route::post('/updorder', 'Home\OrderController@updorder'); // 修改订单
Route::post('/order_bank', 'Home\OrderController@order_bank'); // 银联支付
Route::post('/shop_order', 'Home\ShopController@shop_order'); // 读取店铺订单
Route::post('/shop_status', 'Home\ShopController@shop_status'); // 读取店铺状态
Route::post('/jd_order', 'Home\ShopController@jd_order'); // 读取店铺状态
Route::post('/cp_detail', 'Home\ShopController@cp_detail'); // 出票信息查询
Route::post('/cp_detail_num', 'Home\ShopController@cp_detail_num'); // (单独)出票信息查询彩票号码
Route::post('/cp_status', 'Home\ShopController@cp_status'); // (单独)出票信息查询彩票号码
Route::post('/pd_shop_status', 'Home\ShopController@pd_shop_status'); // 判断店铺上下线状态
Route::post('/new_order', 'Home\ShopController@new_order'); // 查找最新的订单
Route::post('/order_wait', 'Home\ShopController@order_wait'); // 读取店铺待接订单
Route::post('/pj_wait', 'Home\ShopController@pj_wait'); // 读取派奖订单
Route::post('/shop_open', 'Home\ShopController@shop_open'); // 查找店铺openid
Route::post('/cp_nums', 'Home\ShopController@cp_nums'); // 改变店铺出票次数
Route::get('/wx', 'Home\WxController@index'); // 微信授权
Route::get('/wx_token', 'Home\WxController@wx_token'); // 微信授权
Route::post('/send', 'Home\WxController@send'); // 微信推送
Route::post('/jdk', 'Home\WxController@jdk'); // 微信jdk
Route::post('/wxlogin', 'Home\WxController@wxlogin'); // 判断微信是否登录
Route::post('/wx_upload', 'Home\WxController@wx_upload'); // 微信上传图片
Route::post('/wx_upload_licence', 'Home\WxController@wx_upload_licence'); // 代销证微信上传图片
Route::post('/orderlog', 'Home\OrderController@orderlog'); // 把用户的订单日志写到库里
Route::post('/odetail_log', 'Home\OrderController@odetail_log'); // 把订单日志读取出来
Route::post('/wx_name', 'Home\WxController@wx_name'); // 微信获取用户信息
Route::get('/show_pic', 'Home\WxController@show_pic'); // 微信获取用户信息
Route::post('/cp_qi', 'Home\OrderController@cp_qi'); // 获得当期彩票的期数
Route::post('/update_pass', 'Home\RegisterController@update_pass'); // 修改密码
Route::post('/is_pay_psd', 'Home\RegisterController@is_pay_psd'); // 支付密码
Route::post('/pay_psd_add', 'Home\RegisterController@pay_psd_add'); // 支付密码新建
Route::post('/pay_psd_saves', 'Home\RegisterController@pay_psd_saves'); // 支付密码修改

Route::post('/do_pay_psd', 'Home\RegisterController@do_pay_psd'); // 用户支付验证
Route::post('/dosp_pay_psd', 'Home\RegisterController@dosp_pay_psd'); // 店铺支付验证
Route::post('/has_pay_psd', 'Home\RegisterController@has_pay_psd'); // 判断支付密码是否设置
Route::post('/Additional', 'Home\MycashboxController@Additional'); // 判断支付密码是否设置

Route::post('/personal_check', 'Home\RegisterController@personal_check'); // 身份完善检查
Route::post('/shop_check', 'Home\RegisterController@shop_check'); // 店铺身份完善检查
Route::post('/tz_record', 'Home\RegisterController@tz_record'); // 投注记录
Route::post('/award_record', 'Home\RegisterController@award_record'); // 中奖记录
Route::post('/out_order', 'Home\OrderController@out_order'); // 用户退单
Route::post('/shop_search', 'Home\OrderController@shop_search'); // 查找店铺openid
Route::post('/save_case', 'Home\RegisterController@save_case'); // 保存方案
Route::post('/save_search', 'Home\RegisterController@save_search'); // 查询方案
Route::post('/save_detail', 'Home\RegisterController@save_detail'); // 方案详情
Route::post('/save_del', 'Home\RegisterController@save_del'); // 方案删除
Route::post('/save_detail_num', 'Home\RegisterController@save_detail_num'); // 方案详情号码
Route::get('/mywallet', 'Home\MywalletController@index'); // 个人->我的钱包显示
Route::post('/get_shops', 'Home\MywalletController@get_shops'); // 个人->我的钱包获取店铺列表
Route::get('/mywallet_info', 'Home\MywalletController@info'); // 个人->我的钱包详情页
Route::post('/mywallet_wd', 'Home\MywalletController@wd'); // 个人->我的钱包提现
Route::get('/has_balance', 'Home\MywalletController@has_balance'); // 个人->我的钱包获取默认店铺余额

Route::post('/mywallet_up', 'Home\MywalletController@up'); // 个人->我的钱包充值

Route::get('/mycashbox', 'Home\MycashboxController@index'); // 店铺->我的钱箱显示
Route::get('/mycashbox_info', 'Home\MycashboxController@info'); // 个人->我的钱箱详情页
Route::post('/mycashbox_wd', 'Home\MycashboxController@wd'); // 个人->我的钱箱提现
Route::post('/mycashbox_up', 'Home\MycashboxController@up'); // 个人->我的钱箱充值

Route::get('/index_pic', 'Home\IndexController@pic'); // 首页广告图片轮播

Route::post('/save_total', 'Home\RegisterController@save_total'); // 计算可下拉次数
Route::post('/shop_phone', 'Home\OrderController@shop_phone'); // 查询店铺电话
Route::post('/user_balance', 'Home\OrderController@user_balance'); // 查询用户余额
Route::post('/shop_balance', 'Home\ShopController@shop_balance'); // 查询店铺余额
Route::post('/order_balance', 'Home\OrderController@order_balance'); // 支付
Route::post('/order_yes', 'Home\OrderController@order_yes'); // 支付成功页面
Route::post('/order_no', 'Home\OrderController@order_no'); // 退单成功页面
Route::post('/order_paj', 'Home\OrderController@order_paj'); // 派奖成功页面
Route::post('/order_check', 'Home\OrderController@order_check'); // 查询订单状态
Route::post('/cp_rk', 'Home\OrderController@cp_rk'); // 出票入库
Route::post('/order_more', 'Home\OrderController@order_more'); // 再来一单
Route::post('/serach_orderid', 'Home\OrderController@serach_orderid'); // 搜索订单号
Route::post('/order_reset', 'Home\OrderController@order_reset'); // 重新下单
Route::post('/token_check', 'Home\WxController@token_check'); // 用户端检查
Route::post('/shopid_check', 'Home\WxController@shopid_check'); // 店铺端检查
Route::post('/get_phone', 'Home\RegisterController@get_phone'); // 获取用户手机号
Route::post('/myshop', 'Home\RegisterController@myshop'); // 我的店铺显示
Route::post('/set_shop', 'Home\RegisterController@set_shop'); //设置彩店
Route::post('/mr_shop', 'Home\RegisterController@mr_shop'); //显示默认店铺
Route::post('/c_shop', 'Home\RegisterController@c_shop'); //显示选择店铺
Route::post('/search_shop', 'Home\RegisterController@search_shop'); //搜索彩店
Route::post('/update_shop', 'Home\RegisterController@update_shop'); //扫描绑定店铺
Route::post('/session_shop', 'Home\RegisterController@session_shop'); //正常登陆加店铺session
Route::post('/index_title', 'Home\RegisterController@index_title'); //首页标题
Route::post('/search_user_balance', 'Home\RegisterController@search_user_balance'); //用户个人中心余额查询
Route::post('/pd_shop_search', 'Home\RegisterController@pd_shop_search'); //判断是否扫码
Route::get('/mid', 'Home\WxController@middle'); // 微信授权
Route::post('/pic_upload', 'Home\WxController@pic_upload'); //
Route::post('/shop_login_app', 'Home\RegisterController@shop_login_app'); //APP登录
Route::post('/reg_app', 'Home\RegisterController@reg_app'); //APP注册


Route::post('zj_num_home', 'Admin\ZjController@zj_num'); // 获取该期中奖号码
Route::post('zj_detail_home', 'Admin\ZjController@zj_detail'); // 获取中奖详情
// 后端


Route::get('ad_kjsearch', 'Admin\KjController@search'); // 检索 暂时没用


Route::get('login', 'Admin\LoginController@index'); // 后台登陆页面(后台)
Route::post('do_login', 'Admin\LoginController@do_login'); // 后台登陆验证(后台)
Route::get('log_out', 'Admin\LoginController@out'); // 推出登录(后台)
Route::post('zj_total_home', 'Admin\ZjController@zj_total'); // 获取该单中奖总金额
Route::post('shop_balance_pays', 'Admin\ZjController@shop_balance_pay'); // 店铺派奖余额支付
Route::post('shop_banks', 'Admin\ZjController@shop_bank'); // 店铺派奖银联支付
Route::get('get_chart_lotto', 'Home\ChartController@lotto'); //获取大乐透走势图
Route::post('my_customer', 'Home\MycashboxController@customer'); //店铺对应用户
Route::post('test', 'Home\MycashboxController@test'); //店铺对应用户
Route::post('explain_edit', 'Admin\IndexController@explain_edit');//说明修改
Route::get('explain', 'Admin\IndexController@explain');//说明修改

Route::post('get_loc', 'Home\IndexController@get_loc');

/**
 * 帮助手册
 * zhou
 * date 2016/9/7
 */
Route::get('help', function () {
    return view('admin.help.index');
});

Route::group(['prefix' => 'help'], function () {
    Route::get('kj_list', function () {
        return view('admin.help.kj_list');
    });
    Route::get('zj_handle', function () {
        return view('admin.help.zj_handle');
    });
    Route::get('banner', function () {
        return view('admin.help.banner');
    });
    Route::get('member_list', function () {
        return view('admin.help.member_list');
    });
    Route::get('shop_list', function () {
        return view('admin.help.shop_list');
    });
    Route::get('personal_m', function () {
        return view('admin.help.personal_m');
    });
    Route::get('shop_m', function () {
        return view('admin.help.shop_m');
    });
    Route::get('order_list', function () {
        return view('admin.help.order_list');
    });
    Route::get('user', function () {
        return view('admin.help.user');
    });
    Route::get('role', function () {
        return view('admin.help.role');
    });
    Route::get('per', function () {
        return view('admin.help.per');
    });
    Route::get('edit', function () {
        return view('admin.help.edit');
    });
    Route::get('index', function () {
        return view('admin.help.index');
    });

});

/**
 * 后台管理路由
 */
$router->group(['namespace' => 'Admin', 'middleware' => ['authAdmin']], function () {


    Route::get('ad_index', ['as' => 'admin_index', 'uses' => 'IndexController@index']); // 欢迎界面(后台)

    Route::get('lang', ['as' => 'Language', 'uses' => 'LanguageController@swap']);//语言切换

    /**
     * 开奖处理
     */
    Route::get('ad_kjlist', ['as' => 'admin_kj_index', 'uses' => 'KjController@index']); // 开奖列表显示
    Route::get('ad_kjedit', ['as' => 'admin_kj_edit', 'uses' => 'KjController@edit']); // 开奖结果编辑
    Route::get('ad_kjdel', ['as' => 'admin_kj_del', 'uses' => 'KjController@del']); // 开奖结果删除
    Route::get('ad_kjadd', ['as' => 'admin_kj_add', 'uses' => 'KjController@add']); // 增加开奖结果
    Route::post('ad_kjsave', ['as' => 'admin_kj_saves', 'uses' => 'KjController@saves']); // 开奖结果保存
    Route::post('ad_kjnews', ['as' => 'admin_kj_kjnews', 'uses' => 'KjController@ad_kjnews']); // 发布开奖结果
    Route::post('mon_saves', ['as' => 'admin_kj_mon_saves', 'uses' => 'KjController@mon_saves']); // 当期开奖金额
    Route::post('mon_lists', ['as' => 'admin_kj_mon_lists', 'uses' => 'KjController@mon_lists']); // 当期开奖金额列表
    Route::post('mon_edit', ['as' => 'admin_kj_mon_edit', 'uses' => 'KjController@mon_edit']); // 当期开奖金额修改
    Route::get('mon_del', ['as' => 'admin_kj_mon_del', 'uses' => 'KjController@mon_del']); // 当期开奖金额列表删除

    /**
     * 中奖处理
     */
    Route::get('zj_win', ['as' => 'admin_zj_index', 'uses' => 'ZjController@index']); // 中奖结果处理页面
    Route::post('do_zj', ['as' => 'admin_zj_do_zj', 'uses' => 'ZjController@do_zj']); // 中奖结果比对
    Route::post('zj_send', ['as' => 'admin_zj_send', 'uses' => 'ZjController@zj_send']); // 中奖用户推送
    Route::post('zj_num', ['as' => 'admin_zj_num', 'uses' => 'ZjController@zj_num']); // 获取该期中奖号码
    Route::post('zj_detail', ['as' => 'admin_zj_detail', 'uses' => 'ZjController@zj_detail']); // 获取中奖详情
    Route::post('zj_total', ['as' => 'admin_zj_total', 'uses' => 'ZjController@zj_total']); // 获取该单中奖总金额
    Route::post('shop_bank', ['as' => 'admin_zj_shop_bank', 'uses' => 'ZjController@shop_bank']); // 店铺派奖银联支付
    Route::post('shop_balance_pay', ['as' => 'admin_zj_shop_balance_pay', 'uses' => 'ZjController@shop_balance_pay']); // 店铺派奖余额支付


    /**
     * 店铺列表
     */
    Route::get('ad_shop', ['as' => 'admin_shop_index', 'uses' => 'ShopController@index']);// 后台店铺列表显示
    Route::get('ad_spedit', ['as' => 'admin_shop_edit', 'uses' => 'ShopController@edit']); // 后台店铺修改页面
    Route::post('ad_shop_search', ['as' => 'admin_shop_search', 'uses' => 'ShopController@search']); // 后台店铺列表检索
    Route::get('ad_shop_add', ['as' => 'admin_shop_add', 'uses' => 'ShopController@add']); // 店铺添加
    Route::get('ad_shop_del', ['as' => 'admin_shop_del', 'uses' => 'ShopController@del']); // 后台店铺删除
    Route::post('ad_spsaves', ['as' => 'admin_shop_saves', 'uses' => 'ShopController@saves']); // 后台店铺修改执行
    Route::post('ad_shop_pic', ['as' => 'admin_shop_pic_del', 'uses' => 'ShopController@pic_del']); // 后台店铺代销证删除
    Route::get('ad_shop_show', ['as' => 'admin_shop_show', 'uses' => 'FinancialController@shop_show']); // 后台->店铺帐务一览

    /**
     * 广告图片管理
     */
    Route::get('advert_pic', ['as' => 'admin_advert_index', 'uses' => 'AdvertController@index']); // 轮播图片首页
    Route::get('advert_pic_save', ['as' => 'admin_advert_save', 'uses' => 'AdvertController@save']); // 轮播图片状态修改
    Route::post('advert_picadd', ['as' => 'admin_advert_add', 'uses' => 'AdvertController@add']); // 轮播图片添加
    Route::get('advert_picdel', ['as' => 'admin_advert_del', 'uses' => 'AdvertController@del']); // 轮播图片删除

    /**
     * 财务管理
     */
    Route::get('ad_platform_show', ['as' => 'admin_platform_show', 'uses' => 'FinancialController@platform_show']); // 后台->平台财务->显示
    Route::get('ad_platform_export', ['as' => 'admin_export_platform', 'uses' => 'FinancialController@export_platform']); // 后台->平台财务->导出
    Route::get('ad_personal_show', ['as' => 'admin_personal_show', 'uses' => 'FinancialController@personal_show']); // 后台->个人财务->显示
    Route::get('ad_export_personal', ['as' => 'admin_export_personal', 'uses' => 'FinancialController@export_personal']); // 后台->个人财务->导出
    Route::get('ad_shopmoney_show', ['as' => 'admin_shop_money', 'uses' => 'FinancialController@shop_money']); // 后台->商铺财务->显示
    Route::get('ad_export_shop', ['as' => 'admin_export_shop', 'uses' => 'FinancialController@export_shop']); // 后台->商铺财务->导出
    Route::get('ad_flat_show', ['as' => 'admin_flat_show', 'uses' => 'FinancialController@flat_show']); // 后台->平台账户一览


    /**
     * 会员管理
     */
    Route::get('ad_members', ['as' => 'admin_mem_members', 'uses' => 'MemController@ad_members']); // 会员管理页面
    Route::post('mem_update', ['as' => 'admin_mem_update', 'uses' => 'MemController@mem_update']); // 会员修改
    Route::post('mem_search', ['as' => 'admin_mem_search', 'uses' => 'MemController@mem_search']); // 会员检索
    Route::get('mem_edit_view', ['as' => 'admin_mem_edit_view', 'uses' => 'MemController@mem_edit_view']); // 会员编辑页面
    Route::get('ad_member_show', ['as' => 'admin_member_show', 'uses' => 'FinancialController@member_show']); // 后台->个人帐务一览

    /**
     * 订单管理
     */
    Route::get('ad_order', ['as' => 'admin_order', 'uses' => 'OrderController@ad_order']); // 订单详情
    Route::get('ad_order_list', ['as' => 'admin_order_list', 'uses' => 'OrderlistController@index']); // 订单列表
    Route::post('update_total', ['as' => 'admin_order_update_total', 'uses' => 'OrderController@update_total']); // 中奖总金额修改
    Route::post('order_detail_log', ['as' => 'admin_order_detail_log', 'uses' => 'OrderController@order_detail_log']); // 订单状态显示
    Route::post('user_out', ['as' => 'admin_order_user_out', 'uses' => 'OrderController@user_out']); // 用户退单(后台)

    /**
     * 管理员管理
     */
    Route::get('ad_user', ['as' => 'admin_user_index', 'uses' => 'UserController@index']); // 管理员管理(后台)
    Route::get('ad_user_up', ['as' => 'admin_user_edit', 'uses' => 'UserController@edit']); // 管理员修改(后台)
    Route::post('ad_user_save', ['as' => 'admin_user_save', 'uses' => 'UserController@save']); // 管理员修改(后台)
    Route::get('ad_user_del', ['as' => 'admin_user_del', 'uses' => 'UserController@del']); // 管理员删除(后台)
    Route::get('ad_user_add', ['as' => 'admin_user_add', 'uses' => 'UserController@add']); // 管理员添加(后台)
    Route::post('ad_user_doadd', ['as' => 'admin_user_doadd', 'uses' => 'UserController@doadd']); // 管理员添加(后台)
    Route::get('ad_user_role', ['as' => 'admin_user_role', 'uses' => 'UserController@role']); // 管理员角色分配(后台)
    Route::post('ad_user_add_r', ['as' => 'admin_user_role', 'uses' => 'UserController@add_role']);//用户管理角色分配保存(后台)

    /**
     * 角色管理
     */
    Route::get('ad_role', ['as' => 'admin_role_index', 'uses' => 'RoleController@index']); // 角色管理首页(后台)
    Route::get('ad_role_add', ['as' => 'admin_role_create', 'uses' => 'RoleController@create']); // 角色管理添加页面(后台)
    Route::post('ad_role_doadd', ['as' => 'admin_role_store', 'uses' => 'RoleController@store']); // 角色管理添加操作(后台)
    Route::get('ad_role_edit', ['as' => 'admin_role_edit', 'uses' => 'RoleController@edit']); // 角色管理修改页面(后台)
    Route::post('ad_role_save', ['as' => 'admin_role_save', 'uses' => 'RoleController@save']); // 角色管理修改操作(后台)
    Route::get('ad_role_del', ['as' => 'admin_role_destroy', 'uses' => 'RoleController@destroy']); // 角色管理删除操作(后台)
    Route::get('ad_role_per', ['as' => 'admin_role_per', 'uses' => 'RoleController@per']); // 角色管理权限分配(后台)
    Route::post('ad_role_add_per', ['as' => 'admin_role_doper', 'uses' => 'RoleController@doper']);//角色管理权限分配保存(后台)

    /**
     * 权限管理
     */
    Route::get('ad_per', ['as' => 'admin_per_index', 'uses' => 'PermissionController@index']); // 权限管理(后台)
    Route::get('ad_per_add', ['as' => 'admin_per_add', 'uses' => 'PermissionController@add']); // 权限添加管理(后台)
    Route::post('ad_per_doadd', ['as' => 'admin_per_store', 'uses' => 'PermissionController@store']); // 权限添加管理(后台)
    Route::get('ad_per_del', ['as' => 'admin_per_destroy', 'uses' => 'PermissionController@destroy']); // 权限管理删除(后台)
    Route::get('ad_per_edit', ['as' => 'admin_per_destroy', 'uses' => 'PermissionController@edit']); // 权限管理修改(后台)
    Route::post('ad_per_save', ['as' => 'admin_per_destroy', 'uses' => 'PermissionController@save']); // 权限管理修改保存(后台)

});

