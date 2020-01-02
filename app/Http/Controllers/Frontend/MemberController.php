<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\Base\Services\ConfigService;
use App\Services\Member\Services\RoleService;
use App\Services\Member\Services\UserService;
use App\Services\Order\Services\OrderService;
use App\Services\Course\Services\VideoService;
use App\Services\Course\Services\CourseService;
use App\Services\Member\Services\SocialiteService;
use App\Http\Requests\Frontend\Member\MobileBindRequest;
use App\Services\Base\Interfaces\ConfigServiceInterface;
use App\Services\Member\Interfaces\RoleServiceInterface;
use App\Services\Member\Interfaces\UserServiceInterface;
use App\Services\Order\Interfaces\OrderServiceInterface;
use App\Services\Course\Interfaces\VideoServiceInterface;
use App\Http\Requests\Frontend\Member\AvatarChangeRequest;
use App\Services\Course\Interfaces\CourseServiceInterface;
use App\Services\Member\Interfaces\SocialiteServiceInterface;
use App\Http\Requests\Frontend\Member\MemberPasswordResetRequest;

class MemberController extends FrontendController
{
    /**
     * @var UserService
     */
    protected $userService;
    /**
     * @var CourseService
     */
    protected $courseService;
    /**
     * @var VideoService
     */
    protected $videoService;
    /**
     * @var RoleService
     */
    protected $roleService;
    /**
     * @var OrderService
     */
    protected $orderService;
    /**
     * @var SocialiteService
     */
    protected $socialiteService;
    /**
     * @var ConfigService
     */
    protected $configService;

    public function __construct(
        UserServiceInterface $userService,
        CourseServiceInterface $courseService,
        VideoServiceInterface $videoService,
        RoleServiceInterface $roleService,
        OrderServiceInterface $orderService,
        SocialiteServiceInterface $socialiteService,
        ConfigServiceInterface $configService
    ) {
        $this->userService = $userService;
        $this->courseService = $courseService;
        $this->videoService = $videoService;
        $this->roleService = $roleService;
        $this->orderService = $orderService;
        $this->socialiteService = $socialiteService;
        $this->configService = $configService;
    }

    public function index()
    {
        $title = __('page_title_member_index');

        return v('frontend.member.index', compact('title'));
    }

    public function showPasswordResetPage()
    {
        $title = __('title.member.password.change');

        return v('frontend.member.password_reset', compact('title'));
    }

    public function showMobileBindPage()
    {
        $title = __('title.member.bind.mobile');

        return v('frontend.member.mobile_bind', compact('title'));
    }

    /**
     * @param MobileBindRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     *
     * @throws \App\Exceptions\ServiceException
     */
    public function mobileBindHandler(MobileBindRequest $request)
    {
        ['mobile' => $mobile] = $request->filldata();
        $this->userService->bindMobile($mobile);
        flash(__('success'), 'success');

        return redirect(route('member'));
    }

    /**
     * @param MemberPasswordResetRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception
     */
    public function passwordResetHandler(MemberPasswordResetRequest $request)
    {
        ['old_password' => $oldPassword, 'new_password' => $newPassword] = $request->filldata();
        $this->userService->resetPassword(Auth::id(), $oldPassword, $newPassword);
        flash(__('success'), 'success');

        return back();
    }

    public function showAvatarChangePage()
    {
        $title = __('title.member.avatar');

        return v('frontend.member.avatar', compact('title'));
    }

    /**
     * 头像更换.
     *
     * @param AvatarChangeRequest $request
     * @param MemberRepository $repository
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function avatarChangeHandler(AvatarChangeRequest $request)
    {
        ['url' => $url] = $request->filldata();
        $this->userService->updateAvatar(Auth::id(), $url);
        flash(__('success'), 'success');

        return back();
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showJoinRoleRecordsPage(Request $request)
    {
        $page = $request->input('page', 1);
        $pageSize = 10;
        [
            'total' => $total,
            'list' => $list,
        ] = $this->roleService->userRolePaginate($page, $pageSize);
        $records = $this->paginator($list, $total, $page, $pageSize);
        $title = __('title.member.vip');

        return v('frontend.member.join_role_records', compact('records', 'title'));
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showMessagesPage(Request $request)
    {
        $page = $request->input('page', 1);
        $pageSize = 10;
        [
            'total' => $total,
            'list' => $list,
        ] = $this->userService->messagePaginate($page, $pageSize);
        $messages = $this->paginator($list, $total, $page, $pageSize);
        $title = __('title.member.notification');

        return v('frontend.member.messages', compact('messages', 'title'));
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showBuyCoursePage(Request $request)
    {
        $page = $request->input('page', 1);
        $pageSize = 10;
        [
            'total' => $total,
            'list' => $list,
        ] = $this->userService->getUserBuyCourses($page, $pageSize);
        $records = $this->paginator($list, $total, $page, $pageSize);
        $courses = $this->courseService->getList(array_column($list, 'course_id'));
        $courses = array_column($courses, null, 'id');

        $title = __('title.member.courses');

        return v('frontend.member.buy_course', compact('records', 'title', 'courses'));
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showBuyVideoPage(Request $request)
    {
        $page = $request->input('page', 1);
        $pageSize = 10;
        [
            'total' => $total,
            'list' => $list,
        ] = $this->userService->getUserBuyVideos($page, $pageSize);
        $records = $this->paginator($list, $total, $page, $pageSize);
        $videos = $this->videoService->getList(array_column($list, 'video_id'));
        $videos = array_column($videos, null, 'id');

        $title = __('title.member.videos');

        return v('frontend.member.buy_video', compact('videos', 'title', 'records'));
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showOrdersPage(Request $request)
    {
        $page = $request->input('page', 1);
        $pageSize = 10;
        [
            'total' => $total,
            'list' => $list,
        ] = $this->orderService->userOrdersPaginate($page, $pageSize);
        $orders = $this->paginator($list, $total, $page, $pageSize);
        $title = __('title.member.orders');

        return v('frontend.member.show_orders', compact('orders', 'title'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showSocialitePage()
    {
        $enabledApps = $this->configService->getEnabledSocialiteApps();
        $apps = $this->socialiteService->userSocialites(Auth::id());
        $apps = array_column($apps, null, 'app');
        $title = __('title.member.socialite');

        return v('frontend.member.socialite', compact('apps', 'title', 'enabledApps'));
    }

    /**
     * @param $app
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancelBindSocialite($app)
    {
        $this->socialiteService->cancelBind($app);
        flash(__('success'), 'success');
        return back();
    }
}
