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
// 微信小程序静默登录
Route::post('/login/wechatMini', 'LoginController@wechatMini');
// 微信小程序手机号登录
Route::post('/login/wechatMiniMobile', 'LoginController@wechatMiniMobile');
// 微信公众号授权登录
Route::get('/login/wechat/oauth', 'LoginController@wechatLogin');
Route::get('/login/wechat/oauth/callback', 'LoginController@wechatLoginCallback')->name('api.v2.login.wechat.callback');
// 社交登录
Route::get('/login/socialite/{app}', 'LoginController@socialiteLogin');
Route::get('/login/socialite/{app}/callback', 'LoginController@socialiteLoginCallback')->name('api.v2.login.socialite.callback');

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

// 公告
Route::get('/announcement/latest', 'AnnouncementController@latest');
Route::get('/announcement/list', 'AnnouncementController@list');

// 优惠码检测
Route::get('/promoCode/{code}', 'PromoCodeController@detail');

Route::group(['prefix' => 'other'], function () {
    // 系统常用配置
    Route::get('/config', 'OtherController@config');
});

// ViewBlock装修模块
Route::get('/viewBlock/page/blocks', 'ViewBlockController@pageBlocks');

Route::group(['middleware' => ['auth:apiv2', 'api.login.status.check']], function () {
    Route::post('/order/course', 'OrderController@createCourseOrder');
    Route::post('/order/role', 'OrderController@createRoleOrder');
    Route::post('/order/video', 'OrderController@createVideoOrder');

    Route::post('/order/payment/wechat/mini', 'PaymentController@wechatMiniPay');
    Route::get('/order/pay/redirect', 'PaymentController@payRedirect');
    Route::get('/order/payments', 'PaymentController@payments');

    Route::get('/promoCode/{code}/check', 'PromoCodeController@checkCode');

    Route::group(['prefix' => 'member'], function () {
        Route::get('detail', 'MemberController@detail');
        Route::post('detail/password', 'MemberController@passwordChange');
        Route::post('detail/avatar', 'MemberController@avatarChange');
        Route::post('detail/nickname', 'MemberController@nicknameChange');
        Route::post('detail/mobile', 'MemberController@mobileChange');
        Route::get('courses', 'MemberController@courses');
        Route::get('courses/like', 'MemberController@likeCourses');
        Route::get('courses/history', 'MemberController@learnHistory');
        Route::get('videos', 'MemberController@videos');
        Route::get('orders', 'MemberController@orders');
        Route::get('roles', 'MemberController@roles');
        Route::get('messages', 'MemberController@messages');
        Route::get('inviteBalanceRecords', 'MemberController@inviteBalanceRecords');
        Route::get('inviteUsers', 'MemberController@inviteUsers');
        Route::get('withdrawRecords', 'MemberController@withdrawRecords');
        Route::post('withdraw', 'MemberController@createWithdraw');
        Route::get('promoCode', 'MemberController@promoCode');
        Route::post('promoCode', 'MemberController@generatePromoCode');
        Route::get('notificationMarkAsRead/{notificationId}', 'MemberController@notificationMarkAsRead');
        Route::get('notificationMarkAllAsRead', 'MemberController@notificationMarkAllAsRead');
        Route::get('unreadNotificationCount', 'MemberController@unreadNotificationCount');
        Route::get('credit1Records', 'MemberController@credit1Records');
        Route::get('profile', 'MemberController@profile');
        Route::post('profile', 'MemberController@profileUpdate');
    });

    // 上传图片
    Route::post('/upload/image', 'UploadController@image');
});
