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

            $tmpData = HookRun::run(PositionConstant::VIEW_BLOCK_DATA_RENDER, new HookParams(['block' => $blockItem]));

            if ($tmpData) {
                // 如果渲染返回了数据则覆盖已有的数据
                $blocks[$index] = $tmpData;
            }
        }

        return $blocks;
    }

    // 视图渲染
    public static function viewRender(array $blocks): string
    {
        $html = '';
        foreach ($blocks as $blockItem) {
            $tmp = HookRun::run(PositionConstant::VIEW_BLOCK_HTML_RENDER, new HookParams(['block' => $blockItem]));

            $tmp && $html .= $tmp;
        }

        return $html;
    }
}
