<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Listeners\VodVideoDestroyedEvent;

use App\Events\VodVideoDestroyedEvent;
use App\Meedu\Search\VideoSearchNotify;

class SearchRecordNotify
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
     * @param VodVideoDestroyedEvent $event
     * @return void
     */
    public function handle(VodVideoDestroyedEvent $event)
    {
        app()->make(VideoSearchNotify::class)->delete($event->id);
    }
}
