<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Api\V2;

use Illuminate\Http\Request;
use App\Constant\ApiV2Constant;
use App\Services\Member\Services\RoleService;
use App\Services\Member\Services\UserService;
use App\Services\Order\Services\OrderService;
use App\Services\Course\Services\VideoService;
use App\Services\Course\Services\CourseService;
use App\Services\Order\Services\PromoCodeService;
use App\Services\Member\Interfaces\RoleServiceInterface;
use App\Services\Order\Interfaces\OrderServiceInterface;
use App\Services\Course\Interfaces\VideoServiceInterface;
use App\Services\Course\Interfaces\CourseServiceInterface;
use App\Services\Order\Interfaces\PromoCodeServiceInterface;

class OrderController extends BaseController
{

    /**
     * @var CourseService
     */
    protected $courseService;

    /**
     * @var OrderService
     */
    protected $orderService;

    /**
     * @var RoleService
     */
    protected $roleService;

    /**
     * @var VideoService
     */
    protected $videoService;
    /**
     * @var PromoCodeService
     */
    protected $promoCodeService;

    /**
     * @var UserService
     */
    protected $userService;

    public function __construct(
        CourseServiceInterface $courseService,
        OrderServiceInterface $orderService,
        RoleServiceInterface $roleService,
        VideoServiceInterface $videoService,
        PromoCodeServiceInterface $promoCodeService,
        UserService $userService
    ) {
        $this->courseService = $courseService;
        $this->orderService = $orderService;
        $this->roleService = $roleService;
        $this->videoService = $videoService;
        $this->promoCodeService = $promoCodeService;
        $this->userService = $userService;
    }

    /**
     * @api {post} /api/v2/order/course 创建录播课程订单
     * @apiGroup 订单
     * @apiVersion v2.0.0
     * @apiHeader Authorization Bearer+token
     *
     * @apiParam {Number} course_id 录播课程ID
     * @apiParam {String} [promo_code] 优惠码/邀请码
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data
     * @apiSuccess {Number} data.id 订单ID
     * @apiSuccess {Number} data.user_id 用户ID
     * @apiSuccess {Number} data.charge 价格
     * @apiSuccess {String} data.order_id 订单编号
     * @apiSuccess {String} data.payment_method 支付渠道
     * @apiSuccess {String} data.payment_text 支付方法
     * @apiSuccess {String} data.status_text 状态
     * @apiSuccess {Number} data.continue_pay 继续支付[已废弃]
     * @apiSuccess {Object} data.goods
     * @apiSuccess {Number} data.goods.id 记录ID
     * @apiSuccess {String} data.goods.goods_text 商品名
     * @apiSuccess {String} data.goods.goods_type 商品类型
     * @apiSuccess {Number} data.goods.num 数量
     * @apiSuccess {Number} data.goods.charge 价格
     * @apiSuccess {String} data.created_at 时间
     */
    public function createCourseOrder(Request $request)
    {
        $courseId = $request->input('course_id');
        $course = $this->courseService->find($courseId);
        if ($course['charge'] === 0) {
            return $this->error(__('当前课程无法购买'));
        }
        if ($this->userService->hasCourse($this->id(), $course['id'])) {
            return $this->error(__('请勿重复购买'));
        }
        $code = $request->input('promo_code');
        $promoCode = [];
        $code && $promoCode = $this->promoCodeService->findCode($code);
        $order = $this->orderService->createCourseOrder($this->id(), $course, $promoCode['id'] ?? 0);
        $order = arr1_clear($order, ApiV2Constant::MODEL_ORDER_FIELD);
        return $this->data($order);
    }

