<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Api\V2;

use App\Meedu\Verify;
use Illuminate\Http\Request;
use App\Constant\ApiV2Constant;
use App\Businesses\BusinessState;
use App\Constant\FrontendConstant;
use App\Exceptions\ServiceException;
use Laravel\Socialite\Facades\Socialite;
use App\Events\UserNotificationReadEvent;
use App\Services\Member\Services\RoleService;
use App\Services\Member\Services\UserService;
use App\Services\Order\Services\OrderService;
use App\Services\Course\Services\VideoService;
use App\Services\Member\Services\CreditService;
use App\Http\Requests\ApiV2\AvatarChangeRequest;
use App\Http\Requests\ApiV2\MobileChangeRequest;
use App\Http\Requests\ApiV2\NicknameChangeRequest;
use App\Http\Requests\ApiV2\PasswordChangeRequest;
use App\Meedu\Cache\Impl\UserNotificationCountCache;
use App\Services\Base\Interfaces\ConfigServiceInterface;
use App\Services\Member\Interfaces\RoleServiceInterface;
use App\Services\Member\Interfaces\UserServiceInterface;
use App\Services\Order\Interfaces\OrderServiceInterface;
use App\Services\Course\Interfaces\VideoServiceInterface;
use App\Services\Course\Interfaces\CourseServiceInterface;
use App\Services\Member\Interfaces\CreditServiceInterface;
use App\Services\Member\Interfaces\SocialiteServiceInterface;

class MemberController extends BaseController
{
    /**
     * @var UserService
     */
    protected $userService;

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

    protected $businessState;

    protected $configService;

    public function __construct(
        UserServiceInterface   $userService,
        CourseServiceInterface $courseService,
        VideoServiceInterface  $videoService,
        RoleServiceInterface   $roleService,
        OrderServiceInterface  $orderService,
        BusinessState          $businessState,
        ConfigServiceInterface $configService
    ) {
        $this->userService = $userService;
        $this->courseService = $courseService;
        $this->videoService = $videoService;
        $this->roleService = $roleService;
        $this->orderService = $orderService;
        $this->businessState = $businessState;
        $this->configService = $configService;
    }

    /**
     * @api {get} /api/v2/member/detail [V2]学员-详情
     * @apiGroup 用户认证
     * @apiName MemberDetail
     * @apiHeader Authorization Bearer+空格+token
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
     * @apiSuccess {Number} data.invite_people_count 邀请人数
     * @apiSuccess {Boolean} data.is_face_verify 是否完成实名认证
     * @apiSuccess {Boolean} data.profile_real_name 真实姓名
     * @apiSuccess {Boolean} data.profile_id_number 身份证号
     */
    public function detail(BusinessState $businessState, SocialiteServiceInterface $socialiteService)
    {
        $user = $this->userService->find($this->id(), ['role:id,name', 'profile:user_id,real_name,id_number,is_verify']);
        $userProfile = $user['profile'] ?? [];
        // user信息返回字段过滤
        $user = arr1_clear($user, ApiV2Constant::MODEL_MEMBER_FIELD);

        $socialites = $socialiteService->userSocialites($this->id());
        $socialites = array_column($socialites, null, 'app');

        // 是否绑定QQ
        $user['is_bind_qq'] = isset($socialites[FrontendConstant::SOCIALITE_APP_QQ]) ? 1 : 0;
        // 是否绑定微信
        $user['is_bind_wechat'] = isset($socialites[FrontendConstant::WECHAT_LOGIN_SIGN]) ? 1 : 0;
        // 是否绑定手机号
        $user['is_bind_mobile'] = $businessState->isNeedBindMobile($user) ? 0 : 1;

        // 邀请人数
        $user['invite_people_count'] = $this->userService->inviteCount($this->id());

        // 是否实名认证
        $user['is_face_verify'] = false;
        $user['profile_real_name'] = '';
        $user['profile_id_number'] = '';
        if ($userProfile) {
            $user['is_face_verify'] = $userProfile['is_verify'] === 1;
            $user['profile_real_name'] = name_mask($userProfile['real_name']);
            $user['profile_id_number'] = id_mask($userProfile['id_number']);
        }

        return $this->data($user);
    }

