<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Listeners\UserRegisterEvent;

use App\Events\UserRegisterEvent;
use App\Constant\FrontendConstant;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\Base\Services\ConfigService;
use App\Services\Member\Services\CreditService;
use App\Services\Base\Interfaces\ConfigServiceInterface;
use App\Services\Member\Interfaces\CreditServiceInterface;

class RegisterCredit1RewardListener implements ShouldQueue
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
     * RegisterCredit1RewardListener constructor.
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
     * @param UserRegisterEvent $event
     * @return void
     */
    public function handle(UserRegisterEvent $event)
    {
        $credit1 = $this->configService->getRegisterSceneCredit1();
        if ($credit1 <= 0) {
            // 未开启注册送积分
            return;
        }

        $this->creditService->createCredit1Record($event->userId, $credit1, __(FrontendConstant::CREDIT1_REMARK_REGISTER));
    }
}
