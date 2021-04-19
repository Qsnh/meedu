<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

Route::get('/', 'IndexController@index')->name('index');
Route::get('/user/protocol', 'IndexController@userProtocol')->name('user.protocol');
Route::get('/user/private_protocol', 'IndexController@userPrivateProtocol')->name('user.private_protocol');
Route::get('/aboutus', 'IndexController@aboutus')->name('aboutus');
// 登录
Route::get('/login', 'LoginController@showLoginPage')->name('login');
Route::post('/login', 'LoginController@passwordLoginHandler')->middleware(['throttle:30,1']);
// 微信公众号授权登录
Route::get('/login/wechat/oauth', 'LoginController@wechatLogin')->name('login.wechat.oauth');
Route::get('/login/wechat/oauth/callback', 'LoginController@wechatLoginCallback')->name('login.wechat.oauth.callback');
// 社交登录
Route::get('/login/{app}', 'LoginController@socialLogin')->name('socialite');
Route::get('/login/{app}/callback', 'LoginController@socialiteLoginCallback')->name('socialite.callback');
// 注册
Route::get('/register', 'RegisterController@showRegisterPage')->name('register');
Route::post('/register', 'RegisterController@passwordRegisterHandler')->middleware(['sms.check', 'throttle:30,1']);
// 找回密码
Route::get('/password/reset', 'ForgotPasswordController@showPage')->name('password.request');
Route::post('/password/reset', 'ForgotPasswordController@handler')->middleware(['throttle:10,1', 'sms.check']);

// Auth Ajax
Route::group(['prefix' => 'ajax'], function () {
    Route::post('/auth/login/password', 'AjaxController@passwordLogin')->name('ajax.login.password');
    Route::post('/auth/login/mobile', 'AjaxController@mobileLogin')->name('ajax.login.mobile')->middleware(['sms.check']);
    Route::post('/auth/register', 'AjaxController@register')->name('ajax.register')->middleware(['sms.check']);
    Route::post('/auth/password/reset', 'AjaxController@passwordReset')->name('ajax.password.reset')->middleware(['sms.check']);
    Route::post('/auth/mobile/bind', 'AjaxController@mobileBind')->name('ajax.mobile.bind')->middleware(['sms.check', 'auth']);
});

// 发送短信
Route::post('/sms/send', 'SmsController@send')->name('sms.send');

// 课程列表
Route::get('/courses', 'CourseController@index')->name('courses');
// 视频列表
Route::get('/videos', 'VideoController@index')->name('videos');
// 课程详情
Route::get('/course/{id}/{slug}', 'CourseController@show')->name('course.show');
Route::get('/course/attach/{id}/download', 'CourseController@attachDownload')->name('course.attach.download')->middleware(['auth']);
// 视频详情
Route::get('/course/{course_id}/video/{id}/{slug}', 'VideoController@show')->name('video.show');
// 搜索
Route::get('/search', 'SearchController@searchHandler')->name('search');

// VIP
Route::get('/vip', 'RoleController@index')->name('role.index');
// 支付回调
Route::post('/payment/callback/{payment}', 'PaymentController@callback')->name('payment.callback');

// 公告
Route::get('/announcement/{id}', 'AnnouncementController@show')->name('announcement.show');

