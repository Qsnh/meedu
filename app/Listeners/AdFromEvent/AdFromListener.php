<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Listeners\AdFromEvent;

use App\Events\AdFromEvent;
use Illuminate\Support\Facades\Cache;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\Other\Services\AdFromService;
use App\Services\Other\Interfaces\AdFromServiceInterface;

class AdFromListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * @var AdFromService
     */
    protected $adFromService;

    /**
     * AdFromListener constructor.
     * @param AdFromServiceInterface $adFromService
     */
    public function __construct(AdFromServiceInterface $adFromService)
    {
        $this->adFromService = $adFromService;
    }

    /**
     * Handle the event.
     *
     * @param AdFromEvent $event
     */
    public function handle(AdFromEvent $event)
    {
        $key = $event->key;
        $adFrom = $this->adFromService->findFromKey($key);
        if (!$adFrom) {
            return;
        }
        $key = sprintf('ad_from_%s_%s', $adFrom->from_key, date('Y-m-d'));
        if (!Cache::has($key)) {
            Cache::forever($key, 1);
        } else {
            Cache::increment($key);
        }
    }
}