    /**
     * @api {post} /api/v2/member/detail/password [V2]学员-密码-更改
     * @apiGroup 学员
     * @apiName MemberPasswordChange
     * @apiHeader Authorization Bearer+空格+token
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
        if ($user['mobile'] !== $mobile) {
            return $this->error(__('请绑定手机号'));
        }
        $this->userService->changePassword($this->id(), $password);

        return $this->success();
    }

    /**
     * @api {post} /api/v2/member/detail/mobile [V2]学员-手机号-绑定
     * @apiGroup 学员
     * @apiName MemberMobileBind
     * @apiVersion v2.0.0
     * @apiHeader Authorization Bearer+空格+token
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
     * @api {put} /api/v2/member/mobile [V2]学员-手机号-换绑
     * @apiGroup 学员
     * @apiName MemberMobileChange
     * @apiHeader Authorization Bearer+空格+token
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
     * @api {post} /api/v2/member/detail/nickname [V2]学员-昵称-更改
     * @apiGroup 学员
     * @apiName MemberNicknameChange
     * @apiHeader Authorization Bearer+空格+token
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
     * @api {post} /api/v2/member/detail/avatar [V2]学员-头像-更改
     * @apiGroup 学员
     * @apiName MemberAvatarChange
     * @apiHeader Authorization Bearer+空格+token
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
     * @api {get} /api/v2/member/roles [V2]学员-VIP-订购记录-列表
     * @apiGroup 学员
     * @apiName MemberRoles
     * @apiHeader Authorization Bearer+空格+token
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
     * @api {get} /api/v2/member/messages [V2]学员-站内消息-列表
     * @apiGroup 学员
     * @apiName MemberMessages
     * @apiHeader Authorization Bearer+空格+token
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

        return $this->data([
            'data' => $list,
            'total' => $total,
        ]);
    }

    /**
     * @api {get} /api/v2/member/courses [V2]学员-录播课-已购-列表
     * @apiGroup 学员
     * @apiName MemberCoursesV2
     * @apiHeader Authorization Bearer+空格+token
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
     * @apiSuccess {Number} data.data.user_count 购买人数
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
     * @api {get} /api/v2/member/courses/like [V2]学员-录播课-收藏-列表
     * @apiGroup 学员
     * @apiName MemberCoursesLikeV2
     * @apiHeader Authorization Bearer+空格+token
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
     * @apiSuccess {Number} data.data.user_count 购买人数
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
     * @api {get} /api/v2/member/courses/history [V2]学员-录播课-学习-列表
     * @apiGroup 学员
     * @apiName MemberCoursesHistory
     * @apiHeader Authorization Bearer+空格+token
     * @apiDescription 只要学习超过10s的都会返回，不管课程是否收费
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
     * @apiSuccess {Number} data.data.user_count 购买人数
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
     * @api {get} /api/v2/member/orders [V2]学员-订单-列表
     * @apiGroup 学员
     * @apiName MemberOrders
     * @apiHeader Authorization Bearer+空格+token
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
     * @apiSuccess {String} data.data.goods.goods_text 商品类型名
     * @apiSuccess {Number} data.data.goods.goods_charge 商品价格
     * @apiSuccess {String} data.data.goods.goods_type 商品类型
     * @apiSuccess {String} data.data.goods.goods_name 商品名
     * @apiSuccess {String} data.data.goods.goods_thumb 商品封面
     * @apiSuccess {String} data.data.goods.charge 总价
     * @apiSuccess {String} data.data.goods.goods_ori_charge 商品原价
     */
    public function orders(Request $request)
    {
        $page = (int)$request->input('page', 1);
        $pageSize = (int)$request->input('page_size', 10);

        [
            'total' => $total,
            'list' => $list,
        ] = $this->orderService->userOrdersPaginate($this->id(), $page, $pageSize);
        $list = arr2_clear($list, ApiV2Constant::MODEL_ORDER_FIELD);

        foreach ($list as $key => $val) {
            $list[$key]['goods'] = arr2_clear($val['goods'], ApiV2Constant::MODEL_ORDER_GOODS_FIELD);
        }
        $orders = $this->paginator($list, $total, $page, $pageSize);

        return $this->data($orders);
    }

