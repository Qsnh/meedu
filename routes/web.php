<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

// 后台登录
Route::get('/backend/login', 'Backend\AdministratorController@showLoginForm')->name('backend.login');
Route::post('/backend/login', 'Backend\AdministratorController@loginHandle');
Route::get('/backend/logout', 'Backend\AdministratorController@logoutHandle')->name('backend.logout');
// 修改密码
Route::get('/backend/edit/password', 'Backend\AdministratorController@showEditPasswordForm')->name('backend.edit.password');
Route::put('/backend/edit/password', 'Backend\AdministratorController@editPasswordHandle');

Route::group(['prefix' => 'backend', 'namespace' => 'Backend', 'middleware' => ['backend.login.check']], function () {
    // 主面板
    Route::get('/dashboard', 'DashboardController@index')->name('backend.dashboard.index');
    // 管理员
    Route::get('/administrator', 'AdministratorController@index')->name('backend.administrator.index');
    Route::get('/administrator/create', 'AdministratorController@create')->name('backend.administrator.create');
    Route::post('/administrator/create', 'AdministratorController@store');
    Route::get('/administrator/{id}/edit', 'AdministratorController@edit')->name('backend.administrator.edit');
    Route::put('/administrator/{id}/edit', 'AdministratorController@update');
    Route::get('/administrator/{id}/destroy', 'AdministratorController@destroy')->name('backend.administrator.destroy');
    // 角色
    Route::get('/administrator_role', 'AdministratorRoleController@index')->name('backend.administrator_role.index');
    Route::get('/administrator_role/create', 'AdministratorRoleController@create')->name('backend.administrator_role.create');
    Route::post('/administrator_role/create', 'AdministratorRoleController@store');
    Route::get('/administrator_role/{id}/edit', 'AdministratorRoleController@edit')->name('backend.administrator_role.edit');
    Route::put('/administrator_role/{id}/edit', 'AdministratorRoleController@update');
    Route::get('/administrator_role/{id}/destroy', 'AdministratorRoleController@destroy')->name('backend.administrator_role.destroy');
    Route::get('/administrator_role/{id}/permission', 'AdministratorRoleController@showSelectPermissionPage')->name('backend.administrator_role.permission');
    Route::post('/administrator_role/{id}/permission', 'AdministratorRoleController@handlePermissionSave');
    // 权限
    Route::get('/administrator_permission', 'AdministratorPermissionController@index')->name('backend.administrator_permission.index');
    Route::get('/administrator_permission/create', 'AdministratorPermissionController@create')->name('backend.administrator_permission.create');
    Route::post('/administrator_permission/create', 'AdministratorPermissionController@store');
    Route::get('/administrator_permission/{id}/edit', 'AdministratorPermissionController@edit')->name('backend.administrator_permission.edit');
    Route::put('/administrator_permission/{id}/edit', 'AdministratorPermissionController@update');
    Route::get('/administrator_permission/{id}/destroy', 'AdministratorPermissionController@destroy')->name('backend.administrator_permission.destroy');

    // 课程
    Route::get('/course', 'CourseController@index')->name('backend.course.index');
    Route::get('/course/create', 'CourseController@create')->name('backend.course.create');
    Route::post('/course/create', 'CourseController@store');
    Route::get('/course/{id}/edit', 'CourseController@edit')->name('backend.course.edit');
    Route::put('/course/{id}/edit', 'CourseController@update');
    Route::get('/course/{id}/delete', 'CourseController@destroy')->name('backend.course.destroy');
    // 视频
    Route::get('/video', 'CourseVideoController@index')->name('backend.video.index');
    Route::get('/video/create', 'CourseVideoController@create')->name('backend.video.create');
    Route::post('/video/create', 'CourseVideoController@store');
    Route::get('/video/{id}/edit', 'CourseVideoController@edit')->name('backend.video.edit');
    Route::put('/video/{id}/edit', 'CourseVideoController@update');
    Route::get('/video/{id}/delete', 'CourseVideoController@destroy')->name('backend.video.destroy');


    // 图片上传
    Route::post('/upload/image', 'UploadController@uploadImageHandle')->name('backend.upload.image');

    // Ajax
    Route::group(['prefix' => 'ajax', 'namespace' => 'Ajax'], function () {
        Route::get('/course', 'CourseController@index')->name('backend.ajax.course.index');
    });
});