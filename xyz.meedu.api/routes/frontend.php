<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

Route::group(['namespace' => 'Wechat', 'prefix' => '/wechat'], function () {
    // 微信公众号回调
    Route::any('/serve', 'MpWechatController@serve');
    // 微信支付回调
    Route::any('/refund/notify', 'RefundController@notify')->name('wechat.pay.refund.notify');
});

Route::group(['namespace' => 'Media', 'prefix' => '/media'], function () {
    // 阿里云点播回调
    Route::any('/aliyun-vod/{sign}', 'AliVodCallbackController@handler')->name('aliyun.vod.callback');
    // 腾讯云点播回调
    Route::any('/tencent-vod/{sign}', 'TencentVodCallbackController@handler')->name('tencent.vod.callback');
});
