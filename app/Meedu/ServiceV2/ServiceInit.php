<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\ServiceV2;

use App\Meedu\ServiceV2\Dao\UserDao;
use App\Meedu\ServiceV2\Dao\CourseDao;
use App\Meedu\ServiceV2\Dao\UserDaoInterface;
use App\Meedu\ServiceV2\Services\UserService;
use App\Meedu\ServiceV2\Dao\CourseDaoInterface;
use App\Meedu\ServiceV2\Services\CourseService;
use App\Meedu\ServiceV2\Services\UserServiceInterface;
use App\Meedu\ServiceV2\Services\CourseServiceInterface;

class ServiceInit
{
    public $dao = [
        UserDaoInterface::class => UserDao::class,
        CourseDaoInterface::class => CourseDao::class,
    ];

    public $service = [
        UserServiceInterface::class => UserService::class,
        CourseServiceInterface::class => CourseService::class,
    ];

    public function run()
    {
        foreach ($this->dao as $interface => $class) {
            app()->instance($interface, app()->make($class));
        }

        foreach ($this->service as $interface => $class) {
            app()->instance($interface, app()->make($class));
        }
    }
}
