<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Frontend;

use App\Bus\WechatBindBus;
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
use App\Services\Course\Interfaces\CourseServiceInterface;
use App\Services\Member\Interfaces\CreditServiceInterface;
use App\Services\Member\Services\UserInviteBalanceService;
use App\Services\Order\Interfaces\PromoCodeServiceInterface;
use App\Services\Member\Interfaces\SocialiteServiceInterface;
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

        $title = __('会员中心');

        $courseCount = $this->userService->getUserCourseCount($this->id());
        $videoCount = $this->userService->getUserVideoCount($this->id());

        // 社交登录账号
        $apps = $socialiteService->userSocialites($this->id());
        $apps = array_column($apps, null, 'app');

        // 邀请人数
        $inviteCount = $this->userService->inviteCount($this->id());

        return v('frontend.member.index', compact('title', 'courseCount', 'videoCount', 'apps', 'inviteCount'));
    }

    // 手机号绑定[界面]
    public function showMobileBindPage()
    {
        $title = __('绑定手机号');

        return v('frontend.member.mobile_bind', compact('title'));
    }

    // 手机号绑定[提交]
    public function mobileBindHandler(MobileBindRequest $request)
    {
        ['mobile' => $mobile] = $request->filldata();

        $this->userService->bindMobile($mobile, $this->id());

        flash(__('成功'), 'success');

        return redirect(route('member'));
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

        $title = __('VIP记录');

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

        $title = __('我的消息');

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
        $pageSize = 12;

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
        $records->appends([
            'scene' => $scene,
        ]);

        $title = __('点播课程');

        return v('frontend.member.vod_courses', compact('records', 'title', 'courses', 'scene'));
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

        // 本次查询出来的video
        $videos = $videoService->getList(array_column($list, 'video_id'));
        $videos = array_column($videos, null, 'id');

        $title = __('点播视频');

        return v('frontend.member.vod_videos', compact('videos', 'title', 'records'));
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

        $title = __('我的订单');

        return v('frontend.member.orders', compact('orders', 'title'));
    }

    // 社交登录[绑定操作]
    public function socialiteBind($app)
    {
        $redirectUrl = route('member.socialite.bind.callback', [$app]);
        return Socialite::driver($app)->redirectUrl($redirectUrl)->redirect();
    }

    // 社交登录[绑定回调]
    public function socialiteBindCallback(SocialiteServiceInterface $socialiteService, BusinessState $businessState, $app)
    {
        /**
         * @var SocialiteService $socialiteService
         */

        $redirectUrl = route('member.socialite.bind.callback', [$app]);
        $user = Socialite::driver($app)->redirectUrl($redirectUrl)->user();
        $appId = $user->getId();

        try {
            $businessState->socialiteBindCheck($this->id(), $app, $appId);

            $socialiteService->bindApp($this->id(), $app, $appId, (array)$user);

            flash(__('成功'), 'success');

            return redirect(route('member'));
        } catch (ServiceException $exception) {
            flash($exception->getMessage(), 'error');
            return redirect(route('member'));
        } catch (\Exception $e) {
            exception_record($e);
            abort(500);
        }
    }

    // 社交登录[取消绑定]
    public function cancelBindSocialite(SocialiteServiceInterface $socialiteService, $app)
    {
        $socialiteService->cancelBind($app, $this->id());

        flash(__('成功'), 'success');

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
        $userPromoCode = $promoCodeService->userPromoCode($this->id());
        if (!$userPromoCode && $this->businessState->canGenerateInviteCode($this->user())) {
            // 如果可以生成邀请码的话则直接创建邀请码
            $promoCodeService->userCreate($this->user());
            $userPromoCode = $promoCodeService->userPromoCode($this->id());
        }

        // 邀请人数
        $inviteCount = $this->userService->inviteCount($this->id());

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

        $inviteConfig = $this->configService->getMemberInviteConfig();

        $title = __('我的邀请码');

        return v('frontend.member.promo_code', compact(
            'userPromoCode',
            'title',
            'inviteUsers',
            'scene',
            'balanceRecords',
            'withdrawOrders',
            'inviteCount',
            'inviteConfig'
        ));
    }

    // 积分记录
    public function credit1Records(Request $request, CreditServiceInterface $creditService)
    {
        /**
         * @var CreditService $creditService
         */
        $page = $request->input('page', 1);
        $pageSize = 10;

        $list = $creditService->getCredit1RecordsPaginate($this->id(), $page, $pageSize);
        $total = $creditService->getCredit1RecordsCount($this->id());

        $records = $this->paginator($list, $total, $page, $pageSize);

        $title = __('我的积分');

        return v('frontend.member.credit1_records', compact('title', 'records'));
    }

    // 我的资料
    public function showProfilePage()
    {
        $profile = $this->userService->getProfile($this->id());

        $title = __('我的资料编辑');

        return v('frontend.member.profile', compact('profile', 'title'));
    }

    // 安全退出
    public function logout()
    {
        Auth::logout();
        flash(__('成功'), 'success');
        return redirect(url('/'));
    }

    public function showWechatBind(WechatBindBus $bus)
    {
        $title = __('微信账号绑定');

        // 生成登录二维码
        ['code' => $code, 'image' => $image] = $bus->qrcode($this->id());

        return v('frontend.member.wechat_bind', compact('title', 'code', 'image'));
    }
}
