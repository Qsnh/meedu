<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

Route::any('/wechat/serve', 'Api\\Wechat\\MpWechatController@serve');

Route::any('/wechat/refund/notify', 'Api\\Wechat\\RefundController@notify')->name('wechat.pay.refund.notify');
