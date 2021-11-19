<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Listeners\VodVideoUpdatedEvent;

use App\Events\VodVideoUpdatedEvent;
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
     * @param  VodVideoUpdatedEvent  $event
     * @return void
     */
    public function handle(VodVideoUpdatedEvent $event)
    {
        app()->make(VideoSearchNotify::class)->create($event->id, $event->data);
    }
}
