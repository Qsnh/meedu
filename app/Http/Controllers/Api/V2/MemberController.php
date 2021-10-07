<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Api\V2;

use Carbon\Carbon;
use App\Meedu\Verify;
use App\Bus\WechatBindBus;
use Illuminate\Http\Request;
use App\Constant\ApiV2Constant;
use App\Businesses\BusinessState;
use App\Constant\FrontendConstant;
use App\Exceptions\ServiceException;
use Laravel\Socialite\Facades\Socialite;
use App\Services\Base\Services\ConfigService;
use App\Services\Member\Services\RoleService;
use App\Services\Member\Services\UserService;
use App\Services\Order\Services\OrderService;
use App\Services\Course\Services\VideoService;
use App\Services\Course\Services\CourseService;
use App\Services\Member\Services\CreditService;
use App\Http\Requests\ApiV2\AvatarChangeRequest;
use App\Http\Requests\ApiV2\MobileChangeRequest;
use App\Services\Order\Services\PromoCodeService;
use App\Http\Requests\ApiV2\NicknameChangeRequest;
use App\Http\Requests\ApiV2\PasswordChangeRequest;
use App\Services\Member\Services\SocialiteService;
use App\Services\Base\Interfaces\ConfigServiceInterface;
use App\Services\Member\Interfaces\RoleServiceInterface;
use App\Services\Member\Interfaces\UserServiceInterface;
use App\Services\Order\Interfaces\OrderServiceInterface;
use App\Http\Requests\ApiV2\InviteBalanceWithdrawRequest;
use App\Services\Course\Interfaces\VideoServiceInterface;
use App\Services\Course\Interfaces\CourseServiceInterface;
use App\Services\Member\Interfaces\CreditServiceInterface;
use App\Services\Member\Services\UserInviteBalanceService;
use App\Services\Order\Interfaces\PromoCodeServiceInterface;
use App\Services\Member\Interfaces\SocialiteServiceInterface;
use App\Services\Member\Interfaces\UserInviteBalanceServiceInterface;

