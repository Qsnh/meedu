<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Listeners\VodCourseCreatedEvent;

use App\Events\VodCourseCreatedEvent;
use App\Meedu\Search\VodSearchNotify;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SearchRecordNotify implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param VodCourseCreatedEvent $event
     * @return void
     */
    public function handle(VodCourseCreatedEvent $event)
    {
        app()->make(VodSearchNotify::class)->create($event->id, $event->data);
    }
}
