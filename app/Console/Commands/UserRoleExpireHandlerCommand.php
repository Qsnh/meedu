<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
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
    protected $description = '用户会员过期处理';

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
        $this->line(sprintf('本次处理%d位过期用户', $count));
    }
}
