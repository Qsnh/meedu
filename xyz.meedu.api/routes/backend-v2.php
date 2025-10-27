<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

use App\Constant\BackendPermission;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => ['auth:administrator'],
], function () {
    // 白名单 - 系统配置
    Route::get('/system/config', 'SystemController@config');

    // 需要权限检查的路由
    Route::group([
        'middleware' => ['backend.sensitive.mask'],
    ], function () {
        // 学员
        Route::group(['prefix' => 'member'], function () {
            Route::get('/courses', 'MemberController@courses')->middleware('mbp:' . BackendPermission::V2_MEMBER_COURSES);
            Route::get('/course/progress', 'MemberController@courseProgress')->middleware('mbp:' . BackendPermission::V2_MEMBER_COURSE_PROGRESS);
            Route::get('/videos', 'MemberController@videos')->middleware('mbp:' . BackendPermission::V2_MEMBER_COURSES);
            Route::delete('/{id}', 'MemberController@destroy')->middleware('mbp:' . BackendPermission::MEMBER_DESTROY);
        });

        // 数据统计
        Route::group(['prefix' => 'stats'], function () {
            Route::get('/transaction', 'StatsController@transaction')->middleware('mbp:' . BackendPermission::STATS_TRANSACTION);
            Route::get('/transaction-top', 'StatsController@transactionTop')->middleware('mbp:' . BackendPermission::STATS_COURSE);
            Route::get('/transaction-graph', 'StatsController@transactionGraph')->middleware('mbp:' . BackendPermission::STATS_TRANSACTION);

            Route::get('/user-paid-top', 'StatsController@userPaidTop')->middleware('mbp:' . BackendPermission::STATS_USER);
            Route::get('/user', 'StatsController@user')->middleware('mbp:' . BackendPermission::STATS_USER);
            Route::get('/user-graph', 'StatsController@userGraph')->middleware('mbp:' . BackendPermission::STATS_USER);
        });
    });
});
