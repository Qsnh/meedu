<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Listeners\VodVideoCreatedEvent;

use App\Events\VodVideoCreatedEvent;
use App\Meedu\Search\VideoSearchNotify;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SearchRecordNotify implements ShouldQueue
{
    use InteractsWithQueue;

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
     * @param VodVideoCreatedEvent $event
     * @return void
     */
    public function handle(VodVideoCreatedEvent $event)
    {
        app()->make(VideoSearchNotify::class)->create($event->id, $event->data);
    }
}
