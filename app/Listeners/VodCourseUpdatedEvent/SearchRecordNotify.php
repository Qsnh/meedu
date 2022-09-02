<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Listeners\VodCourseUpdatedEvent;

use App\Events\VodCourseUpdatedEvent;
use App\Meedu\Search\VodSearchNotify;
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
     * @param  VodCourseUpdatedEvent  $event
     * @return void
     */
    public function handle(VodCourseUpdatedEvent $event)
    {
        app()->make(VodSearchNotify::class)->update($event->id, $event->data);
    }
}
