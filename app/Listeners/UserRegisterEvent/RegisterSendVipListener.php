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

use Carbon\Carbon;
use App\Events\UserRegisterEvent;
use App\Services\Base\Services\ConfigService;
use App\Services\Member\Services\UserService;
use App\Services\Base\Interfaces\ConfigServiceInterface;
use App\Services\Member\Interfaces\UserServiceInterface;

class RegisterSendVipListener
{

    /**
     * @var ConfigService
     */
    protected $configService;

    /**
     * RegisterSendVipListener constructor.
     * @param ConfigServiceInterface $configService
     */
    public function __construct(ConfigServiceInterface $configService)
    {
        $this->configService = $configService;
    }

    /**
     * Handle the event.
     *
     * @param UserRegisterEvent $event
     * @return void
     */
    public function handle(UserRegisterEvent $event)
    {
        $config = $this->configService->getMemberRegisterSendVipConfig();
        $enabled = (int)($config['enabled'] ?? 0);
        if ($enabled === 0) {
            // 未开启
            return;
        }

        $roleId = (int)($config['role_id'] ?? 0);
        $days = (int)($config['days'] ?? 0);
        if (!$roleId || !$days) {
            // 参数不正确
            return;
        }

        /**
         * @var UserService $userService
         */
        $userService = app()->make(UserServiceInterface::class);
        $userService->changeRole($event->userId, $roleId, Carbon::now()->addDays($days));
    }
}
