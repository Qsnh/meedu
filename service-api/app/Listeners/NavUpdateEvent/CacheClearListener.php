<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Listeners\NavUpdateEvent;

use App\Events\NavUpdateEvent;
use App\Constant\FrontendConstant;
use App\Meedu\Cache\Impl\NavCache;

class CacheClearListener
{

    private $navCache;

    public function __construct(NavCache $navCache)
    {
        $this->navCache = $navCache;
    }

    public function handle(NavUpdateEvent $event)
    {
        $this->navCache->destroy(FrontendConstant::NAV_PLATFORM_PC);
        $this->navCache->destroy(FrontendConstant::NAV_PLATFORM_H5);
    }
}
