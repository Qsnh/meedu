<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Providers;

use App\Meedu\Hooks\HookContainer;
use App\Hooks\MpWechatSubscribeHook;
use App\Hooks\MpWechatMessageReplyHook;
use Illuminate\Support\ServiceProvider;
use App\Hooks\ViewBlockDataRenderVodHook;
use App\Meedu\Hooks\Constant\PositionConstant;

class HooksRegisterProvider extends ServiceProvider
{
    public function boot()
    {
        HookContainer::getInstance()->register(PositionConstant::MP_WECHAT_RECEIVER_MESSAGE, [
            MpWechatSubscribeHook::class,
            MpWechatMessageReplyHook::class,
        ]);

        HookContainer::getInstance()->register(PositionConstant::VIEW_BLOCK_DATA_RENDER, [
            ViewBlockDataRenderVodHook::class,
        ]);
    }

    public function register()
    {
    }
}
