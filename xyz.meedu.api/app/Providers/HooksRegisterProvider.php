<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Providers;

use App\Meedu\Hooks\HookContainer;
use Illuminate\Support\ServiceProvider;
use App\Hooks\ViewBlock\Data\VodV1DataHook;
use App\Hooks\OrderStore\OrderStoreRoleHook;
use App\Hooks\OrderStore\OrderStoreCourseHook;
use App\Meedu\Hooks\Constant\PositionConstant;
use App\Hooks\CommentStoreCheck\VodCourseCommentHook;
use App\Hooks\CommentStoreCheck\VodCourseVideoCommentHook;

class HooksRegisterProvider extends ServiceProvider
{
    protected $hooks = [
        PositionConstant::VIEW_BLOCK_DATA_RENDER => [
            VodV1DataHook::class,
        ],
        PositionConstant::ORDER_STORE_INFO_PARSE => [
            OrderStoreCourseHook::class,
            OrderStoreRoleHook::class,
        ],
        PositionConstant::COMMENT_STORE_CHECK => [
            VodCourseCommentHook::class,
            VodCourseVideoCommentHook::class,
        ],
    ];

    public function boot()
    {
        foreach ($this->hooks as $position => $hooks) {
            HookContainer::getInstance()->register($position, $hooks);
        }
    }
}
