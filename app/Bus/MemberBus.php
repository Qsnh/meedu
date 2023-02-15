<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Bus;

use App\Meedu\ServiceV2\Services\UserServiceInterface;

class MemberBus
{
    protected $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function isVerify(int $userId): bool
    {
        $profile = $this->userService->findUserProfile($userId);
        return $profile['is_verify'] === 1;
    }
}
