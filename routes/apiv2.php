<?php


// 图形验证码
Route::get('/captcha/image', 'CaptchaController@imageCaptcha');

// 登录
Route::post('/login/password', 'LoginController@passwordLogin');

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