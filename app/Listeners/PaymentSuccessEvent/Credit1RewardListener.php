<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Listeners\PaymentSuccessEvent;

use App\Constant\FrontendConstant;
use App\Events\PaymentSuccessEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\Base\Services\ConfigService;
use App\Services\Member\Services\CreditService;
use App\Services\Base\Interfaces\ConfigServiceInterface;
use App\Services\Member\Interfaces\CreditServiceInterface;

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
     * Credit1RewardListener constructor.
     * @param ConfigServiceInterface $configService
     * @param CreditServiceInterface $creditService
     */
    public function __construct(ConfigServiceInterface $configService, CreditServiceInterface $creditService)
    {
        $this->configService = $configService;
        $this->creditService = $creditService;
    }

    /**
     * Handle the event.
     *
     * @param PaymentSuccessEvent $event
     * @return void
     */
    public function handle(PaymentSuccessEvent $event)
    {
        $credit1 = $this->configService->getPaidOrderSceneCredit1();
        $credit = $credit1 * 100 * $event->order['charge'];
        if ($credit <= 0) {
            // 未开启积分奖励
            return;
        }

        // 赠送积分
        $this->creditService->createCredit1Record($event->order['user_id'], $credit, __(FrontendConstant::CREDIT1_REMARK_WATCHED_ORDER));
    }
}
