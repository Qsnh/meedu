<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

Route::get('/captcha/image', 'CaptchaController@imageCaptcha');
// 发送手机验证码
Route::post('/captcha/sms', 'CaptchaController@sentSms');
// 手机短信注册
Route::post('/register/sms', 'RegisterController@smsHandler');
// 密码重置
Route::post('/password/reset', 'PasswordController@reset');
// 密码登录
Route::post('/login/password', 'LoginController@passwordLogin');
// 手机号登录
Route::post('/login/mobile', 'LoginController@mobileLogin');
// 微信公众号扫码登录
Route::get('/login/wechatScan', 'LoginController@wechatScan');
Route::get('/login/wechatScan/query', 'LoginController@wechatScanQuery');
// 微信公众号授权登录
Route::get('/login/wechat/oauth', 'LoginController@wechatLogin')->middleware(['deprecated.api']);
Route::get('/login/wechat/oauth/callback', 'LoginController@wechatLoginCallback')->name('api.v2.login.wechat.callback');
// 社交登录
Route::get('/login/socialite/{app}', 'LoginController@socialiteLogin')->middleware(['deprecated.api']);
Route::get('/login/socialite/{app}/callback', 'LoginController@socialiteLoginCallback')->name('api.v2.login.socialite.callback');
// 安全退出
Route::post('/logout', 'LoginController@logout')->middleware(['auth:apiv2']);

// 课程搜索
Route::get('/search', 'SearchController@index');

// 课程
Route::get('/courses', 'CourseController@paginate');
Route::get('/course/{id}', 'CourseController@detail');
Route::get('/course/{id}/comments', 'CourseController@comments');
Route::post('/course/{id}/comment', 'CourseController@createComment')->middleware(['auth:apiv2']);
Route::get('/course/{id}/like', 'CourseController@like')->middleware(['auth:apiv2']);
Route::get('/course/attach/{id}/download', 'CourseController@attachDownload')->middleware(['auth:apiv2']);
// 全部课程分类
Route::get('/course_categories', 'CourseCategoryController@all');

// 视频
Route::get('/videos', 'VideoController@paginate');
Route::get('/video/{id}', 'VideoController@detail');
Route::get('/video/{id}/playinfo', 'VideoController@playInfo')->middleware(['auth:apiv2']);
Route::get('/video/open/play', 'VideoController@openPlay');
Route::get('/video/{id}/comments', 'VideoController@comments');
Route::post('/video/{id}/comment', 'VideoController@createComment')->middleware(['auth:apiv2']);
Route::post('/video/{id}/record', 'VideoController@recordVideo')->middleware(['auth:apiv2']);

// 套餐
Route::get('/roles', 'RoleController@roles');
Route::get('/role/{id}', 'RoleController@detail');

// 幻灯片
Route::get('/sliders', 'SliderController@all');

// 友情链接
Route::get('/links', 'LinkController@all');

// 首页导航
Route::get('/navs', 'NavController@all');

// 公告
Route::get('/announcement/latest', 'AnnouncementController@latest');
Route::get('/announcement/{id}', 'AnnouncementController@detail');
Route::get('/announcements', 'AnnouncementController@list');

// 优惠码检测
Route::get('/promoCode/{code}', 'PromoCodeController@detail');

Route::group(['prefix' => 'other'], function () {
    // 系统常用配置
    Route::get('/config', 'OtherController@config');
});

// ViewBlock装修模块
Route::get('/viewBlock/page/blocks', 'ViewBlockController@pageBlocks');

// 微信公众号授权绑定回调
Route::get('wechatBind/callback', 'MemberController@wechatBindCallback')->name('api.v2.wechatBind.callback')->middleware(['deprecated.api']);
// 社交账号绑定回调
Route::get('socialite/{app}/bind/callback', 'MemberController@socialiteBindCallback')->name('api.v2.socialite.bind.callback')->middleware(['deprecated.api']);

Route::group(['middleware' => ['auth:apiv2', 'api.login.status.check']], function () {
    // 创建录播课程订单
    Route::post('/order/course', 'OrderController@createCourseOrder');
    // 创建VIP订单
    Route::post('/order/role', 'OrderController@createRoleOrder');
    // 订单状态查询
    Route::get('/order/status', 'OrderController@queryStatus');

    // 跳转到第三方平台支付[如：支付宝web支付]
    Route::get('/order/pay/redirect', 'PaymentController@payRedirect');
    // 手动打款支付
    Route::get('/order/pay/handPay', 'PaymentController@handPay');
    // 微信扫码支付
    Route::post('/order/pay/wechatScan', 'PaymentController@wechatScan');
    // 获取可用支付网关
    Route::get('/order/payments', 'PaymentController@payments');

    // 检测是否可以使用promoCode
    Route::get('/promoCode/{code}/check', 'PromoCodeController@checkCode');

    Route::post('/upload/image', 'UploadController@image');

    Route::group(['prefix' => 'member'], function () {
        // 用户详情
        Route::get('detail', 'MemberController@detail');
        // 密码修改
        Route::post('detail/password', 'MemberController@passwordChange');
        // 头像修改
        Route::post('detail/avatar', 'MemberController@avatarChange');
        // 昵称修改
        Route::post('detail/nickname', 'MemberController@nicknameChange');
        // 手机号绑定[未绑定情况下]
        Route::post('detail/mobile', 'MemberController@mobileBind');
        // 更换手机号
        Route::put('mobile', 'MemberController@mobileChange');
        // 我的录播课
        Route::get('courses', 'MemberController@courses');
        // 录播课程收藏
        Route::get('courses/like', 'MemberController@likeCourses');
        // 录播课程学习历史
        Route::get('courses/history', 'MemberController@learnHistory');
        // 我的录播视频
        Route::get('videos', 'MemberController@videos');
        // 我的订单
        Route::get('orders', 'MemberController@orders');
        // 我的VIP记录
        Route::get('roles', 'MemberController@roles');
        // 我的消息
        Route::get('messages', 'MemberController@messages');
        // 消息已读
        Route::get('notificationMarkAsRead/{notificationId}', 'MemberController@notificationMarkAsRead');
        // 消息全部已读
        Route::get('notificationMarkAllAsRead', 'MemberController@notificationMarkAllAsRead');
        // 未读消息数量
        Route::get('unreadNotificationCount', 'MemberController@unreadNotificationCount');
        // 积分明细
        Route::get('credit1Records', 'MemberController@credit1Records');
        // 我的资料
        Route::get('profile', 'MemberController@profile');
        Route::post('profile', 'MemberController@profileUpdate');
        // 安全校验[手机号]
        Route::post('verify', 'MemberController@verify');
        // 微信扫码登录绑定
        Route::get('wechatScan/bind', 'MemberController@wechatScanBind');
        // 社交账号取消绑定
        Route::delete('socialite/{app}', 'MemberController@socialiteCancelBind');
        // 社交账号绑定
        Route::get('socialite/{app}', 'MemberController@socialiteBind')->middleware(['deprecated.api']);
        // 微信公众号授权绑定
        Route::get('wechatBind', 'MemberController@wechatBind')->middleware(['deprecated.api']);
    });
});
