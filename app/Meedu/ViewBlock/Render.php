<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\ViewBlock;

use App\Meedu\Hooks\HookRun;
use App\Meedu\Hooks\HookParams;
use App\Meedu\Hooks\Constant\PositionConstant;

class Render
{
    public static function dataRender(array $blocks): array
    {
        foreach ($blocks as $index => $blockItem) {
            if (in_array($blockItem['sign'], Constant::DATA_RENDER_BLOCK_WHITELIST)) {
                continue;
            }

            $blocks[$index] = HookRun::run(PositionConstant::VIEW_BLOCK_DATA_RENDER, new HookParams(['block' => $blockItem]));
        }

        return $blocks;
    }

    // 视图渲染
    public static function viewRender(array $blocks): string
    {
        $html = '';
        foreach ($blocks as $blockItem) {
            $html .= HookRun::run(PositionConstant::VIEW_BLOCK_HTML_RENDER, new HookParams(['block' => $blockItem]));
        }

        return $html;
    }
}
