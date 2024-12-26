<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\ServiceV2;

use App\Meedu\ServiceV2\Dao\UserDao;
use App\Meedu\ServiceV2\Dao\OrderDao;
use App\Meedu\ServiceV2\Dao\OtherDao;
use App\Meedu\ServiceV2\Dao\CourseDao;
use App\Meedu\ServiceV2\Dao\UserDaoInterface;
use App\Meedu\ServiceV2\Services\UserService;
use App\Meedu\ServiceV2\Dao\OrderDaoInterface;
use App\Meedu\ServiceV2\Dao\OtherDaoInterface;
use App\Meedu\ServiceV2\Services\OrderService;
use App\Meedu\ServiceV2\Services\OtherService;
use App\Meedu\ServiceV2\Dao\CourseDaoInterface;
use App\Meedu\ServiceV2\Services\ConfigService;
use App\Meedu\ServiceV2\Services\CourseService;
use App\Meedu\ServiceV2\Services\UserServiceInterface;
use App\Meedu\ServiceV2\Services\OrderServiceInterface;
use App\Meedu\ServiceV2\Services\OtherServiceInterface;
use App\Meedu\ServiceV2\Services\ConfigServiceInterface;
use App\Meedu\ServiceV2\Services\CourseServiceInterface;

class ServiceInit
{
    public $dao = [
        OtherDaoInterface::class => OtherDao::class,
        UserDaoInterface::class => UserDao::class,
        CourseDaoInterface::class => CourseDao::class,
        OrderDaoInterface::class => OrderDao::class,
    ];

    public $service = [
        ConfigServiceInterface::class => ConfigService::class,
        OtherServiceInterface::class => OtherService::class,
        UserServiceInterface::class => UserService::class,
        CourseServiceInterface::class => CourseService::class,
        OrderServiceInterface::class => OrderService::class,
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
