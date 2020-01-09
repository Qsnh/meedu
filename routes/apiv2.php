<?php


// 图形验证码
Route::get('/captcha/image', 'CaptchaController@imageCaptcha');
// 发送手机验证码
Route::post('/captcha/sms', 'CaptchaController@sentSms');

// 密码登录
Route::post('/login/password', 'LoginController@passwordLogin');
// 手机号注册
Route::post('/register/mobile', 'RegisterController@mobileRegister');

// 课程
Route::get('/courses', 'CourseController@paginate');
Route::get('/course/{id}', 'CourseController@detail');
Route::get('/course/{id}/comments', 'CourseController@comments');
Route::post('/course/{id}/comment', 'CourseController@createComment')->middleware(['auth:apiv2']);

// 视频
Route::get('/videos', 'VideoController@paginate');
Route::get('/video/{id}', 'VideoController@detail');
Route::get('/video/{id}/comments', 'VideoController@comments');
Route::post('/video/{id}/comment', 'VideoController@createComment')->middleware(['auth:apiv2']);

// 套餐
Route::get('/roles', 'RoleController@roles');

Route::group(['middleware' => ['auth:apiv2'], 'prefix' => 'member'], function () {
    Route::get('detail', 'MemberController@detail');
    Route::post('detail/password', 'MemberController@passwordChange');
    Route::post('detail/avatar', 'MemberController@avatarChange');
    Route::get('courses', 'MemberController@courses');
    Route::get('videos', 'MemberController@videos');
    Route::get('orders', 'MemberController@orders');
    Route::get('roles', 'MemberController@roles');
    Route::get('messages', 'MemberController@messages');
    Route::get('inviteBalanceRecords', 'MemberController@inviteBalanceRecords');
});