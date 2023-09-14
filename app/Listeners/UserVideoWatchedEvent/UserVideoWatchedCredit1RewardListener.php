<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Listeners\UserVideoWatchedEvent;

use App\Events\UserVideoWatchedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\Base\Services\ConfigService;
use App\Services\Member\Services\CreditService;
use App\Services\Member\Services\NotificationService;
use App\Services\Base\Interfaces\ConfigServiceInterface;
use App\Services\Member\Interfaces\CreditServiceInterface;
use App\Services\Member\Interfaces\NotificationServiceInterface;

class UserVideoWatchedCredit1RewardListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * @var ConfigService
     */
    protected $configService;

    /**
     * @var CreditService
     */
    protected $creditService;

    /**
     * @var NotificationService
     */
    protected $notificationService;

    /**
     * UserCourseWatchedCredit1RewardListener constructor.
     * @param ConfigServiceInterface $configService
     * @param CreditServiceInterface $creditService
     * @param NotificationServiceInterface $notificationService
     */
    public function __construct(ConfigServiceInterface $configService, CreditServiceInterface $creditService, NotificationServiceInterface $notificationService)
    {
        $this->configService = $configService;
        $this->creditService = $creditService;
        $this->notificationService = $notificationService;
    }

    /**
     * Handle the event.
     *
     * @param UserVideoWatchedEvent $event
     * @return void
     */
    public function handle(UserVideoWatchedEvent $event)
    {
        $credit1 = $this->configService->getWatchedVideoSceneCredit1();
        if ($credit1 <= 0) {
            return;
        }

        $message = sprintf(__('看完视频送%d积分'), $credit1);
        $this->creditService->createCredit1Record($event->userId, $credit1, $message);
        $this->notificationService->notifyCredit1Message($event->userId, $credit1, $message);
    }
}
