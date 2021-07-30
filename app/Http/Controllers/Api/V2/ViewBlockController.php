<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Api\V2;

use Illuminate\Http\Request;
use App\Meedu\ViewBlock\Render;
use App\Services\Other\Services\ViewBlockService;
use App\Services\Other\Interfaces\ViewBlockServiceInterface;

class ViewBlockController extends BaseController
{
    public function pageBlocks(Request $request, ViewBlockServiceInterface $viewBlockService)
    {
        /**
         * @var ViewBlockService $viewBlockService
         */

        $page = $request->input('page_name');
        $platform = $request->input('platform');
        if (!$page || !$platform) {
            return $this->error(__('参数错误'));
        }

        $blocks = $viewBlockService->getPageBlocks($platform, $page);

        $blocks = Render::dataRender($blocks);

        return $this->data($blocks);
    }
}
