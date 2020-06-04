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

            $localIp = [
                '127.0.0.1' => true,
                'localhost' => true,
            ];

            if (isset($localIp[$user['register_ip']])) {
                $area = '本地';
            } else {
                $area = Ip::ip2area($user['register_ip']);
                if ($area === false) {
                    // 再试一次
                    if ($this->times < 1) {
                        dispatch(new UserRegisterIpToAreaJob($this->userId, $this->times + 1))->delay(3);
                    }
                    return;
                }
            }

            $userService->setRegisterArea($this->userId, $area);
        } catch (\Exception $e) {
            Log::error(__METHOD__ . '|' . __METHOD__ . '执行失败', ['user_id' => $this->userId, 'error' => $e->getMessage()]);
        }
    }
}
