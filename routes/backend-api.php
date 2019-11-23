<?php

Route::post('/login', 'LoginController@login');

// 友情链接
Route::group(['prefix' => 'link'], function () {
    Route::get('/', 'LinkController@index');
    Route::post('/create', 'LinkController@store');
    Route::get('/{id}', 'LinkController@edit');
    Route::put('/{id}', 'LinkController@update');
    Route::delete('/{id}', 'LinkController@destroy');
});

// 广告推广
Route::group(['prefix' => 'ad_from'], function () {
    Route::get('/', 'AdFromController@index');
    Route::post('/create', 'AdFromController@store');
    Route::get('/{id}', 'AdFromController@edit');
    Route::put('/{id}', 'AdFromController@update');
    Route::delete('/{id}', 'AdFromController@destroy');
});

// 公告
Route::group(['prefix' => 'announcement'], function () {
    Route::get('/', 'AnnouncementController@index');
    Route::post('/create', 'AnnouncementController@store');
    Route::get('/{id}', 'AnnouncementController@edit');
    Route::put('/{id}', 'AnnouncementController@update');
    Route::delete('/{id}', 'AnnouncementController@destroy');
});

// 课程评论
Route::group(['prefix' => 'course_comment'], function () {
    Route::get('/', 'CourseCommentController@index');
    Route::delete('/{id}', 'CourseCommentController@destroy');
});

// Nav
Route::group(['prefix' => 'nav'], function () {
    Route::get('/', 'NavController@index');
    Route::post('/create', 'NavController@store');
    Route::get('/{id}', 'NavController@edit');
    Route::put('/{id}', 'NavController@update');
    Route::delete('/{id}', 'NavController@destroy');
});

// Role
Route::group(['prefix' => 'role'], function () {
    Route::get('/', 'RoleController@index');
    Route::post('/create', 'RoleController@store');
    Route::get('/{id}', 'RoleController@edit');
    Route::put('/{id}', 'RoleController@update');
    Route::delete('/{id}', 'RoleController@destroy');
});

// 视频评论
Route::group(['prefix' => 'video_comment'], function () {
    Route::get('/', 'VideoCommentController@index');
    Route::delete('/{id}', 'VideoCommentController@destroy');
});

// 管理员
Route::group(['prefix' => 'administrator'], function () {
    Route::get('/', 'AdministratorController@index');
    Route::post('/create', 'AdministratorController@store');
    Route::get('/{id}/edit', 'AdministratorController@edit');
    Route::put('/{id}/edit', 'AdministratorController@update');
    Route::delete('/{id}/destroy', 'AdministratorController@destroy');
    Route::put('/password', 'AdministratorController@editPasswordHandle');
});

// 权限
Route::group(['prefix' => 'administrator_permission'], function () {
    Route::get('/', 'AdministratorPermissionController@index');
    Route::post('/create', 'AdministratorPermissionController@store');
    Route::get('/{id}', 'AdministratorPermissionController@edit');
    Route::put('/{id}', 'AdministratorPermissionController@update');
    Route::delete('/{id}', 'AdministratorPermissionController@destroy');
});

// 后台菜单
Route::group(['prefix' => 'administrator_menu'], function () {
    Route::get('/', 'AdministratorMenuController@index');
    Route::post('/create', 'AdministratorMenuController@store');
    Route::get('/{id}', 'AdministratorMenuController@edit');
    Route::put('/{id}/', 'AdministratorMenuController@update');
    Route::delete('/{id}/', 'AdministratorMenuController@destroy');
    Route::post('/save', 'AdministratorMenuController@saveChange');
});

// 角色
Route::group(['prefix' => 'administrator_role'], function () {
    Route::get('/', 'AdministratorRoleController@index');
    Route::post('/create', 'AdministratorRoleController@store');
    Route::get('/{id}', 'AdministratorRoleController@edit');
    Route::put('/{id}', 'AdministratorRoleController@update');
    Route::delete('/{id}', 'AdministratorRoleController@destroy');
    Route::post('/{id}/permission', 'AdministratorRoleController@permissionSave');
});

// 课程章节
Route::group(['prefix' => 'course_chapter'], function () {
    Route::get('/{course_id}', 'CourseChapterController@index');
    Route::post('/{course_id}', 'CourseChapterController@store');
    Route::get('/{course_id}/{id}', 'CourseChapterController@edit');
    Route::put('/{course_id}/{id}', 'CourseChapterController@update');
    Route::delete('/{course_id}/{id}', 'CourseChapterController@destroy');
});

// 课程
Route::group(['prefix' => 'course'], function () {
    Route::get('/', 'CourseController@index');
    Route::post('/create', 'CourseController@store');
    Route::get('/{id}', 'CourseController@edit');
    Route::put('/{id}', 'CourseController@update');
    Route::delete('/{id}', 'CourseController@destroy');
});

// 视频
Route::group(['prefix' => 'video'], function () {
    Route::get('/', 'CourseVideoController@index');
    Route::post('/create', 'CourseVideoController@store');
    Route::get('/{id}', 'CourseVideoController@edit');
    Route::put('/{id}', 'CourseVideoController@update');
    Route::delete('/{id}', 'CourseVideoController@destroy');
});

// 会员
Route::group(['prefix' => 'member'], function () {
    Route::get('/', 'MemberController@index');
    Route::get('/{id}', 'MemberController@show');
    Route::post('/create', 'MemberController@store');
});

// 网站配置
Route::group(['prefix' => 'setting'], function () {
    Route::get('/', 'SettingController@index');
    Route::post('/', 'SettingController@saveHandler');
});