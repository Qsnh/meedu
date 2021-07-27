<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\ViewBlock;

use App\Services\Other\Services\ViewBlockService;
use App\Services\Other\Interfaces\ViewBlockServiceInterface;

class PageRender
{
    public static function pcIndexPage()
    {
        return self::render(Constant::PLATFORM_PC, Constant::PC_PAGE_INDEX);
    }

    public static function h5IndexPage()
    {
        return self::render(Constant::PLATFORM_H5, Constant::H5_PAGE_INDEX_V1);
    }

    public static function render(string $platform, string $page): string
    {
        /**
         * @var ViewBlockService $viewBlockService
         */
        $viewBlockService = app()->make(ViewBlockServiceInterface::class);

        $blocks = $viewBlockService->getPageBlocks($platform, $page);

        if (!$blocks) {
            return '';
        }

        return Render::viewRender($blocks);
    }
}
