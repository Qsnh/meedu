<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

Route::group([
    'middleware' => ['auth:administrator'],
], function () {
    Route::get('/system/config', 'SystemController@config');

    Route::group([
        'middleware' => ['backend.permission'],
    ], function () {
        Route::group(['prefix' => 'member'], function () {
            Route::get('/courses', 'MemberController@courses');
            Route::get('/course/progress', 'MemberController@courseProgress');
            Route::get('/videos', 'MemberController@videos');

            Route::delete('/{id}', 'MemberController@destroy');
        });

        Route::group(['prefix' => 'stats'], function () {
            Route::get('/transaction', 'StatsController@transaction');
            Route::get('/transaction-top', 'StatsController@transactionTop');
            Route::get('/transaction-graph', 'StatsController@transactionGraph');

            Route::get('/user-paid-top', 'StatsController@userPaidTop');
            Route::get('/user', 'StatsController@user');
            Route::get('/user-graph', 'StatsController@userGraph');
        });
    });
});