Route::group([
    'prefix' => '/member',
    'middleware' => ['wechat.login', 'auth', 'login.status.check'],
], function () {
    // 安全登出
    Route::post('/logout', 'MemberController@logout')->name('logout');

    // 用户首页
    Route::get('/', 'MemberController@index')->name('member');

    // 手机号绑定
    Route::get('/mobile/bind', 'MemberController@showMobileBindPage')->name('member.mobile.bind');
    Route::post('/mobile/bind', 'MemberController@mobileBindHandler')->middleware('sms.check');

    // 密码重置
    Route::get('/password_reset', 'MemberController@showPasswordResetPage')->name('member.password_reset');
    Route::post('/password_reset', 'MemberController@passwordResetHandler');

    // 头像更换
    Route::get('/avatar', 'MemberController@showAvatarChangePage')->name('member.avatar');
    Route::post('/avatar', 'MemberController@avatarChangeHandler');

    // VIP会员购买记录
    Route::get('/join_role_records', 'MemberController@showJoinRoleRecordsPage')->name('member.join_role_records');

    // 我的消息
    Route::get('/messages', 'MemberController@showMessagesPage')->name('member.messages');

    // 我的点播课程
    Route::get('/courses', 'MemberController@showBuyCoursePage')->name('member.courses');

    // 我的点播视频
    Route::get('/course/videos', 'MemberController@showBuyVideoPage')->name('member.course.videos');

    // 我的订单
    Route::get('/orders', 'MemberController@showOrdersPage')->name('member.orders');

    // 社交登录
    Route::get('/socialite', 'MemberController@showSocialitePage')->name('member.socialite');
    Route::get('/socialite/{app}/bind', 'MemberController@socialiteBind')->name('member.socialite.bind');
    Route::get('/socialite/{app}/bind/callback', 'MemberController@socialiteBindCallback')->name('member.socialite.bind.callback');
    Route::post('/socialite/{app}/delete', 'MemberController@cancelBindSocialite')->name('member.socialite.delete');

    // 邀请码
    Route::get('/promo_code', 'MemberController@showPromoCodePage')->name('member.promo_code');
    Route::post('/promo_code', 'MemberController@generatePromoCode');
    Route::post('/invite_balance_withdraw_orders', 'MemberController@createInviteBalanceWithdrawOrder');
    Route::get('/credit1_records', 'MemberController@credit1Records')->name('member.credit1_records');

    // 我的资料
    Route::get('/profile', 'MemberController@showProfilePage')->name('member.profile');

    // 图片上传
    Route::post('/upload/image', 'UploadController@imageHandler')->name('upload.image');

    // 购买课程
    Route::get('/course/{id}/buy', 'CourseController@showBuyPage')->name('member.course.buy');
    Route::post('/course/{id}/buy', 'CourseController@buyHandler');

    // 购买视频
    Route::get('/video/{id}/buy', 'VideoController@showBuyPage')->name('member.video.buy');
    Route::post('/video/{id}/buy', 'VideoController@buyHandler');

    // 购买VIP
    Route::get('/vip/{id}/buy', 'RoleController@showBuyPage')->name('member.role.buy');
    Route::post('/vip/{id}/buy', 'RoleController@buyHandler');

    // 收银台
    Route::get('/order/pay/success', 'OrderController@success')->name('order.pay.success');
    Route::get('/order/pay', 'OrderController@pay')->name('order.pay');
    Route::get('/order/pay/wechat/{order_id}', 'OrderController@wechat')->name('order.pay.wechat');
    Route::get('/order/pay/handPay/{order_id}', 'OrderController@handPay')->name('order.pay.handPay');

    Route::group(['prefix' => 'ajax'], function () {
        Route::post('/course/{id}/comment', 'AjaxController@courseCommentHandler')->name('ajax.course.comment');
        Route::post('/video/{id}/comment', 'AjaxController@videoCommentHandler')->name('ajax.video.comment');
        Route::post('/video/{id}/watch/record', 'AjaxController@recordVideo')->name('ajax.video.watch.record');
        Route::post('/promoCodeCheck', 'AjaxController@promoCodeCheck')->name('ajax.promo_code.check');

        Route::post('/password/change', 'AjaxController@changePassword')->name('ajax.password.change');
        Route::post('/avatar/change', 'AjaxController@changeAvatar')->name('ajax.avatar.change');
        Route::post('/nickname/change', 'AjaxController@changeNickname')->name('ajax.nickname.change');
        Route::post('/message/read', 'AjaxController@notificationMarkAsRead')->name('ajax.message.read');
        Route::post('/inviteBalanceWithdraw', 'AjaxController@inviteBalanceWithdraw')->name('ajax.invite_balance.withdraw');
        Route::post('/course/like/{id}', 'AjaxController@likeACourse')->name('ajax.course.like');

        // 用户资料编辑
        Route::post('/member/profile', 'AjaxController@profileUpdate')->name('ajax.member.profile.update');
    });
});
