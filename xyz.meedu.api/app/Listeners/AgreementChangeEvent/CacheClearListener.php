<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Listeners\AgreementChangeEvent;

use App\Events\AgreementChangeEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Meedu\Cache\Impl\ActiveAgreementCache;

class CacheClearListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param \App\Events\AgreementChangeEvent $event
     * @return void
     */
    public function handle(AgreementChangeEvent $event): void
    {
        ActiveAgreementCache::forget($event->type);
    }
}
