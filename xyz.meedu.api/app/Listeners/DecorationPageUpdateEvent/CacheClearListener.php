<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Listeners\DecorationPageUpdateEvent;

use App\Events\DecorationPageUpdateEvent;
use App\Meedu\Cache\Impl\DecorationPageCache;

class CacheClearListener
{

    private $decorationPageCache;

    public function __construct(DecorationPageCache $decorationPageCache)
    {
        $this->decorationPageCache = $decorationPageCache;
    }

    public function handle(DecorationPageUpdateEvent $event)
    {
        $this->decorationPageCache->destroy($event->pageKey);
    }
}
