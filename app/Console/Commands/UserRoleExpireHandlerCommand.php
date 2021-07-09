<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Member\Services\UserService;
use App\Services\Member\Interfaces\UserServiceInterface;

class UserRoleExpireHandlerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'member:role:expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '用户VIP过期自动清除命令';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /**
         * @var UserService $userService
         */
        $userService = app()->make(UserServiceInterface::class);
        $count = $userService->resetRoleExpiredUsers();
        $this->line(sprintf(__('本次处理%d位VIP已过期用户'), $count));
    }
}
