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


Route::group(['prefix' => 'backend', 'namespace' => 'Backend'], function () {
    // 后台登录
    Route::get('/login', 'AdministratorController@showLoginForm')->name('backend.login');
    Route::post('/login', 'AdministratorController@loginHandle');
    Route::get('/logout', 'AdministratorController@logoutHandle')->name('backend.logout');
    // 修改密码
    Route::get('/edit/password', 'AdministratorController@showEditPasswordForm')->name('backend.edit.password');
    Route::put('/edit/password', 'AdministratorController@editPasswordHandle');

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
    // 权限
    Route::get('/administrator_permission', 'AdministratorPermissionController@index')->name('backend.administrator_permission.index');
    Route::get('/administrator_permission/create', 'AdministratorPermissionController@create')->name('backend.administrator_permission.create');
    Route::post('/administrator_permission/create', 'AdministratorPermissionController@store');
    Route::get('/administrator_permission/{id}/edit', 'AdministratorPermissionController@edit')->name('backend.administrator_permission.edit');
    Route::put('/administrator_permission/{id}/edit', 'AdministratorPermissionController@update');
    Route::get('/administrator_permission/{id}/destroy', 'AdministratorPermissionController@destroy')->name('backend.administrator_permission.destroy');

});