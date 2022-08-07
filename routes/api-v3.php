<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

Route::get('/search', 'SearchController@index');

Route::get('/auth/login/wechat/oauth', 'LoginController@wechatOauthLogin');
Route::get('/auth/login/wechat/callback', 'LoginController@wechatScanLoginCallback')->name('api.v3.login.wechat.callback');
Route::get('/auth/login/socialite/{app}', 'LoginController@socialiteLogin');
Route::get('/auth/login/socialite/{app}/callback', 'LoginController@socialiteLoginCallback')->name('api.v3.login.socialite.callback');

Route::post('/auth/login/code', 'LoginController@loginByCode');
Route::post('/auth/register/socialite', 'LoginController@registerWithSocialite');

Route::group(['middleware' => ['auth:apiv2', 'api.login.status.check']], function () {
    // 手动打款
    Route::post('/order/pay/handPay', 'PaymentController@handPay');

    Route::group(['prefix' => 'member'], function () {
        Route::get('/courses', 'MemberController@courses');
        Route::get('/courses/learned', 'MemberController@learnedCourses');
        Route::get('/courses/like', 'MemberController@likeCourses');

        Route::post('/destroy', 'MemberController@destroy');
    });
});
