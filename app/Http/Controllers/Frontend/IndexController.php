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
use App\Services\Other\Services\SliderService;
use App\Services\Other\Interfaces\LinkServiceInterface;
use App\Services\Base\Interfaces\ConfigServiceInterface;
use App\Services\Other\Interfaces\SliderServiceInterface;

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
    /**
     * @var SliderService
     */
    protected $sliderService;

    public function __construct(
        LinkServiceInterface $linkService,
        ConfigServiceInterface $configService,
        SliderServiceInterface $sliderService
    ) {
        $this->linkService = $linkService;
        $this->configService = $configService;
        $this->sliderService = $sliderService;
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

        $sliders = $this->sliderService->all();

        return v(
            'frontend.index.index',
            compact('title', 'keywords', 'description', 'links', 'sliders')
        );
    }

    public function userProtocol()
    {
        $protocol = $this->configService->getMemberProtocol();
        return v('frontend.index.user_protocol', compact('protocol'));
    }
}
