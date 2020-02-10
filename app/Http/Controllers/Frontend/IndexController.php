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

use App\Events\AdFromEvent;
use App\Services\Other\Services\LinkService;
use App\Services\Base\Services\ConfigService;
use App\Services\Other\Interfaces\LinkServiceInterface;
use App\Services\Base\Interfaces\ConfigServiceInterface;

class IndexController extends FrontendController
{
    /**
     * @var LinkService
     */
    protected $linkService;
    /**
     * @var ConfigService
     */
    protected $configService;

    public function __construct(
        LinkServiceInterface $linkService,
        ConfigServiceInterface $configService
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

        if ($fromKey = request()->input('from_key')) {
            event(new AdFromEvent($fromKey));
        }

        return v(
            'frontend.index.index',
            compact('title', 'keywords', 'description', 'links')
        );
    }

    public function userProtocol()
    {
        $protocol = $this->configService->getMemberProtocol();
        return v('frontend.index.user_protocol', compact('protocol'));
    }
}
