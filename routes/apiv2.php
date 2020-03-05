<?php


// 图形验证码
Route::get('/captcha/image', 'CaptchaController@imageCaptcha');
// 发送手机验证码
Route::post('/captcha/sms', 'CaptchaController@sentSms');

// 密码登录
Route::post('/login/password', 'LoginController@passwordLogin');
Route::post('/login/mobile', 'LoginController@mobileLogin');
// 手机号注册
Route::post('/register/mobile', 'RegisterController@mobileRegister');

// 课程
Route::get('/courses', 'CourseController@paginate');
Route::get('/course/{id}', 'CourseController@detail');
Route::get('/course/{id}/comments', 'CourseController@comments');
Route::post('/course/{id}/comment', 'CourseController@createComment')->middleware(['auth:apiv2']);
// 全部课程分类
Route::get('/course_categories', 'CourseCategoryController@all');

// 视频
Route::get('/videos', 'VideoController@paginate');
Route::get('/video/{id}', 'VideoController@detail');
Route::get('/video/{id}/playinfo', 'VideoController@playInfo')->middleware(['auth:apiv2']);
Route::get('/video/{id}/comments', 'VideoController@comments');
Route::post('/video/{id}/comment', 'VideoController@createComment')->middleware(['auth:apiv2']);

// 套餐
Route::get('/roles', 'RoleController@roles');
Route::get('/role/{id}', 'RoleController@detail');

// 幻灯片
Route::get('/sliders', 'SliderController@all');

// 登录
Route::group(['prefix' => '/wechat/mini'], function () {
    Route::post('/login', 'WechatMiniController@login');
});

// 优惠码
Route::get('/promoCode/{code}', 'PromoCodeController@detail');

Route::group(['prefix' => 'other'], function () {
    Route::get('/userProtocol', 'OtherController@userProtocol');
});

Route::group(['middleware' => ['auth:apiv2'], 'prefix' => 'member'], function () {
    Route::get('detail', 'MemberController@detail');
    Route::post('detail/password', 'MemberController@passwordChange');
    Route::post('detail/avatar', 'MemberController@avatarChange');
    Route::get('courses', 'MemberController@courses');
    Route::get('courses/like', 'MemberController@likeCourses');
    Route::get('courses/history', 'MemberController@learnHistory');
    Route::get('videos', 'MemberController@videos');
    Route::get('orders', 'MemberController@orders');
    Route::get('roles', 'MemberController@roles');
    Route::get('messages', 'MemberController@messages');
    Route::get('inviteBalanceRecords', 'MemberController@inviteBalanceRecords');
    Route::get('promoCode', 'MemberController@promoCode');
    Route::post('promoCode', 'MemberController@generatePromoCode');
    Route::get('notificationMarkAsRead/{notificationId}', 'MemberController@notificationMarkAsRead');
    Route::get('notificationMarkAllAsRead', 'MemberController@notificationMarkAllAsRead');
});

Route::group(['middleware' => ['auth:apiv2']], function () {
    Route::post('/order/course', 'OrderController@createCourseOrder');
    Route::post('/order/role', 'OrderController@createRoleOrder');
    Route::post('/order/video', 'OrderController@createVideoOrder');

    // 小程序支付
    Route::post('/order/payment/wechat/mini', 'PaymentController@wechatMiniPay');
    Route::get('/order/payments', 'PaymentController@payments');

    // 优惠码检测
    Route::get('/promoCode/{code}/check', 'PromoCodeController@checkCode');
});