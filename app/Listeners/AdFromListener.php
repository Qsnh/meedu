<?php

namespace App\Listeners;

use App\Events\AdFromEvent;
use App\Models\AdFrom;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Cache;

class AdFromListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  AdFromEvent  $event
     * @return void
     */
    public function handle(AdFromEvent $event)
    {
        $key = $event->key;
        $adFrom = AdFrom::whereFromKey($key)->first();
        if (! $adFrom) {
            return;
        }
        $key = sprintf("ad_from_%s_%s", $key, date('Y-m-d'));
        if (! Cache::has($key)) {
            Cache::forever($key, 1);
        } else {
            Cache::increment($key);
        }
    }
}
