<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

Route::get('/search', 'SearchController@index');

Route::group(['middleware' => ['auth:apiv2', 'api.login.status.check']], function () {
    // 手动打款
    Route::post('/order/pay/handPay', 'PaymentController@handPay');

    Route::group(['prefix' => 'member'], function () {
        Route::get('/courses', 'MemberController@courses');
        Route::get('/courses/learned', 'MemberController@learnedCourses');
        Route::get('/courses/like', 'MemberController@likeCourses');
    });
});
