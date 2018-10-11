<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/courses', 'CourseController@index');
Route::get('/course/{id}', 'CourseController@show');
Route::get('/course/{id}/videos', 'CourseController@videos');
Route::get('/course/{id}/comments', 'CourseController@comments');

Route::get('/video/{id}', 'VideoController@show');
Route::get('/video/{id}/comments', 'VideoController@comments');

Route::get('/faq/categories', 'FaqController@categories');
Route::get('/faq/category/{id}', 'FaqController@category');
Route::get('/faq/category/{id}/articles', 'FaqController@articles');
Route::get('/faq/article/latest', 'FaqController@latestArticles');
Route::get('/faq/article/{id}', 'FaqController@article');

Route::get('/roles', 'RoleController@index');

Route::group(['middleware' => ['auth:api']], function () {
    // 请求视频播放地址
    Route::get('/video/{id}/play_url', 'VideoController@playUrl');
    // 课程评论
    Route::post('/course/{id}/comment', 'CourseController@commentHandler');
    // 视频评论
    Route::post('/video/{id}/comment', 'VideoController@commentHandler');
    // VIP购买
    Route::post('/role/{id}/buy', 'RoleController@buyHandler');

    Route::group(['prefix' => '/member'], function () {
        // 修改密码
        Route::post('/password/change', 'MemberController@passwordChangeHandler');
        // 我加入的课程
        Route::get('/courses', 'MemberController@joinCourses');
        // 已购买视频
        Route::get('/videos', 'MemberController@buyVideos');
    });
});