    /**
     * @api {get} /api/v2/member/notificationMarkAsRead/{notificationId} [V2]学员-站内消息-标记已读-单条
     * @apiGroup 学员
     * @apiName MemberMessageMarkReadAction
     * @apiHeader Authorization Bearer+空格+token
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data
     */
    public function notificationMarkAsRead($notificationId)
    {
        $this->userService->notificationMarkAsRead($this->id(), $notificationId);
        event(new UserNotificationReadEvent($this->id()));
        return $this->success();
    }

    /**
     * @api {get} /api/v2/member/unreadNotificationCount [V2]学员-站内消息-未读数量
     * @apiGroup 学员
     * @apiName MemberUnreadMessageCount
     * @apiHeader Authorization Bearer+空格+token
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Number} data 未读消息数量
     */
    public function unreadNotificationCount(UserNotificationCountCache $cache)
    {
        $count = $cache->get($this->id());
        return $this->data($count);
    }

    /**
     * @api {get} /api/v2/member/notificationMarkAllAsRead [V2]学员-站内消息-标记已读-全部
     * @apiGroup 学员
     * @apiName MemberMarkAllMessages
     * @apiHeader Authorization Bearer+空格+token
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data
     */
    public function notificationMarkAllAsRead()
    {
        $this->userService->notificationMarkAllAsRead($this->id());
        event(new UserNotificationReadEvent($this->id()));
        return $this->success();
    }

    /**
     * @api {get} /api/v2/member/credit1Records [V2]学员-积分明细-列表
     * @apiGroup 学员
     * @apiName MemberCredit1Records
     * @apiHeader Authorization Bearer+空格+token
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
     * @api {post} /api/v2/member/verify [V3]学员-2FA校验
     * @apiGroup 用户认证
     * @apiName MemberVerify
     * @apiHeader Authorization Bearer+空格+token
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
     * @api {delete} /api/v2/member/socialite/{app} [V2]第三方账号-解绑
     * @apiGroup 用户认证
     * @apiName MemberSocialiteUnbind
     * @apiHeader Authorization Bearer+空格+token
     * @apiDescription app={qq:QQ登录,wechat:微信}
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     * @apiSuccess {String} data.code 随机值
     * @apiSuccess {String} data.image 图片内容
     */
    public function socialiteCancelBind(SocialiteServiceInterface $socialiteService, $app)
    {
        if (!$app || !in_array($app, [FrontendConstant::SOCIALITE_APP_QQ, FrontendConstant::WECHAT_LOGIN_SIGN])) {
            return $this->error(__('参数错误'));
        }

        $socialiteService->cancelBind($app, $this->id());

        return $this->success();
    }

    public function socialiteBindCallback(
        SocialiteServiceInterface $socialiteService,
        BusinessState             $businessState,
        Request                   $request,
        $app
    ) {
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
     * @api {get} /api/v2/member/socialite/qq [V2]第三方账号-QQ账号-绑定
     * @apiGroup 用户认证
     * @apiName MemberSocialiteBind
     *
     * @apiParam {String} token 登录token
     * @apiParam {String} redirect_url 绑定成功之后的跳转地址，需要urlEncode
     */
    public function socialiteBind(SocialiteServiceInterface $socialiteService, Request $request, $app)
    {
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
