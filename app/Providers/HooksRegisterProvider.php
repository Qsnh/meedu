<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

namespace App\Providers;

use App\Meedu\Hooks\HookContainer;
use App\Hooks\MpWechatMessageReplyHook;
use Illuminate\Support\ServiceProvider;
use App\Meedu\Hooks\Constant\PositionConstant;

class HooksRegisterProvider extends ServiceProvider
{
    public function boot()
    {
        HookContainer::getInstance()->register(PositionConstant::MP_WECHAT_RECEIVER_MESSAGE, [
            MpWechatMessageReplyHook::class,
        ]);
    }

    public function register()
    {
    }
}
