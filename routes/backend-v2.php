<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

Route::group([
    'middleware' => ['auth:administrator', 'backend.permission'],
], function () {
    Route::group(['prefix' => 'member'], function () {
        Route::get('/courses', 'MemberController@courses');
        Route::get('/course/progress', 'MemberController@courseProgress');
        Route::get('/videos', 'MemberController@videos');
    });
});