class MemberController extends BaseController
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

    protected $businessState;
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
        BusinessState $businessState,
        ConfigServiceInterface $configService
    ) {
        $this->userService = $userService;
        $this->courseService = $courseService;
        $this->videoService = $videoService;
        $this->roleService = $roleService;
        $this->orderService = $orderService;
        $this->socialiteService = $socialiteService;
        $this->businessState = $businessState;
        $this->configService = $configService;
    }

    /**
     * @api {get} /api/v2/member/detail 用户详情
     * @apiGroup 用户
     * @apiVersion v2.0.0
     * @apiHeader Authorization Bearer+token
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     * @apiSuccess {Number} data.id 用户ID
     * @apiSuccess {String} data.avatar 头像
     * @apiSuccess {String} data.nick_name 头像
     * @apiSuccess {String} data.mobile 手机号
     * @apiSuccess {Number} data.is_lock 锁定[1:是,0否]
     * @apiSuccess {Number} data.is_active 激活[1:是,0否][暂无用]
     * @apiSuccess {Number} data.is_password_set 设置密码[1:是,0否]
     * @apiSuccess {Number} data.is_set_nickname 设置昵称[1:是,0否]
     * @apiSuccess {Number} data.credit1 积分
     * @apiSuccess {Number} data.credit2 预留
     * @apiSuccess {Number} data.credit3 预留
     * @apiSuccess {Number} data.role_id VIP会员ID
     * @apiSuccess {String} data.role_expired_at VIP过期时间
     * @apiSuccess {Number} data.invite_balance 邀请余额
     * @apiSuccess {Object} data.role VIP会员[可选]
     * @apiSuccess {Number} data.role.id ID
     * @apiSuccess {String} data.role.name VIP名
     * @apiSuccess {Number} data.is_bind_qq 是否绑定QQ[1:是,0:否]
     * @apiSuccess {Number} data.is_bind_wechat 是否绑定微信[1:是,0:否]
     * @apiSuccess {Number} data.is_bind_mobile 是否绑定手机号[1:是,0:否]
     */
    public function detail(BusinessState $businessState, SocialiteServiceInterface $socialiteService)
    {
        /**
         * @var SocialiteService $socialiteService
         */
        $user = $this->userService->find($this->id(), ['role']);
        $user = arr1_clear($user, ApiV2Constant::MODEL_MEMBER_FIELD);

        $socialites = $socialiteService->userSocialites($this->id());
        $socialites = array_column($socialites, null, 'app');

        $user['is_bind_qq'] = isset($socialites[FrontendConstant::SOCIALITE_APP_QQ]) ? 1 : 0;
        $user['is_bind_wechat'] = isset($socialites[FrontendConstant::WECHAT_LOGIN_SIGN]) ? 1 : 0;
        $user['is_bind_mobile'] = $businessState->isNeedBindMobile($user) ? 0 : 1;

        return $this->data($user);
    }

    /**
     * @api {post} /api/v2/member/detail/password 修改密码
     * @apiGroup 用户
     * @apiVersion v2.0.0
     * @apiHeader Authorization Bearer+token
     *
     * @apiParam {String} mobile 手机号
     * @apiParam {String} mobile_code 短信验证码
     * @apiParam {String} password 新密码
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     */
    public function passwordChange(PasswordChangeRequest $request)
    {
        $this->mobileCodeCheck();
        ['password' => $password, 'mobile' => $mobile] = $request->filldata();
        $user = $this->userService->find($this->id());
        if ($user['mobile'] != $mobile) {
            return $this->error(__('短信验证码错误'));
        }
        $this->userService->changePassword($this->id(), $password);

        return $this->success();
    }

    /**
     * @api {post} /api/v2/member/detail/mobile 手机号绑定
     * @apiGroup 用户
     * @apiVersion v2.0.0
     * @apiHeader Authorization Bearer+token
     *
     * @apiParam {String} mobile 手机号
     * @apiParam {String} mobile_code 短信验证码
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     */
    public function mobileBind(MobileChangeRequest $request, BusinessState $businessState)
    {
        $this->mobileCodeCheck();

        if (!$businessState->isNeedBindMobile($this->user())) {
            return $this->error(__('已绑定'));
        }

        ['mobile' => $mobile] = $request->filldata();
        $this->userService->changeMobile($this->id(), $mobile);

        return $this->success();
    }

    /**
     * @api {put} /api/v2/member/mobile 手机号更换
     * @apiGroup 用户
     * @apiVersion v2.0.0
     * @apiHeader Authorization Bearer+token
     *
     * @apiParam {String} mobile 手机号
     * @apiParam {String} mobile_code 短信验证码
     * @apiParam {String} sign 校验字符串
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     */
    public function mobileChange(MobileChangeRequest $request, Verify $verify)
    {
        $sign = $request->input('sign');
        if (!$sign || $verify->check($sign) === false) {
            return $this->error(__('参数错误'));
        }

        $this->mobileCodeCheck();

        ['mobile' => $mobile] = $request->filldata();
        $this->userService->changeMobile($this->id(), $mobile);

        return $this->success();
    }

    /**
     * @api {post} /api/v2/member/detail/nickname 修改昵称
     * @apiGroup 用户
     * @apiVersion v2.0.0
     * @apiHeader Authorization Bearer+token
     *
     * @apiParam {String} nick_name 新昵称
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     */
    public function nicknameChange(NicknameChangeRequest $request)
    {
        ['nick_name' => $nickname] = $request->filldata();
        $this->userService->updateNickname($this->id(), $nickname);
        return $this->success();
    }

    /**
     * @api {post} /api/v2/member/detail/avatar 修改头像
     * @apiGroup 用户
     * @apiVersion v2.0.0
     * @apiHeader Authorization Bearer+token
     *
     * @apiParam {File} file 头像文件
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     */
    public function avatarChange(AvatarChangeRequest $request)
    {
        ['url' => $url] = $request->filldata();
        $this->userService->updateAvatar($this->id(), $url);

        return $this->success();
    }

    /**
     * @api {get} /api/v2/member/roles VIP订购记录
     * @apiGroup 用户
     * @apiVersion v2.0.0
     * @apiHeader Authorization Bearer+token
     *
     * @apiParam {Number} [page] page
     * @apiParam {Number} [page_size] size
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object[]} data
     * @apiSuccess {Number} data.id 记录ID
     * @apiSuccess {Number} data.user_id 用户ID
     * @apiSuccess {Number} data.role_Id VIPid
     * @apiSuccess {Number} data.charge 订购价格
     * @apiSuccess {String} data.started_at 开始时间
     * @apiSuccess {String} data.expired_at 结束时间
     * @apiSuccess {Object} data.role
     * @apiSuccess {Number} data.role.name VIP名
     */
    public function roles(Request $request)
    {
        $page = $request->input('page', 1);
        $pageSize = $request->input('page_size', 5);
        [
            'total' => $total,
            'list' => $list,
        ] = $this->roleService->userRolePaginate($page, $pageSize);
        $records = $this->paginator($list, $total, $page, $pageSize);

        return $this->data($records);
    }

    /**
     * @api {get} /api/v2/member/messages 站内消息
     * @apiGroup 用户
     * @apiVersion v2.0.0
     * @apiHeader Authorization Bearer+token
     *
     * @apiParam {Number} [page] page
     * @apiParam {Number} [page_size] size
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object[]} data
     * @apiSuccess {Number} data.id 记录ID
     * @apiSuccess {String} data.notifiable_id 特征值
     * @apiSuccess {String} data.data 消息内容
     * @apiSuccess {String} data.read_at 阅读时间
     * @apiSuccess {String} data.created_at 创建时间
     */
    public function messages(Request $request)
    {
        $page = $request->input('page', 1);
        $pageSize = $request->input('page_size', 5);
        [
            'total' => $total,
            'list' => $list,
        ] = $this->userService->messagePaginate($page, $pageSize);
        $list = arr2_clear($list, ApiV2Constant::MODEL_NOTIFICATON_FIELD);

        $list = array_map(function ($item) {
            $item['created_at'] = Carbon::parse($item['created_at'])->format('Y-m-d H:i');
            return $item;
        }, $list);

        return $this->data([
            'data' => $list,
            'total' => $total,
        ]);
    }

    /**
     * @api {get} /api/v2/member/courses 已购录播课程
     * @apiGroup 用户
     * @apiVersion v2.0.0
     * @apiHeader Authorization Bearer+token
     *
     * @apiParam {Number} [page] page
     * @apiParam {Number} [page_size] size
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data
     * @apiSuccess {Number} data.total 总数
     * @apiSuccess {Object[]} data.data
     * @apiSuccess {Number} data.data.id 课程ID
     * @apiSuccess {String} data.data.title 课程名
     * @apiSuccess {String} data.data.thumb 封面
     * @apiSuccess {Number} data.data.charge 价格
     * @apiSuccess {String} data.data.short_description 简短介绍
     * @apiSuccess {String} data.data.render_desc 详细介绍
     * @apiSuccess {String} data.data.seo_keywords SEO关键字
     * @apiSuccess {String} data.data.seo_description SEO描述
     * @apiSuccess {String} data.data.published_at 上架时间
     * @apiSuccess {Number} data.data.is_rec 推荐[1:是,0否][已弃用]
     * @apiSuccess {Number} data.data.user_count 订阅人数
     * @apiSuccess {Number} data.data.videos_count 视频数
     * @apiSuccess {Object} data.data.category 分类
     * @apiSuccess {Number} data.data.category.id 分类ID
     * @apiSuccess {String} data.data.category.name 分类名
     */
    public function courses(Request $request)
    {
        $page = $request->input('page', 1);
        $pageSize = $request->input('page_size', 5);

        [
            'total' => $total,
            'list' => $list,
        ] = $this->userService->getUserBuyCourses($page, $pageSize);
        $records = $this->paginator($list, $total, $page, $pageSize);
        // 读取关联课程
        $courses = $this->courseService->getList(array_column($list, 'course_id'));
        $courses = arr2_clear($courses, ApiV2Constant::MODEL_COURSE_FIELD);

        return $this->data([
            'current_page' => $records->currentPage(),
            'total' => $records->total(),
            'data' => $courses,
        ]);
    }

    /**
     * @api {get} /api/v2/member/courses/like 已收藏录播课程
     * @apiGroup 用户
     * @apiVersion v2.0.0
     * @apiHeader Authorization Bearer+token
     *
     * @apiParam {Number} [page] page
     * @apiParam {Number} [page_size] size
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data
     * @apiSuccess {Number} data.total 总数
     * @apiSuccess {Object[]} data.data
     * @apiSuccess {Number} data.data.id 课程ID
     * @apiSuccess {String} data.data.title 课程名
     * @apiSuccess {String} data.data.thumb 封面
     * @apiSuccess {Number} data.data.charge 价格
     * @apiSuccess {String} data.data.short_description 简短介绍
     * @apiSuccess {String} data.data.render_desc 详细介绍
     * @apiSuccess {String} data.data.seo_keywords SEO关键字
     * @apiSuccess {String} data.data.seo_description SEO描述
     * @apiSuccess {String} data.data.published_at 上架时间
     * @apiSuccess {Number} data.data.is_rec 推荐[1:是,0否][已弃用]
     * @apiSuccess {Number} data.data.user_count 订阅人数
     * @apiSuccess {Number} data.data.videos_count 视频数
     * @apiSuccess {Object} data.data.category 分类
     * @apiSuccess {Number} data.data.category.id 分类ID
     * @apiSuccess {String} data.data.category.name 分类名
     */
    public function likeCourses(Request $request)
    {
        $page = $request->input('page', 1);
        $pageSize = $request->input('page_size', 5);

        [
            'total' => $total,
            'list' => $list,
        ] = $this->userService->userLikeCoursesPaginate($this->id(), $page, $pageSize);
        $records = $this->paginator($list, $total, $page, $pageSize);
        // 读取关联课程
        $courses = $this->courseService->getList(array_column($list, 'course_id'));
        $courses = arr2_clear($courses, ApiV2Constant::MODEL_COURSE_FIELD);

        return $this->data([
            'current_page' => $records->currentPage(),
            'total' => $records->total(),
            'data' => $courses,
        ]);
    }

    /**
     * @api {get} /api/v2/member/courses/history 已学习录播课程
     * @apiGroup 用户
     * @apiVersion v2.0.0
     * @apiHeader Authorization Bearer+token
     *
     * @apiParam {Number} [page] page
     * @apiParam {Number} [page_size] size
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data
     * @apiSuccess {Number} data.total 总数
     * @apiSuccess {Object[]} data.data
     * @apiSuccess {Number} data.data.id 课程ID
     * @apiSuccess {String} data.data.title 课程名
     * @apiSuccess {String} data.data.thumb 封面
     * @apiSuccess {Number} data.data.charge 价格
     * @apiSuccess {String} data.data.short_description 简短介绍
     * @apiSuccess {String} data.data.render_desc 详细介绍
     * @apiSuccess {String} data.data.seo_keywords SEO关键字
     * @apiSuccess {String} data.data.seo_description SEO描述
     * @apiSuccess {String} data.data.published_at 上架时间
     * @apiSuccess {Number} data.data.is_rec 推荐[1:是,0否][已弃用]
     * @apiSuccess {Number} data.data.user_count 订阅人数
     * @apiSuccess {Number} data.data.videos_count 视频数
     * @apiSuccess {Object} data.data.category 分类
     * @apiSuccess {Number} data.data.category.id 分类ID
     * @apiSuccess {String} data.data.category.name 分类名
     */
    public function learnHistory(Request $request)
    {
        $page = $request->input('page', 1);
        $pageSize = $request->input('page_size', 5);

        [
            'total' => $total,
            'list' => $list,
        ] = $this->courseService->userLearningCoursesPaginate($this->id(), $page, $pageSize);
        $records = $this->paginator($list, $total, $page, $pageSize);
        // 读取关联课程
        $courses = $this->courseService->getList(array_column($list, 'course_id'));
        $courses = arr2_clear($courses, ApiV2Constant::MODEL_COURSE_FIELD);

        return $this->data([
            'current_page' => $records->currentPage(),
            'total' => $records->total(),
            'data' => $courses,
        ]);
    }

    /**
     * @api {get} /api/v2/member/videos 已购视频
     * @apiGroup 用户
     * @apiVersion v2.0.0
     * @apiHeader Authorization Bearer+token
     *
     * @apiParam {Number} [page] page
     * @apiParam {Number} [page_size] size
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data
     * @apiSuccess {Number} data.total 总数
     * @apiSuccess {Object[]} data.data
     * @apiSuccess {Number} data.data.id 视频ID
     * @apiSuccess {String} data.data.title 视频名
     * @apiSuccess {Number} data.data.charge 视频价格
     * @apiSuccess {Number} data.data.view_num 观看数[已废弃]
     * @apiSuccess {String} data.data.short_description 简短介绍
     * @apiSuccess {String} data.data.render_desc 详细介绍[已废弃]
     * @apiSuccess {String} data.data.published_at 上架时间
     * @apiSuccess {Number} data.data.duration 时长[单位：秒]
     * @apiSuccess {String} data.data.seo_keywords SEO关键字
     * @apiSuccess {String} data.data.seo_description SEO描述
     * @apiSuccess {Number} data.data.is_ban_sell 禁止出售[1:是,0否]
     * @apiSuccess {Number} data.data.chapter_id 章节ID
     */
    public function videos(Request $request)
    {
        $page = $request->input('page', 1);
        $pageSize = $request->input('page_size', 5);

        [
            'total' => $total,
            'list' => $list,
        ] = $this->userService->getUserBuyVideos($page, $pageSize);
        $records = $this->paginator($list, $total, $page, $pageSize);

        // 读取关联视频
        $videos = $this->videoService->getList(array_column($list, 'video_id'));
        $videos = arr2_clear($videos, ApiV2Constant::MODEL_VIDEO_FIELD);

        return $this->data([
            'current_page' => $records->currentPage(),
            'total' => $records->total(),
            'data' => $videos,
        ]);
    }

    /**
     * @api {get} /api/v2/member/orders 订单列表
     * @apiGroup 用户
     * @apiVersion v2.0.0
     * @apiHeader Authorization Bearer+token
     *
     * @apiParam {Number} [page] page
     * @apiParam {Number} [page_size] size
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data
     * @apiSuccess {Number} data.total 总数
     * @apiSuccess {Object[]} data.data
     * @apiSuccess {Number} data.data.id 订单ID
     * @apiSuccess {Number} data.data.user_id 用户ID
     * @apiSuccess {Number} data.data.charge 价格
     * @apiSuccess {String} data.data.order_id 订单编号
     * @apiSuccess {String} data.data.payment_method 支付渠道
     * @apiSuccess {String} data.data.payment_text 支付方法
     * @apiSuccess {String} data.data.status_text 状态
     * @apiSuccess {String} data.data.created_at 创建时间
     * @apiSuccess {Number} data.data.continue_pay 继续支付[1:是,0否][已废弃]
     * @apiSuccess {Object[]} data.data.goods 商品
     * @apiSuccess {Number} data.data.goods.id 商品ID
     * @apiSuccess {Number} data.data.goods.num 商品数量
     * @apiSuccess {String} data.data.goods.goods_text 商品名
     * @apiSuccess {Number} data.data.goods.charge 商品价格
     * @apiSuccess {String} data.data.goods.goods_type 商品类型
     */
    public function orders(Request $request)
    {
        $page = $request->input('page', 1);
        $pageSize = $request->input('page_size', 5);
        [
            'total' => $total,
            'list' => $list,
        ] = $this->orderService->userOrdersPaginate($page, $pageSize);
        $list = arr2_clear($list, ApiV2Constant::MODEL_ORDER_FIELD);
        foreach ($list as $key => $val) {
            $list[$key]['goods'] = arr2_clear($val['goods'], ApiV2Constant::MODEL_ORDER_GOODS_FIELD);
        }
        $orders = $this->paginator($list, $total, $page, $pageSize);

        return $this->data($orders);
    }

    /**
     * @api {get} /api/v2/member/inviteBalanceRecords 邀请余额明细
     * @apiGroup 用户
     * @apiVersion v2.0.0
     * @apiHeader Authorization Bearer+token
     *
     * @apiParam {Number} [page] page
     * @apiParam {Number} [page_size] size
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data
     * @apiSuccess {Number} data.total 总数
     * @apiSuccess {Object[]} data.data
     * @apiSuccess {Number} data.data.id 明细ID
     * @apiSuccess {Number} data.data.user_id 用户ID
     * @apiSuccess {Number} data.data.type 类型[0:支出,1:订单抽成奖励,2:提现,3:提现退还]
     * @apiSuccess {Number} data.data.total 变动金额
     * @apiSuccess {String} data.data.desc 变动描述
     */
    public function inviteBalanceRecords(Request $request, UserInviteBalanceServiceInterface $userInviteBalanceService)
    {
        /**
         * @var UserInviteBalanceService $userInviteBalanceService
         */

        $page = $request->input('page', 1);
        $pageSize = $request->input('page_size', 5);
        [
            'total' => $total,
            'list' => $list,
        ] = $userInviteBalanceService->simplePaginate($page, $pageSize);
        $records = $this->paginator($list, $total, $page, $pageSize);

        return $this->data($records);
    }

    /**
     * @api {get} /api/v2/member/promoCode 邀请码
     * @apiGroup 用户
     * @apiVersion v2.0.0
     * @apiHeader Authorization Bearer+token
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data
     * @apiSuccess {Number} data.per_order_draw 订单抽成
     * @apiSuccess {Number} data.invited_user_reward 被邀请用户奖励
     * @apiSuccess {Number} data.invite_user_reward 邀请奖励
     * @apiSuccess {String} data.code 邀请码
     * @apiSuccess {String} data.expired_at 过期时间
     */
    public function promoCode(PromoCodeServiceInterface $promoCodeService)
    {
        /**
         * @var PromoCodeService $promoCodeService
         */

        $promoCode = $promoCodeService->getUserPromoCode($this->id());
        if (!$promoCode && $this->businessState->canGenerateInviteCode($this->user())) {
            // 如果可以生成邀请码的话则直接创建邀请码
            $promoCodeService->userCreate($this->user());
            $promoCode = $promoCodeService->userPromoCode($this->id());
        }

        $promoCode = arr1_clear($promoCode, ApiV2Constant::MODEL_PROMO_CODE_FIELD);
        $promoCode['per_order_draw'] = $this->configService->getMemberInviteConfig()['per_order_draw'];

        return $this->data($promoCode);
    }

    /**
     * @api {get} /api/v2/member/notificationMarkAsRead/{notificationId} 消息标记已读
     * @apiGroup 用户
     * @apiVersion v2.0.0
     * @apiHeader Authorization Bearer+token
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data
     */
    public function notificationMarkAsRead($notificationId)
    {
        $this->userService->notificationMarkAsRead($this->id(), $notificationId);
        return $this->success();
    }

    /**
     * @api {get} /api/v2/member/unreadNotificationCount 未读消息数量
     * @apiGroup 用户
     * @apiVersion v2.0.0
     * @apiHeader Authorization Bearer+token
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Number} data 未读消息数量
     */
    public function unreadNotificationCount()
    {
        $count = $this->userService->unreadNotificationCount($this->id());
        return $this->data($count);
    }

    /**
     * @api {get} /api/v2/member/notificationMarkAllAsRead 消息全部标记已读
     * @apiGroup 用户
     * @apiVersion v2.0.0
     * @apiHeader Authorization Bearer+token
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data
     */
    public function notificationMarkAllAsRead()
    {
        $this->userService->notificationMarkAllAsRead($this->id());
        return $this->success();
    }

    /**
     * @api {get} /api/v2/member/inviteUsers 已邀请用户
     * @apiGroup 用户
     * @apiVersion v2.0.0
     * @apiHeader Authorization Bearer+token
     *
     * @apiParam {Number} [page] page
     * @apiParam {Number} [page_size] size
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data
     * @apiSuccess {Number} data.total 总数
     * @apiSuccess {Object[]} data.data
     * @apiSuccess {String} data.data.mobile 邀请用户手机号
     * @apiSuccess {String} data.data.created_at 邀请时间
     */
    public function inviteUsers(Request $request)
    {
        $page = $request->input('page', 1);
        $pageSize = $request->input('page_size', 10);

        [
            'list' => $list,
            'total' => $total,
        ] = $this->userService->inviteUsers($page, $pageSize);

        $list = array_map(function ($item) {
            $mobile = '******' . mb_substr($item['mobile'], 6);
            return [
                'mobile' => $mobile,
                'created_at' => Carbon::parse($item['created_at'])->format('Y - m - d'),
            ];
        }, $list);

        return $this->data([
            'total' => $total,
            'data' => $list,
        ]);
    }

    /**
     * @api {get} /api/v2/member/withdrawRecords 邀请余额提现记录
     * @apiGroup 用户
     * @apiVersion v2.0.0
     * @apiHeader Authorization Bearer+token
     *
     * @apiParam {Number} [page] page
     * @apiParam {Number} [page_size] size
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data
     * @apiSuccess {Number} data.total 总数
     * @apiSuccess {Object[]} data.data
     * @apiSuccess {Number} data.data.id 记录ID
     * @apiSuccess {Number} data.data.total 提现金额
     * @apiSuccess {Number} data.data.before_balance 提现前余额
     * @apiSuccess {Number} data.data.status 记录状态[0:已提交,1:成功,2:失败]
     * @apiSuccess {String} data.data.channel 打款渠道
     * @apiSuccess {String} data.data.channel_name 打款渠道-姓名
     * @apiSuccess {String} data.data.channel_account 打款渠道-账户
     * @apiSuccess {String} data.data.channel_address 打款渠道-地址
     * @apiSuccess {String} data.data.remark 打款渠道-备注
     * @apiSuccess {String} data.data.created_at 打款渠道-时间
     */
    public function withdrawRecords(Request $request, UserInviteBalanceServiceInterface $userInviteBalanceService)
    {
        /**
         * @var UserInviteBalanceService $userInviteBalanceService
         */

        $page = $request->input('page', 1);
        $pageSize = $request->input('page_size', 10);

        [
            'list' => $list,
            'total' => $total,
        ] = $userInviteBalanceService->currentUserOrderPaginate($page, $pageSize);

        return $this->data([
            'total' => $total,
            'data' => $list,
        ]);
    }

    /**
     * @api {post} /api/v2/member/withdraw 邀请余额提现
     * @apiGroup 用户
     * @apiVersion v2.0.0
     * @apiHeader Authorization Bearer+token
     *
     * @apiParam {String} channel 打款渠道
     * @apiParam {String} channel_name 打款渠道-姓名
     * @apiParam {String} channel_account 打款渠道-账户
     * @apiParam {String} [channel_address] 打款渠道-地址
     * @apiParam {Number} total 提现金额
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data
     * @apiSuccess {Number} data.total 总数
     * @apiSuccess {Object[]} data.data
     * @apiSuccess {Number} data.data.id 记录ID
     * @apiSuccess {Number} data.data.total 提现金额
     * @apiSuccess {Number} data.data.before_balance 提现前余额
     * @apiSuccess {Number} data.data.status 记录状态[0:已提交,1:成功,2:失败]
     * @apiSuccess {String} data.data.channel 打款渠道
     * @apiSuccess {String} data.data.channel_name 打款渠道-姓名
     * @apiSuccess {String} data.data.channel_account 打款渠道-账户
     * @apiSuccess {String} data.data.channel_address 打款渠道-地址
     * @apiSuccess {String} data.data.remark 打款渠道-备注
     * @apiSuccess {String} data.data.created_at 打款渠道-时间
     */
    public function createWithdraw(InviteBalanceWithdrawRequest $request, UserInviteBalanceServiceInterface $userInviteBalanceService)
    {
        /**
         * @var UserInviteBalanceService $userInviteBalanceService
         */
        $data = $request->filldata();
        $userInviteBalanceService->createCurrentUserWithdraw($data['total'], $data['channel']);
        return $this->success();
    }

    /**
     * @api {get} /api/v2/member/credit1Records 积分明细
     * @apiGroup 用户
     * @apiVersion v2.0.0
     * @apiHeader Authorization Bearer+token
     *
     * @apiParam {Number} [page] page
     * @apiParam {Number} [page_size] size
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data
     * @apiSuccess {Number} data.total 总数
     * @apiSuccess {Object[]} data.data
     * @apiSuccess {Number} data.data.id 记录ID
     * @apiSuccess {Number} data.data.sum 变动额度
     * @apiSuccess {String} data.data.remark 备注
     * @apiSuccess {String} data.data.created_at 时间
     */
    public function credit1Records(Request $request, CreditServiceInterface $creditService)
    {
        /**
         * @var CreditService $creditService
         */

        $page = $request->input('page', 1);
        $pageSize = $request->input('page_size', 10);

        $list = $creditService->getCredit1RecordsPaginate($this->id(), $page, $pageSize);
        $list = arr2_clear($list, ApiV2Constant::MODEL_CREDIT1_RECORD_FIELD);

        $total = $creditService->getCredit1RecordsCount($this->id());

        return $this->data([
            'total' => $total,
            'data' => $list,
        ]);
    }

    /**
     * @api {get} /api/v2/member/profile 我的资料
     * @apiGroup 用户
     * @apiVersion v2.0.0
     * @apiHeader Authorization Bearer+token
     *
     * @apiParam {Number} [page] page
     * @apiParam {Number} [page_size] size
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data
     * @apiSuccess {String} data.real_name 真实姓名
     * @apiSuccess {String} data.gender 性别[1:男,2:女,0:未公开]
     * @apiSuccess {String} data.age 年龄
     * @apiSuccess {String} data.birthday 生日
     * @apiSuccess {String} data.profession 职业
     * @apiSuccess {String} data.address 住址
     * @apiSuccess {String} data.graduated_school 毕业院校
     * @apiSuccess {String} data.diploma 毕业证照片
     * @apiSuccess {String} data.id_number 身份证号
     * @apiSuccess {String} data.id_frontend_thumb 身份证人像面
     * @apiSuccess {String} data.id_backend_thumb 身份证国徽面
     * @apiSuccess {String} data.id_hand_thumb 手持身份证照片
     */
    public function profile()
    {
        $profile = $this->userService->getProfile($this->id());
        $profile = arr1_clear($profile, ApiV2Constant::MODEL_MEMBER_PROFILE_FIELD);
        return $this->data($profile);
    }

    /**
     * @api {post} /api/v2/member/profile 资料编辑
     * @apiGroup 用户
     * @apiVersion v2.0.0
     * @apiHeader Authorization Bearer+token
     *
     * @apiParam {String} [real_name] 真实姓名
     * @apiParam {String} [gender] 性别[1:男,2:女,0:未公开]
     * @apiParam {String} [age] 年龄
     * @apiParam {String} [birthday] 生日
     * @apiParam {String} [profession] 职业
     * @apiParam {String} [address] 住址
     * @apiParam {String} [graduated_school] 毕业院校
     * @apiParam {String} [diploma] 毕业证照片
     * @apiParam {String} [id_number] 身份证号
     * @apiParam {String} [id_frontend_thumb] 身份证人像面
     * @apiParam {String} [id_backend_thumb] 身份证国徽面
     * @apiParam {String} [id_hand_thumb] 手持身份证照片
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data
     */
    public function profileUpdate(Request $request)
    {
        $data = $request->all();
        $this->userService->saveProfile($this->id(), $data);
        return $this->success();
    }

    /**
     * @api {post} /api/v2/member/verify 校验
     * @apiGroup 用户
     * @apiVersion v2.0.0
     * @apiHeader Authorization Bearer+token
     *
     * @apiParam {String} mobile 手机号
     * @apiParam {String} mobile_code 短信验证码
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data
     * @apiSuccess {String} data.sign 校验字符串
     */
    public function verify(Request $request, Verify $verify)
    {
        $this->mobileCodeCheck();
        $user = $this->user();
        if ($request->input('mobile') !== $user['mobile']) {
            return $this->error(__('参数错误'));
        }

        return $this->data(['sign' => $verify->gen()]);
    }

    /**
     * @api {get} /api/v2/member/wechatScan/bind 微信扫码绑定[二维码]
     * @apiGroup 用户
     * @apiVersion v2.0.0
     * @apiHeader Authorization Bearer+token
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     * @apiSuccess {String} data.code 随机值
     * @apiSuccess {String} data.image 图片内容
     */
    public function wechatScanBind(WechatBindBus $bus)
    {
        $data = $bus->qrcode($this->id());
        return $this->data([
            'code' => $data['code'],
            'image' => $data['image'],
        ]);
    }

    /**
     * @api {delete} /api/v2/member/socialite/{app} 社交登录解绑
     * @apiGroup 用户
     * @apiVersion v2.0.0
     * @apiHeader Authorization Bearer+token
     * @apiDescription app={qq:QQ登录,wechat:微信}
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     * @apiSuccess {String} data.code 随机值
     * @apiSuccess {String} data.image 图片内容
     */
    public function socialiteCancelBind(SocialiteServiceInterface $socialiteService, $app)
    {
        /**
         * @var SocialiteService $socialiteService
         */

        if (!$app || !in_array($app, [FrontendConstant::SOCIALITE_APP_QQ, FrontendConstant::WECHAT_LOGIN_SIGN])) {
            return $this->error(__('参数错误'));
        }
        $socialiteService->cancelBind($app, $this->id());
        return $this->success();
    }

    public function socialiteBindCallback(
        SocialiteServiceInterface $socialiteService,
        BusinessState $businessState,
        Request $request,
        $app
    ) {
        /**
         * @var SocialiteService $socialiteService
         */

        $data = $request->input('data');
        $redirectUrl = urldecode($request->input('redirect_url'));

        if (!$app || !$data || !$redirectUrl || !in_array($app, [FrontendConstant::SOCIALITE_APP_QQ])) {
            return $this->error(__('参数错误'));
        }

        $socialiteUser = Socialite::driver($app)->redirectUrl($request->fullUrl())->stateless()->user();
        $appId = $socialiteUser->getId();

        try {
            $data = decrypt($data);
            if ($data['expired_at'] < time()) {
                return redirect(url_append_query($redirectUrl, ['error' => __('已超时，请重新绑定')]));
            }
            $needBindUserId = (int)$data['user_id'];

            $businessState->socialiteBindCheck($needBindUserId, $app, $appId);

            $socialiteService->bindApp($needBindUserId, $app, $appId, (array)$socialiteUser);

            return redirect($redirectUrl);
        } catch (ServiceException $e) {
            return redirect(url_append_query($redirectUrl, ['error' => $e->getMessage()]));
        } catch (\Exception $e) {
            abort(500);
        }
    }

    /**
     * @api {get} /api/v2/member/socialite/{app} 社交账号绑定[302重定向]
     * @apiGroup 用户
     * @apiVersion v2.0.0
     * @apiDescription app={qq:QQ登录}
     *
     * @apiParam {String} redirect_url 绑定成功之后的跳转地址，需要urlEncode
     */
    public function socialiteBind(SocialiteServiceInterface $socialiteService, Request $request, $app)
    {
        /**
         * @var SocialiteService $socialiteService
         */

        $redirectUrl = urldecode($request->input('redirect_url'));

        if (!$app || !$redirectUrl || !in_array($app, [FrontendConstant::SOCIALITE_APP_QQ])) {
            return $this->error(__('参数错误'));
        }

        // 检查是否已经绑定渠道账号
        $bindApps = $socialiteService->userSocialites($this->id());
        $bindApps = array_column($bindApps, null, 'app');
        if (isset($bindApps[$app])) {
            return redirect(url_append_query($redirectUrl, ['error' => __('您已经绑定了该渠道的账号')]));
        }

        $callbackUrl = route('api.v2.socialite.bind.callback', [$app]);
        $redirectUrl = url_append_query($callbackUrl, [
            'data' => encrypt([
                // 有效期一个小时
                'expired_at' => time() + 3600,
                // 绑定的用户id
                'user_id' => $this->id(),
            ]),
            'redirect_url' => urlencode($redirectUrl),
        ]);

        return Socialite::driver($app)
            ->redirectUrl($redirectUrl)
            ->stateless()
            ->redirect();
    }
}
