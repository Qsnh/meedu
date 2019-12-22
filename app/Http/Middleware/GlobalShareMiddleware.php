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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Services\Other\Services\NavService;
use App\Services\Member\Services\RoleService;
use App\Services\Member\Services\UserService;
use App\Services\Course\Services\VideoService;
use App\Services\Course\Services\CourseService;
use App\Services\Other\Services\AnnouncementService;

class GlobalShareMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /**
         * @var UserService
         */
        $userService = app()->make(UserService::class);
        /**
         * @var NavService
         */
        $navService = app()->make(NavService::class);
        /**
         * @var CourseService
         */
        $courseService = app()->make(CourseService::class);
        /**
         * @var VideoService
         */
        $videoServices = app()->make(VideoService::class);
        /**
         * @var RoleService
         */
        $roleServices = app()->make(RoleService::class);
        /**
         * @var AnnouncementService
         */
        $announcementService = app()->make(AnnouncementService::class);

        // user变量共享
        $user = Auth::check() ? $userService->find(Auth::id(), ['role']) : [];
        View::share('user', $user);

        // nav
        $navs = $navService->all();
        View::share('gNavs', $navs);

        // 最新课程
        $latestCourses = $courseService->getLatestCourses(5);
        View::share('gLatestCourses', $latestCourses);

        // 最新视频
        $latestVideos = $videoServices->getLatestVideos(10);
        View::share('gLatestVideos', $latestVideos);

        // 套餐
        $roles = $roleServices->all();
        View::share('gRoles', $roles);

        // 公告
        $announcement = $announcementService->latest();
        View::share('gAnnouncement', $announcement);

        return $next($request);
    }
}
