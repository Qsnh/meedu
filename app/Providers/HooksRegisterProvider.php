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
use App\Hooks\ViewBlockPcIndexPageVodRender;
use App\Meedu\Hooks\Constant\PositionConstant;

class HooksRegisterProvider extends ServiceProvider
{
    protected $hooks = [
        PositionConstant::MP_WECHAT_RECEIVER_MESSAGE => [
            MpWechatSubscribeHook::class,
            MpWechatMessageReplyHook::class,
        ],
        PositionConstant::VIEW_BLOCK_DATA_RENDER => [
            ViewBlockDataRenderVodHook::class,
        ],
        PositionConstant::VIEW_BLOCK_HTML_RENDER => [
            ViewBlockPcIndexPageVodRender::class
        ],
    ];

    public function boot()
    {
        foreach ($this->hooks as $position => $hooks) {
            HookContainer::getInstance()->register($position, $hooks);
        }
    }

    public function register()
    {
    }
}
