<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Meedu\ServiceV2\Services\UserServiceInterface;

class UserDeleteJobRunCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'meedu:user-delete-job';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '用户注销任务执行程序';

    public function handle()
    {
        /**
         * @var UserServiceInterface $userService
         */
        $userService = app()->make(UserServiceInterface::class);
        $userService->userDeleteBatchHandle();

        return Command::SUCCESS;
    }
}