    /**
     * @api {post} /api/v2/order/role 创建VIP订单
     * @apiGroup 订单
     * @apiVersion v2.0.0
     * @apiHeader Authorization Bearer+token
     *
     * @apiParam {Number} role_id VIPid
     * @apiParam {String} [promo_code] 优惠码/邀请码
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data
     * @apiSuccess {Number} data.id 订单ID
     * @apiSuccess {Number} data.user_id 用户ID
     * @apiSuccess {Number} data.charge 价格
     * @apiSuccess {String} data.order_id 订单编号
     * @apiSuccess {String} data.payment_method 支付渠道
     * @apiSuccess {String} data.payment_text 支付方法
     * @apiSuccess {String} data.status_text 状态
     * @apiSuccess {Number} data.continue_pay 继续支付[已废弃]
     * @apiSuccess {Object} data.goods
     * @apiSuccess {Number} data.goods.id 记录ID
     * @apiSuccess {String} data.goods.goods_text 商品名
     * @apiSuccess {String} data.goods.goods_type 商品类型
     * @apiSuccess {Number} data.goods.num 数量
     * @apiSuccess {Number} data.goods.charge 价格
     * @apiSuccess {String} data.created_at 时间
     */
    public function createRoleOrder(Request $request)
    {
        $roleId = $request->input('role_id');
        $code = $request->input('promo_code');
        $promoCode = [];
        $code && $promoCode = $this->promoCodeService->findCode($code);
        $role = $this->roleService->find($roleId);
        $order = $this->orderService->createRoleOrder($this->id(), $role, $promoCode['id'] ?? 0);
        $order = arr1_clear($order, ApiV2Constant::MODEL_ORDER_FIELD);
        return $this->data($order);
    }

    /**
     * @api {post} /api/v2/order/video 创建视频订单
     * @apiGroup 订单
     * @apiVersion v2.0.0
     * @apiHeader Authorization Bearer+token
     *
     * @apiParam {Number} video_id videoID
     * @apiParam {String} [promo_code] 优惠码/邀请码
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data
     * @apiSuccess {Number} data.id 订单ID
     * @apiSuccess {Number} data.user_id 用户ID
     * @apiSuccess {Number} data.charge 价格
     * @apiSuccess {String} data.order_id 订单编号
     * @apiSuccess {String} data.payment_method 支付渠道
     * @apiSuccess {String} data.payment_text 支付方法
     * @apiSuccess {String} data.status_text 状态
     * @apiSuccess {Number} data.continue_pay 继续支付[已废弃]
     * @apiSuccess {Object} data.goods
     * @apiSuccess {Number} data.goods.id 记录ID
     * @apiSuccess {String} data.goods.goods_text 商品名
     * @apiSuccess {String} data.goods.goods_type 商品类型
     * @apiSuccess {Number} data.goods.num 数量
     * @apiSuccess {Number} data.goods.charge 价格
     * @apiSuccess {String} data.created_at 时间
     */
    public function createVideoOrder(Request $request)
    {
        $videoId = $request->input('video_id');
        $video = $this->videoService->find($videoId);
        if ((int)$video['is_ban_sell'] === 1) {
            return $this->error(__('当前视频无法购买'));
        }
        if ($video['charge'] === 0) {
            return $this->error(__('当前视频无法购买'));
        }
        if ($this->userService->hasVideo($this->id(), $video['id'])) {
            return $this->error(__('请勿重复购买'));
        }
        $code = $request->input('promo_code');
        $promoCode = [];
        $code && $promoCode = $this->promoCodeService->findCode($code);
        $order = $this->orderService->createVideoOrder($this->id(), $video, $promoCode['id'] ?? 0);
        $order = arr1_clear($order, ApiV2Constant::MODEL_ORDER_FIELD);
        return $this->data($order);
    }

    /**
     * @api {get} /api/v2/order/status 订单状态查询
     * @apiGroup 订单
     * @apiVersion v2.0.0
     * @apiHeader Authorization Bearer+token
     *
     * @apiParam {String} order_id 订单编号
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data
     * @apiSuccess {Number} data.status 订单状态[1:未支付,5:支付中,9:已支付,7:已取消]
     */
    public function queryStatus(Request $request)
    {
        $orderId = $request->input('order_id', '');
        $order = $this->orderService->findUser($orderId);

        return $this->data([
            'status' => $order['status'],
        ]);
    }
}
