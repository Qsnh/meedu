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
use App\Hooks\ViewBlock\HTML\CodeHTMLHook;
use App\Hooks\ViewBlock\Data\VodV1DataHook;
use App\Hooks\ViewBlock\HTML\BlankHTMLHook;
use App\Hooks\ViewBlock\HTML\VodV1HTMLHook;
use App\Hooks\ViewBlock\HTML\SliderHTMLHook;
use App\Hooks\ViewBlock\HTML\GridNavHTMLHook;
use App\Hooks\ViewBlock\HTML\H5VodV1HTMLHook;
use App\Meedu\Hooks\Constant\PositionConstant;
use App\Hooks\ViewBlock\HTML\ImageGroupHTMLHook;

class HooksRegisterProvider extends ServiceProvider
{
    protected $hooks = [
        PositionConstant::MP_WECHAT_RECEIVER_MESSAGE => [
            MpWechatSubscribeHook::class,
            MpWechatMessageReplyHook::class,
        ],
        PositionConstant::VIEW_BLOCK_DATA_RENDER => [
            VodV1DataHook::class,
        ],
        PositionConstant::VIEW_BLOCK_HTML_RENDER => [
            VodV1HTMLHook::class,
            CodeHTMLHook::class,

            // h5
            GridNavHTMLHook::class,
            H5VodV1HTMLHook::class,
            SliderHTMLHook::class,
            ImageGroupHTMLHook::class,
            BlankHTMLHook::class,
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
