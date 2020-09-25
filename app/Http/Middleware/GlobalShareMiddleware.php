<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Middleware;

use Closure;
use App\Businesses\BusinessState;
use App\Constant\FrontendConstant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Services\Other\Services\NavService;
use App\Services\Base\Services\ConfigService;
use App\Services\Member\Services\RoleService;
use App\Services\Member\Services\UserService;
use App\Services\Course\Services\VideoService;
use App\Services\Course\Services\CourseService;
use App\Services\Other\Services\AnnouncementService;
use App\Services\Member\Services\NotificationService;
use App\Services\Other\Interfaces\NavServiceInterface;
use App\Services\Base\Interfaces\ConfigServiceInterface;
use App\Services\Member\Interfaces\RoleServiceInterface;
use App\Services\Member\Interfaces\UserServiceInterface;
use App\Services\Course\Interfaces\VideoServiceInterface;
use App\Services\Course\Interfaces\CourseServiceInterface;
use App\Services\Other\Interfaces\AnnouncementServiceInterface;
use App\Services\Member\Interfaces\NotificationServiceInterface;

class GlobalShareMiddleware
{

    /**
     * @var BusinessState
     */
    protected $businessState;

    public function __construct(BusinessState $businessState)
    {
        $this->businessState = $businessState;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /**
         * @var $userService UserService
         */
        $userService = app()->make(UserServiceInterface::class);
        /**
         * @var $navService NavService
         */
        $navService = app()->make(NavServiceInterface::class);
        /**
         * @var $courseService CourseService
         */
        $courseService = app()->make(CourseServiceInterface::class);
        /**
         * @var $videoServices VideoService
         */
        $videoServices = app()->make(VideoServiceInterface::class);
        /**
         * @var $roleServices RoleService
         */
        $roleServices = app()->make(RoleServiceInterface::class);
        /**
         * @var $announcementService AnnouncementService
         */
        $announcementService = app()->make(AnnouncementServiceInterface::class);
        /**
         * @var $notificationService NotificationService
         */
        $notificationService = app()->make(NotificationServiceInterface::class);
        /**
         * @var $configService ConfigService
         */
        $configService = app()->make(ConfigServiceInterface::class);

        // user变量共享
        $user = Auth::check() ? $userService->find(Auth::id(), ['role']) : [];
        View::share('user', $user);

        // 是否需要绑定手机号
        $bindMobileState = false;
        if (Auth::check() && (int)config('meedu.member.enabled_mobile_bind_alert') === 1 && $this->businessState->isNeedBindMobile($user)) {
            $bindMobileState = true;
        }
        View::share('bindMobileState', $bindMobileState);

        // 未读消息数量
        $unreadMessageCount = Auth::check() ? $notificationService->getUnreadCount() : 0;
        View::share('gUnreadMessageCount', $unreadMessageCount);

        // nav
        $navs = $navService->all(is_h5() ? FrontendConstant::NAV_PLATFORM_H5 : FrontendConstant::NAV_PLATFORM_PC);
        View::share('gNavs', $navs);

        // 最新课程
        $latestCourses = $courseService->getLatestCourses(10);
        View::share('gLatestCourses', $latestCourses);

        // 推荐课程
        $gRecCourses = $courseService->getRecCourses(10);
        View::share('gRecCourses', $gRecCourses);

        // 最新视频
        $latestVideos = $videoServices->getLatestVideos(10);
        View::share('gLatestVideos', $latestVideos);

        // 套餐
        $roles = $roleServices->all();
        View::share('gRoles', $roles);

        // 公告
        $announcement = $announcementService->latest();
        View::share('gAnnouncement', $announcement);

        // meedu配置
        $config = $configService->getMeEduConfig();
        View::share('gConfig', $config);

        return $next($request);
    }
}
