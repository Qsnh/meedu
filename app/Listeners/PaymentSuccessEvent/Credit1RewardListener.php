<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Listeners\PaymentSuccessEvent;

use App\Events\PaymentSuccessEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\Base\Services\ConfigService;
use App\Services\Member\Services\CreditService;
use App\Services\Member\Services\NotificationService;
use App\Services\Base\Interfaces\ConfigServiceInterface;
use App\Services\Member\Interfaces\CreditServiceInterface;
use App\Services\Member\Interfaces\NotificationServiceInterface;

class Credit1RewardListener implements ShouldQueue
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
     * Credit1RewardListener constructor.
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
     * @param PaymentSuccessEvent $event
     * @return void
     */
    public function handle(PaymentSuccessEvent $event)
    {
        $credit1RewardRate = $this->configService->getPaidOrderSceneCredit1();
        $rewardCredit1 = (int)($credit1RewardRate * $event->order['charge']);
        if ($rewardCredit1 <= 0) {
            return;
        }

        $message = sprintf(__('已支付订单送%d积分'), $rewardCredit1);
        $this->creditService->createCredit1Record($event->order['user_id'], $rewardCredit1, $message);
        $this->notificationService->notifyCredit1Message($event->order['user_id'], $rewardCredit1, $message);
    }
}
