<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Listeners;

use App\Models\AdFrom;
use App\Events\AdFromEvent;
use Illuminate\Support\Facades\Cache;

class AdFromListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param AdFromEvent $event
     */
    public function handle(AdFromEvent $event)
    {
        $key = $event->key;
        $adFrom = AdFrom::whereFromKey($key)->first();
        if (! $adFrom) {
            return;
        }
        $key = sprintf('ad_from_%s_%s', $adFrom->from_key, date('Y-m-d'));
        if (! Cache::has($key)) {
            Cache::forever($key, 1);
        } else {
            Cache::increment($key);
        }
    }
}
