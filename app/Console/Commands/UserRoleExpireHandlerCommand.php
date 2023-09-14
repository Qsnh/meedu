<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Member\Services\UserService;
use App\Services\Member\Interfaces\UserServiceInterface;

class UserRoleExpireHandlerCommand extends Command
{
    protected $signature = 'member:role:expired';

    protected $description = '用户VIP过期自动清除命令';

    public function handle()
    {
        /**
         * @var UserService $userService
         */
        $userService = app()->make(UserServiceInterface::class);
        $count = $userService->resetRoleExpiredUsers();
        $this->line(sprintf(__('本次处理%d位VIP已过期用户'), $count));
        return 0;
    }
}
