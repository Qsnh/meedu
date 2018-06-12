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

    // 管理员
    Route::get('/administrator', 'AdministratorController@index')->name('backend.administrator.index');

});