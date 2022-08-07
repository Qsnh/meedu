<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\ServiceV2;

use Tests\TestCase;
use App\Meedu\ServiceV2\Models\User;
use App\Meedu\ServiceV2\Models\UserDeleteJob;
use App\Meedu\ServiceV2\Services\UserServiceInterface;

class UserServiceTest extends TestCase
{
    public function test_destroyUser()
    {
        /**
         * @var UserServiceInterface $userService
         */
        $userService = $this->app->make(UserServiceInterface::class);

        $user = User::factory()->create();

        $userService->destroyUser($user['id']);

        $this->assertFalse(User::query()->where('id', $user['id'])->exists());
    }

    public function test_userDeleteBatchHandle()
    {
        /**
         * @var UserServiceInterface $userService
         */
        $userService = $this->app->make(UserServiceInterface::class);

        $userService->userDeleteBatchHandle();

        // 模拟数据
        $users = UserDeleteJob::factory()->count(10)->create();

        $userService->userDeleteBatchHandle();

        $this->assertEquals(0, User::query()->whereIn('id', $users->pluck('id')->toArray())->count());
    }
}
