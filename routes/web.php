<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'Frontend\IndexController@index')->name('index');

Route::get('/login', 'Frontend\LoginController@showLoginPage')->name('login');
Route::post('/login', 'Frontend\LoginController@passwordLoginHandler')->middleware(['throttle:5,1']);

Route::get('/register', 'Frontend\RegisterController@showRegisterPage')->name('register');
Route::post('/register', 'Frontend\RegisterController@passwordRegisterHandler')->middleware(['throttle:5,1', 'sms.check']);

Route::post('/logout', 'Frontend\LoginController@logout')->name('logout');

Route::get('/password/reset', 'Frontend\ForgotPasswordController@showPage')->name('password.request');
Route::post('/password/reset', 'Frontend\ForgotPasswordController@handler')->middleware(['throttle:5,1', 'sms.check']);

// 发送短信
Route::post('/sms/send', 'Frontend\SmsController@send')->name('sms.send')->middleware(['image.captcha.check', 'throttle:5,1']);

// 第三方登录
Route::get('/login/{app}', 'Frontend\LoginController@socialLogin')->name('socialite');
Route::get('/login/{app}/callback', 'Frontend\LoginController@socialiteLoginCallback');

// 课程列表
Route::get('/courses', 'Frontend\CourseController@index')->name('courses');
// 视频列表
Route::get('/videos', 'Frontend\VideoController@index')->name('videos');
// 课程详情
Route::get('/course/{id}/{slug}', 'Frontend\CourseController@show')->name('course.show');
// 视频详情
Route::get('/course/{course_id}/video/{id}/{slug}', 'Frontend\VideoController@show')->name('video.show');
// 搜索
Route::get('/search', 'Frontend\SearchController@searchHandler')->name('search');

// VIP
Route::get('/vip', 'Frontend\RoleController@index')->name('role.index');
// 支付回调
Route::post('/payment/callback/{payment}', 'Frontend\PaymentController@callback')->name('payment.callback');

Route::group([
    'prefix' => '/member',
    'middleware' => ['auth'],
    'namespace' => 'Frontend'
], function () {
    Route::get('/', 'MemberController@index')->name('member');

    // 绑定手机号
    Route::get('/mobile/bind', 'MemberController@showMobileBindPage')->name('member.mobile.bind');
    Route::post('/mobile/bind', 'MemberController@mobileBindHandler')->middleware('sms.check');

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
    Route::get('/order/show/{order_id}', 'OrderController@show')->name('order.show');
    Route::any('/order/pay/{order_id}', 'OrderController@pay')->name('order.pay');
    Route::get('/order/pay/wechat/{order_id}', 'OrderController@wechat')->name('order.pay.wechat');
    Route::get('/order/pay/handPay/{order_id}', 'OrderController@handPay')->name('order.pay.handPay');

    Route::group(['prefix' => 'ajax'], function () {
        Route::post('/course/{id}/comment', 'AjaxController@courseCommentHandler')->name('ajax.course.comment');
        Route::post('/video/{id}/comment', 'AjaxController@videoCommentHandler')->name('ajax.video.comment');
    });
});


Route::group(['prefix' => '/backend', 'namespace' => 'Backend'], function () {
    Route::get('/video/upload/aliyun', 'VideoUploadController@aliyun');
    Route::get('/video/upload/tencent', 'VideoUploadController@tencent');
});