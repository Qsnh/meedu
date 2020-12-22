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

use App\Bus\AuthBus;
use Illuminate\Http\Request;
use App\Businesses\BusinessState;
use App\Constant\FrontendConstant;
use Illuminate\Support\Facades\Auth;
use App\Services\Base\Services\ConfigService;
use App\Services\Member\Services\RoleService;
use App\Services\Member\Services\UserService;
use App\Services\Order\Services\OrderService;
use App\Services\Course\Services\VideoService;
use App\Services\Course\Services\CourseService;
use App\Services\Member\Services\CreditService;
use App\Services\Order\Services\PromoCodeService;
use App\Services\Member\Services\SocialiteService;
use App\Http\Requests\Frontend\Member\MobileBindRequest;
use App\Services\Base\Interfaces\ConfigServiceInterface;
use App\Services\Member\Interfaces\RoleServiceInterface;
use App\Services\Member\Interfaces\UserServiceInterface;
use App\Services\Order\Interfaces\OrderServiceInterface;
use App\Services\Course\Interfaces\VideoServiceInterface;
use App\Http\Requests\Frontend\Member\AvatarChangeRequest;
use App\Services\Course\Interfaces\CourseServiceInterface;
use App\Services\Member\Interfaces\CreditServiceInterface;
use App\Services\Member\Services\UserInviteBalanceService;
use App\Services\Order\Interfaces\PromoCodeServiceInterface;
use App\Services\Member\Interfaces\SocialiteServiceInterface;
use App\Http\Requests\Frontend\Member\MemberPasswordResetRequest;
use App\Http\Requests\Frontend\Member\InviteBalanceWithdrawRequest;
use App\Services\Member\Interfaces\UserInviteBalanceServiceInterface;

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
    /**
     * @var PromoCodeService
     */
    protected $promoCodeService;
    /**
     * @var BusinessState
     */
    protected $businessState;
    /**
     * @var UserInviteBalanceService
     */
    protected $userInviteBalanceService;

    public function __construct(
        UserServiceInterface $userService,
        CourseServiceInterface $courseService,
        VideoServiceInterface $videoService,
        RoleServiceInterface $roleService,
        OrderServiceInterface $orderService,
        SocialiteServiceInterface $socialiteService,
        ConfigServiceInterface $configService,
        PromoCodeServiceInterface $promoCodeService,
        BusinessState $businessState,
        UserInviteBalanceServiceInterface $userInviteBalanceService
    ) {
        $this->userService = $userService;
        $this->courseService = $courseService;
        $this->videoService = $videoService;
        $this->roleService = $roleService;
        $this->orderService = $orderService;
        $this->socialiteService = $socialiteService;
        $this->configService = $configService;
        $this->promoCodeService = $promoCodeService;
        $this->businessState = $businessState;
        $this->userInviteBalanceService = $userInviteBalanceService;
    }

    public function index()
    {
        $title = __('page_title_member_index');

        $courseCount = $this->userService->getUserCourseCount($this->id());
        $videoCount = $this->userService->getUserVideoCount($this->id());

        $apps = $this->socialiteService->userSocialites(Auth::id());
        $apps = array_column($apps, null, 'app');

        return v('frontend.member.index', compact('title', 'courseCount', 'videoCount', 'apps'));
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
    public function mobileBindHandler(MobileBindRequest $request, AuthBus $bus)
    {
        ['mobile' => $mobile] = $request->filldata();

        if ($this->check()) {
            // 已登录用户
            $this->userService->bindMobile($mobile);
        } elseif (session()->has(FrontendConstant::SOCIALITE_USER_INFO_KEY)) {
            // 社交登录用户需要强制绑定手机号
            // 当前状态下是没有登录的
            // 需要绑定指定的手机号之后才能做自动登录
            $socialiteApp = session(FrontendConstant::SOCIALITE_USER_INFO_KEY . '.app');
            $socialiteAppId = session(FrontendConstant::SOCIALITE_USER_INFO_KEY . '.app_id');
            $socialiteUser = session(FrontendConstant::SOCIALITE_USER_INFO_KEY . '.user');

            $userId = $bus->socialiteMobileBind($socialiteApp, $socialiteAppId, $socialiteUser, $mobile);

            // 自动登录
            return redirect($bus->socialiteRedirectTo($bus->socialiteLogin($userId)));
        }

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
     * @param AvatarChangeRequest $request
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
        $scene = $request->input('scene');
        $pageSize = 10;
        if (!$scene) {
            [
                'total' => $total,
                'list' => $list,
            ] = $this->userService->getUserBuyCourses($page, $pageSize);
            $courses = $this->courseService->getList(array_column($list, 'course_id'));
            $courses = array_column($courses, null, 'id');
        } elseif ($scene === 'history') {
            // 学习历史
            [
                'total' => $total,
                'list' => $list,
            ] = $this->courseService->userLearningCoursesPaginate(Auth::id(), $page, $pageSize);
            $courses = $this->courseService->getList(array_column($list, 'course_id'));
            $courses = array_column($courses, null, 'id');
        } elseif ($scene === 'like') {
            // 我的收藏
            [
                'total' => $total,
                'list' => $list,
            ] = $this->userService->userLikeCoursesPaginate(Auth::id(), $page, $pageSize);
            $courses = $this->courseService->getList(array_column($list, 'course_id'));
            $courses = array_column($courses, null, 'id');
        } else {
            // 购买的视频
            $videoIds = $this->userService->getUserBuyAllVideosId();
            $videos = $this->videoService->getList($videoIds);
            $courses = $this->courseService->getList(array_column($videos, 'course_id'));
            $courses = array_column($courses, null, 'id');
            $list = collect($videos)->groupBy('course_id')->toArray();
            $total = count($list);
        }
        $records = $this->paginator($list, $total, $page, $pageSize);

        $title = __('title.member.courses');

        $queryParams = function ($param) {
            $request = \request();
            $params = [
                'page' => $request->input('page'),
                'scene' => $request->input('scene', ''),
            ];
            $params = array_merge($params, $param);
            return http_build_query($params);
        };

        return v('frontend.member.buy_course', compact('records', 'title', 'courses', 'scene', 'queryParams'));
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

        return v('frontend.member.orders', compact('orders', 'title'));
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

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showPromoCodePage(Request $request)
    {
        $scene = $request->input('scene');
        $page = abs((int)$request->input('page', 1));
        $pageSize = 10;
        $userPromoCode = $this->promoCodeService->userPromoCode();
        $inviteConfig = $this->configService->getMemberInviteConfig();

        $inviteUsers = [];
        $balanceRecords = [];
        $withdrawOrders = [];

        if (!$scene) {
            // 邀请记录
            [
                'list' => $list,
                'total' => $total,
            ] = $this->userService->inviteUsers($page, $pageSize);
            $inviteUsers = $this->paginator($list, $total, $page, $pageSize);
            $inviteUsers->appends($request->all());
        } elseif ($scene === 'records') {
            // 余额明细
            [
                'list' => $list,
                'total' => $total,
            ] = $this->userInviteBalanceService->simplePaginate($page, $pageSize);
            $balanceRecords = $this->paginator($list, $total, $page, $pageSize);
            $balanceRecords->appends($request->all());
        } elseif ($scene === 'withdraw') {
            // 提现记录
            [
                'list' => $list,
                'total' => $total,
            ] = $this->userInviteBalanceService->currentUserOrderPaginate($page, $pageSize);
            $withdrawOrders = $this->paginator($list, $total, $page, $pageSize);
            $withdrawOrders->appends($request->all());
        }

        // 分页
        $queryParams = function ($param) {
            $request = \request();
            $params = [
                'page' => $request->input('page'),
                'scene' => $request->input('scene', ''),
            ];
            $params = array_merge($params, $param);
            return http_build_query($params);
        };

        $title = __('title.member.promo_code');
        return v('frontend.member.promo_code', compact(
            'userPromoCode',
            'title',
            'inviteConfig',
            'inviteUsers',
            'scene',
            'queryParams',
            'balanceRecords',
            'withdrawOrders'
        ));
    }

    public function generatePromoCode()
    {
        if (!$this->businessState->canGenerateInviteCode($this->user())) {
            flash(__('current user cant generate promo code'));
            return back();
        }
        $this->promoCodeService->userCreate($this->user());
        flash(__('success'), 'success');
        return redirect(route('member.promo_code'));
    }

    public function createInviteBalanceWithdrawOrder(InviteBalanceWithdrawRequest $request)
    {
        $total = $request->post('total');
        if ($this->user()['invite_balance'] < $total) {
            flash(__('Insufficient invite balance'));
            return back();
        }
        $data = $request->filldata();
        $this->userInviteBalanceService->createCurrentUserWithdraw($data['total'], $data['channel']);
        flash(__('success'), 'success');
        return back();
    }

    public function credit1Records(Request $request, CreditServiceInterface $creditService)
    {
        /**
         * @var CreditService $creditService
         */
        $page = $request->input('page', 1);
        $pageSize = 10;
        $records = $creditService->getCredit1RecordsPaginate(Auth::id(), $page, $pageSize);
        $total = $creditService->getCredit1RecordsCount(Auth::id());
        $records = $this->paginator($records, $total, $page, $pageSize);

        $title = __('title.member.credit1_records');
        return v('frontend.member.credit1_records', compact('title', 'records'));
    }

    public function showProfilePage()
    {
        $profile = $this->userService->getProfile($this->id());

        $title = __('member.profile.edit');

        return v('frontend.member.profile', compact('profile', 'title'));
    }
}
