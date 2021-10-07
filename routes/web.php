<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

Route::get('/user/protocol', 'IndexController@userProtocol')->name('user.protocol');
Route::get('/user/private_protocol', 'IndexController@userPrivateProtocol')->name('user.private_protocol');
Route::get('/aboutus', 'IndexController@aboutus')->name('aboutus');

// 支付回调
Route::post('/payment/callback/{payment}', 'PaymentController@callback')->name('payment.callback');
// 微信JSAPI支付
Route::get('/member/order/pay/wechat/jsapi/page', 'OrderController@wechatJSAPI')->name('order.pay.wechat.jsapi');
// 手动打款支付
Route::get('/member/order/pay/handPay', 'OrderController@handPay')->name('order.pay.handPay');

Route::group([
    'prefix' => '/member',
    'middleware' => ['auth'],
], function () {
    // 支付成功界面
    Route::get('/order/pay/success', 'OrderController@paySuccess')->name('order.pay.success');
});
