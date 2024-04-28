<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Listeners\UserRegisterEvent;

use Carbon\Carbon;
use App\Events\UserRegisterEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\Member\Services\UserService;
use App\Services\Base\Interfaces\ConfigServiceInterface;
use App\Services\Member\Interfaces\UserServiceInterface;

class RegisterSendVipListener implements ShouldQueue
{
    use InteractsWithQueue;

    protected $configService;

    public function __construct(ConfigServiceInterface $configService)
    {
        $this->configService = $configService;
    }

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
