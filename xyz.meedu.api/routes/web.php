<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

use Illuminate\Support\Facades\Route;

Route::get('/', 'IndexController@index');

Route::get('/user/protocol', 'IndexController@userProtocol')->name('user.protocol');
Route::get('/user/private_protocol', 'IndexController@userPrivateProtocol')->name('user.private_protocol');
Route::get('/user/vip_protocol', 'IndexController@vipProtocol')->name('user.vip_protocol');
Route::get('/user/paid_content_purchase_protocol', 'IndexController@paidContentPurchaseProtocol')->name('user.paid_content_purchase_protocol');
Route::get('/aboutus', 'IndexController@aboutus')->name('aboutus');
Route::get('/face-verify-success', 'IndexController@faceVerifySuccess')->name('face.verify.success');

// 支付回调
Route::post('/payment/callback/{payment}', 'PaymentController@callback')->name('payment.callback');
// 收银台
Route::get('/payment/index', 'PaymentController@index')->name('payment.index');
Route::post('/payment/index', 'PaymentController@index');
Route::get('/payment/success', 'PaymentController@successPage')->name('payment.success');
