<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Listeners\SliderUpdateEvent;

use App\Events\SliderUpdateEvent;
use App\Constant\FrontendConstant;
use App\Meedu\Cache\Impl\SliderCache;

class CacheClearListener
{
    private $sliderCache;

    public function __construct(SliderCache $sliderCache)
    {
        $this->sliderCache = $sliderCache;
    }

    public function handle(SliderUpdateEvent $event)
    {
        $this->sliderCache->destroy(FrontendConstant::SLIDER_PLATFORM_PC);
    }
}
