<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Controllers\Frontend;

use App\Services\Base\Services\ConfigService;
use App\Services\Other\Interfaces\LinkServiceInterface;

class IndexController extends FrontendController
{
    protected $linkService;
    protected $configService;

    public function __construct(
        LinkServiceInterface $linkService,
        ConfigService $configService
    ) {
        $this->linkService = $linkService;
        $this->configService = $configService;
    }

    public function index()
    {
        $links = $this->linkService->all();

        [
            'title' => $title,
            'keywords' => $keywords,
            'description' => $description
        ] = $this->configService->getSeoIndexPage();

        return v(
            'frontend.index.index',
            compact('title', 'keywords', 'description', 'links')
        );
    }
}
