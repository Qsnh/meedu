<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

Route::get('/search', 'SearchController@index');

Route::get('/status', 'SystemController@status');

Route::get('/auth/login/wechat/oauth', 'LoginController@wechatOauthLogin')->name('api.v3.login.wechat-oauth');
Route::get('/auth/login/wechat/callback', 'LoginController@wechatOauthCallback')->name('api.v3.login.wechat.callback');
Route::get('/auth/login/socialite/{app}', 'LoginController@socialiteLogin');
Route::get('/auth/login/socialite/{app}/callback', 'LoginController@socialiteLoginCallback')->name('api.v3.login.socialite.callback');

Route::get('/auth/login/wechat-scan/page', 'WechatScanLoginController@index')->name('api.v3.wechat-scan-login.page');
Route::post('/auth/login/wechat-scan/url', 'WechatScanLoginController@getLoginUrl');
Route::get('/auth/login/wechat-scan/query', 'WechatScanLoginController@query');

Route::post('/auth/login/code', 'LoginController@loginByCode');
Route::post('/auth/register/withSocialite', 'LoginController@registerWithSocialite');

Route::get('/course/attach-download', 'CourseController@attachDownloadDirect')->name('course.attach.download.direct');

Route::group(['middleware' => ['auth:apiv2', 'api.login.status.check']], function () {
    Route::post('/order', 'OrderController@store');

    // 获取课件的下载地址
    Route::get('/course/{courseId}/attach/{id}', 'CourseController@attachDownloadUrl');

    Route::group(['prefix' => 'member'], function () {
        // 学员已购录播课
        Route::get('/courses', 'MemberController@courses');
        // 学员的全部已学习录播课
        Route::get('/courses/learned', 'MemberController@learnedCourses');
        // 学员某个课程的学习明细(课程的所有课时观看进度)
        Route::get('/learned/course/{courseId}', 'MemberController@learnedCourseDetail');
        // 学员喜欢的课程
        Route::get('/courses/like', 'MemberController@likeCourses');

        // 账户注销
        Route::post('/destroy', 'MemberController@destroy');
        // 社交登录绑定
        Route::post('/socialite/bindWithCode', 'MemberController@socialiteBindByCode');
        // 微信账号扫码绑定
        Route::get('/wechatScanBind', 'MemberController@wechatScanBind');

        // 微信实人认证结果查询
        Route::get('/tencent/faceVerify', 'MemberController@queryTencentFaceVerify');
        // 请求发起微信实人认证
        Route::post('/tencent/faceVerify', 'MemberController@tencentFaceVerify');
    });
});
