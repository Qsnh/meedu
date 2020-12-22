<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

Route::get('/', 'Frontend\IndexController@index')->name('index')->middleware(['wechat.login']);
Route::redirect('/home', '/');
Route::get('/user/protocol', 'Frontend\IndexController@userProtocol')->name('user.protocol');
Route::get('/user/private_protocol', 'Frontend\IndexController@userPrivateProtocol')->name('user.private_protocol');
Route::get('/aboutus', 'Frontend\IndexController@aboutus')->name('aboutus');
// 登录
Route::get('/login', 'Frontend\LoginController@showLoginPage')->name('login');
Route::post('/login', 'Frontend\LoginController@passwordLoginHandler')->middleware(['throttle:30,1']);
// 注册
Route::get('/register', 'Frontend\RegisterController@showRegisterPage')->name('register');
Route::post('/register', 'Frontend\RegisterController@passwordRegisterHandler')->middleware(['sms.check', 'throttle:30,1']);
// 登出
Route::post('/logout', 'Frontend\LoginController@logout')->name('logout');
// 找回密码
Route::get('/password/reset', 'Frontend\ForgotPasswordController@showPage')->name('password.request');
Route::post('/password/reset', 'Frontend\ForgotPasswordController@handler')->middleware(['throttle:10,1', 'sms.check']);
// Auth Ajax
Route::group(['prefix' => 'ajax'], function () {
    Route::post('/auth/login/password', 'Frontend\AjaxController@passwordLogin')->name('ajax.login.password');
    Route::post('/auth/login/mobile', 'Frontend\AjaxController@mobileLogin')->name('ajax.login.mobile')->middleware(['sms.check']);
    Route::post('/auth/register', 'Frontend\AjaxController@register')->name('ajax.register')->middleware(['sms.check']);
    Route::post('/auth/password/reset', 'Frontend\AjaxController@passwordReset')->name('ajax.password.reset')->middleware(['sms.check']);
    Route::post('/auth/mobile/bind', 'Frontend\AjaxController@mobileBind')->name('ajax.mobile.bind')->middleware(['sms.check', 'auth']);
});

// 发送短信
Route::post('/sms/send', 'Frontend\SmsController@send')->name('sms.send');

// 第三方登录
Route::get('/login/{app}', 'Frontend\LoginController@socialLogin')->name('socialite');
Route::get('/login/{app}/callback', 'Frontend\LoginController@socialiteLoginCallback');

// 课程列表
Route::get('/courses', 'Frontend\CourseController@index')->name('courses')->middleware(['wechat.login']);
// 视频列表
Route::get('/videos', 'Frontend\VideoController@index')->name('videos')->middleware(['wechat.login']);
// 课程详情
Route::get('/course/{id}/{slug}', 'Frontend\CourseController@show')->name('course.show')->middleware(['wechat.login']);
Route::get('/course/attach/{id}/download', 'Frontend\CourseController@attachDownload')->name('course.attach.download')->middleware(['auth']);
// 视频详情
Route::get('/course/{course_id}/video/{id}/{slug}', 'Frontend\VideoController@show')->name('video.show')->middleware(['wechat.login']);
// 搜索
Route::get('/search', 'Frontend\SearchController@searchHandler')->name('search')->middleware(['wechat.login']);

// VIP
Route::get('/vip', 'Frontend\RoleController@index')->name('role.index')->middleware(['wechat.login']);
// 支付回调
Route::post('/payment/callback/{payment}', 'Frontend\PaymentController@callback')->name('payment.callback');

// 公告
Route::get('/announcement/{id}', 'Frontend\AnnouncementController@show')->name('announcement.show');

// 手机号绑定
Route::get('/member/mobile/bind', 'Frontend\MemberController@showMobileBindPage')->name('member.mobile.bind');
Route::post('/member/mobile/bind', 'Frontend\MemberController@mobileBindHandler')->middleware('sms.check');

Route::group([
    'prefix' => '/member',
    'middleware' => ['wechat.login', 'auth', 'login.status.check'],
    'namespace' => 'Frontend'
], function () {
    Route::get('/', 'MemberController@index')->name('member');

    Route::get('/password_reset', 'MemberController@showPasswordResetPage')->name('member.password_reset');
    Route::post('/password_reset', 'MemberController@passwordResetHandler');
    Route::get('/avatar', 'MemberController@showAvatarChangePage')->name('member.avatar');
    Route::post('/avatar', 'MemberController@avatarChangeHandler');
    Route::get('/join_role_records', 'MemberController@showJoinRoleRecordsPage')->name('member.join_role_records');
    Route::get('/messages', 'MemberController@showMessagesPage')->name('member.messages');
    Route::get('/courses', 'MemberController@showBuyCoursePage')->name('member.courses');
    Route::get('/course/videos', 'MemberController@showBuyVideoPage')->name('member.course.videos');
    Route::get('/orders', 'MemberController@showOrdersPage')->name('member.orders');
    Route::get('/socialite', 'MemberController@showSocialitePage')->name('member.socialite');
    Route::post('/socialite/{app}/delete', 'MemberController@cancelBindSocialite')->name('member.socialite.delete');
    Route::get('/promo_code', 'MemberController@showPromoCodePage')->name('member.promo_code');
    Route::post('/promo_code', 'MemberController@generatePromoCode');
    Route::post('/invite_balance_withdraw_orders', 'MemberController@createInviteBalanceWithdrawOrder');
    Route::get('/credit1_records', 'MemberController@credit1Records')->name('member.credit1_records');
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
