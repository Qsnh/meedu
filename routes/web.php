<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

Route::get('/', 'IndexController@index');

Route::get('/user/protocol', 'IndexController@userProtocol')->name('user.protocol');
Route::get('/user/private_protocol', 'IndexController@userPrivateProtocol')->name('user.private_protocol');
Route::get('/aboutus', 'IndexController@aboutus')->name('aboutus');
Route::get('/face-verify-success', 'IndexController@faceVerifySuccess')->name('face.verify.success');

// 支付回调
Route::post('/payment/callback/{payment}', 'PaymentController@callback')->name('payment.callback');
// 微信JSAPI支付
Route::get('/member/order/pay/wechat/jsapi/page', 'OrderController@wechatJSAPI')->name('order.pay.wechat.jsapi');
