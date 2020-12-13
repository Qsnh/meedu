<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Jobs;

use App\Meedu\Ip;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Services\Member\Services\UserService;
use App\Services\Member\Interfaces\UserServiceInterface;

class UserRegisterIpToAreaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $userId;
    public $times;

    /**
     * UserRegisterIpToAreaJob constructor.
     * @param $userId
     * @param int $times
     */
    public function __construct($userId, $times = 0)
    {
        $this->userId = $userId;
        $this->times = $times;
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function handle()
    {
        try {
            /**
             * @var UserService $userService
             */
            $userService = app()->make(UserServiceInterface::class);
            $user = $userService->find($this->userId);
            if (!$user['register_ip']) {
                Log::info(__METHOD__ . '|用户注册ip为空', ['id' => $this->userId]);
                return;
            }

            $area = Ip::ip2area($user['register_ip']);
            if (!$area) {
                return;
            }

            $userService->setRegisterArea($this->userId, $area);
        } catch (\Exception $e) {
            exception_record($e);
        }
    }
}
