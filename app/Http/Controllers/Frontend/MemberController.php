<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

namespace App\Http\Controllers\Frontend;

use App\Bus\AuthBus;
use Illuminate\Http\Request;
use App\Businesses\BusinessState;
use App\Exceptions\ServiceException;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Services\Member\Services\RoleService;
use App\Services\Member\Services\UserService;
use App\Services\Order\Services\OrderService;
use App\Services\Course\Services\VideoService;
use App\Services\Course\Services\CourseService;
use App\Services\Member\Services\CreditService;
use App\Services\Order\Services\PromoCodeService;
use App\Services\Member\Services\SocialiteService;
use App\Http\Requests\Frontend\Member\MobileBindRequest;
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
     * @var BusinessState
     */
    protected $businessState;

    public function __construct(
        UserServiceInterface $userService,
        BusinessState $businessState
    ) {
        parent::__construct();

        $this->userService = $userService;
        $this->businessState = $businessState;
    }

    public function index(SocialiteServiceInterface $socialiteService)
    {
        /**
         * @var SocialiteService $socialiteService
         */

        $title = __('page_title_member_index');

        $courseCount = $this->userService->getUserCourseCount($this->id());
        $videoCount = $this->userService->getUserVideoCount($this->id());

        $apps = $socialiteService->userSocialites($this->id());
        $apps = array_column($apps, null, 'app');

        return v('frontend.member.index', compact('title', 'courseCount', 'videoCount', 'apps'));
    }

    // 密码重置[界面]
    public function showPasswordResetPage()
    {
        $title = __('title.member.password.change');

        return v('frontend.member.password_reset', compact('title'));
    }

    // 密码重置[提交]
    public function passwordResetHandler(MemberPasswordResetRequest $request)
    {
        ['old_password' => $oldPassword, 'new_password' => $newPassword] = $request->filldata();
        $this->userService->resetPassword($this->id(), $oldPassword, $newPassword);
        flash(__('success'), 'success');

        return back();
    }

    // 手机号绑定[界面]
    public function showMobileBindPage()
    {
        $title = __('title.member.bind.mobile');

        return v('frontend.member.mobile_bind', compact('title'));
    }

    // 手机号绑定[提交]
    public function mobileBindHandler(MobileBindRequest $request, AuthBus $bus)
    {
        ['mobile' => $mobile] = $request->filldata();

        $this->userService->bindMobile($mobile, $this->id());

        flash(__('success'), 'success');

        return redirect(route('member'));
    }

    // 头像修改[界面]
    public function showAvatarChangePage()
    {
        $title = __('title.member.avatar');

        return v('frontend.member.avatar', compact('title'));
    }

    // 头像修改[提交]
    public function avatarChangeHandler(AvatarChangeRequest $request)
    {
        ['url' => $url] = $request->filldata();

        $this->userService->updateAvatar($this->id(), $url);

        flash(__('success'), 'success');

        return back();
    }

    // VIP会员购买记录
    public function showJoinRoleRecordsPage(RoleServiceInterface $roleService, Request $request)
    {
        /**
         * @var RoleService $roleService
         */

        $page = $request->input('page', 1);
        $pageSize = 10;

        [
            'total' => $total,
            'list' => $list,
        ] = $roleService->userRolePaginate($page, $pageSize);

        $records = $this->paginator($list, $total, $page, $pageSize);

        $title = __('title.member.vip');

        return v('frontend.member.join_role_records', compact('records', 'title'));
    }

    // 我的消息
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

    // 我的课程
    public function showBuyCoursePage(CourseServiceInterface $courseService, VideoServiceInterface $videoService, Request $request)
    {
        /**
         * @var CourseService $courseService
         */
        /**
         * @var VideoService $videoService
         */

        $page = $request->input('page', 1);
        $scene = $request->input('scene');
        $pageSize = 10;

        if (!$scene) {
            [
                'total' => $total,
                'list' => $list,
            ] = $this->userService->getUserBuyCourses($page, $pageSize);
            $courses = $courseService->getList(array_column($list, 'course_id'));
            $courses = array_column($courses, null, 'id');
        } elseif ($scene === 'history') {
            // 学习历史
            [
                'total' => $total,
                'list' => $list,
            ] = $courseService->userLearningCoursesPaginate($this->id(), $page, $pageSize);
            $courses = $courseService->getList(array_column($list, 'course_id'));
            $courses = array_column($courses, null, 'id');
        } elseif ($scene === 'like') {
            // 我的收藏
            [
                'total' => $total,
                'list' => $list,
            ] = $this->userService->userLikeCoursesPaginate($this->id(), $page, $pageSize);
            $courses = $courseService->getList(array_column($list, 'course_id'));
            $courses = array_column($courses, null, 'id');
        } else {
            // 购买的视频
            $videoIds = $this->userService->getUserBuyAllVideosId();
            $videos = $videoService->getList($videoIds);
            $courses = $courseService->getList(array_column($videos, 'course_id'));
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

    // 我的视频
    public function showBuyVideoPage(VideoServiceInterface $videoService, Request $request)
    {
        /**
         * @var VideoService $videoService
         */

        $page = $request->input('page', 1);
        $pageSize = 10;
        [
            'total' => $total,
            'list' => $list,
        ] = $this->userService->getUserBuyVideos($page, $pageSize);
        $records = $this->paginator($list, $total, $page, $pageSize);
        $videos = $videoService->getList(array_column($list, 'video_id'));
        $videos = array_column($videos, null, 'id');

        $title = __('title.member.videos');

        return v('frontend.member.buy_video', compact('videos', 'title', 'records'));
    }

    // 我的订单
    public function showOrdersPage(OrderServiceInterface $orderService, Request $request)
    {
        /**
         * @var OrderService $orderService
         */

        $page = $request->input('page', 1);
        $pageSize = 10;

        [
            'total' => $total,
            'list' => $list,
        ] = $orderService->userOrdersPaginate($page, $pageSize);

        $orders = $this->paginator($list, $total, $page, $pageSize);

        $title = __('title.member.orders');

        return v('frontend.member.orders', compact('orders', 'title'));
    }

    // 社交登录界面
    public function showSocialitePage(SocialiteServiceInterface $socialiteService)
    {
        /**
         * @var SocialiteService $socialiteService
         */

        $enabledApps = $this->configService->getEnabledSocialiteApps();

        $apps = $socialiteService->userSocialites($this->id());
        $apps = array_column($apps, null, 'app');

        $title = __('title.member.socialite');

        return v('frontend.member.socialite', compact('apps', 'title', 'enabledApps'));
    }

    // 社交登录[绑定操作]
    public function socialiteBind(SocialiteServiceInterface $socialiteService, $app)
    {
        /**
         * @var SocialiteService $socialiteService
         */

        $hasBindSocialites = $socialiteService->userSocialites($this->id());
        if (in_array($app, array_column($hasBindSocialites, 'app'))) {
            throw new ServiceException(__('您已经绑定了该渠道的账号'));
        }

        // 临时修改配置的回调地址
        config(['services.qq.redirect' => route('member.socialite.bind.callback', [$app])]);

        return Socialite::driver($app)->redirect();
    }

    // 社交登录[绑定回调]
    public function socialiteBindCallback(SocialiteServiceInterface $socialiteService, $app)
    {
        /**
         * @var SocialiteService $socialiteService
         */

        $hasBindSocialites = $socialiteService->userSocialites($this->id());
        if (in_array($app, array_column($hasBindSocialites, 'app'))) {
            throw new ServiceException(__('您已经绑定了该渠道的账号'));
        }

        $user = Socialite::driver($app)->user();
        $appId = $user->getId();

        // 读取当前社交账号绑定的用户id
        $userId = $socialiteService->getBindUserId($app, $appId);
        if ($userId) {
            throw new ServiceException(__('当前渠道账号已绑定了其它账号'));
        }

        // 绑定操作
        $socialiteService->bindApp($this->id(), $app, $appId, (array)$user);

        flash(__('success'), 'success');

        return redirect(route('member'));
    }

    // 社交登录[取消绑定]
    public function cancelBindSocialite(SocialiteServiceInterface $socialiteService, $app)
    {
        $socialiteService->cancelBind($app, $this->id());

        flash(__('success'), 'success');

        return back();
    }

    // 我的邀请码[界面]
    public function showPromoCodePage(
        PromoCodeServiceInterface $promoCodeService,
        UserInviteBalanceServiceInterface $inviteBalanceService,
        Request $request
    ) {
        /**
         * @var PromoCodeService $promoCodeService
         */
        /**
         * @var UserInviteBalanceService $inviteBalanceService
         */

        $scene = $request->input('scene');
        $page = abs((int)$request->input('page', 1));
        $pageSize = 10;

        // 当前用户邀请码
        $userPromoCode = $promoCodeService->userPromoCode();

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
            ] = $inviteBalanceService->simplePaginate($page, $pageSize);
            $balanceRecords = $this->paginator($list, $total, $page, $pageSize);
            $balanceRecords->appends($request->all());
        } elseif ($scene === 'withdraw') {
            // 提现记录
            [
                'list' => $list,
                'total' => $total,
            ] = $inviteBalanceService->currentUserOrderPaginate($page, $pageSize);
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

    // 生成我的邀请码
    public function generatePromoCode(PromoCodeServiceInterface $promoCodeService)
    {
        /**
         * @var PromoCodeService $promoCodeService
         */

        if (!$this->businessState->canGenerateInviteCode($this->user())) {
            flash(__('current user cant generate promo code'));
            return back();
        }

        $promoCodeService->userCreate($this->user());

        flash(__('success'), 'success');
        return redirect(route('member.promo_code'));
    }

    public function createInviteBalanceWithdrawOrder(
        InviteBalanceWithdrawRequest $request,
        UserInviteBalanceServiceInterface $inviteBalanceService
    ) {
        /**
         * @var UserInviteBalanceService $inviteBalanceService
         */

        $total = $request->post('total');
        if ($this->user()['invite_balance'] < $total) {
            flash(__('Insufficient invite balance'));
            return back();
        }
        $data = $request->filldata();
        $inviteBalanceService->createCurrentUserWithdraw($data['total'], $data['channel']);
        flash(__('success'), 'success');
        return back();
    }

    // 积分记录
    public function credit1Records(Request $request, CreditServiceInterface $creditService)
    {
        /**
         * @var CreditService $creditService
         */
        $page = $request->input('page', 1);
        $pageSize = 10;
        $records = $creditService->getCredit1RecordsPaginate($this->id(), $page, $pageSize);
        $total = $creditService->getCredit1RecordsCount($this->id());
        $records = $this->paginator($records, $total, $page, $pageSize);

        $title = __('title.member.credit1_records');
        return v('frontend.member.credit1_records', compact('title', 'records'));
    }

    // 我的资料
    public function showProfilePage()
    {
        $profile = $this->userService->getProfile($this->id());

        $title = __('member.profile.edit');

        return v('frontend.member.profile', compact('profile', 'title'));
    }

    // 安全退出
    public function logout()
    {
        Auth::logout();
        flash(__('success'), 'success');
        return redirect(url('/'));
    }
}
