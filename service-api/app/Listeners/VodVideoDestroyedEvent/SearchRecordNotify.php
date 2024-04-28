<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Listeners\VodVideoDestroyedEvent;

use App\Events\VodVideoDestroyedEvent;
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
     * @param VodVideoDestroyedEvent $event
     * @return void
     */
    public function handle(VodVideoDestroyedEvent $event)
    {
        app()->make(VideoSearchNotify::class)->delete($event->id);
    }
}
