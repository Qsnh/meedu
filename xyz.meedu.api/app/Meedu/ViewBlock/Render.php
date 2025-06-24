<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\ViewBlock;

use App\Meedu\Hooks\HookRun;
use App\Meedu\Hooks\Constant\PositionConstant;

class Render
{
    public static function dataRender(array $blocks): array
    {
        foreach ($blocks as $index => $blockItem) {
            if (in_array($blockItem['sign'], Constant::DATA_RENDER_BLOCK_WHITELIST)) {
                continue;
            }

            $tmpData = HookRun::mount(PositionConstant::VIEW_BLOCK_DATA_RENDER, ['block' => $blockItem]);

            if ($tmpData) {
                // 如果渲染返回了数据则覆盖已有的数据
                $blocks[$index] = $tmpData;
            }
        }

        return $blocks;
    }
}
