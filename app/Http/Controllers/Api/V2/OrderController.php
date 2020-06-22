<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Controllers\Api\V2;

use Illuminate\Http\Request;
use App\Constant\ApiV2Constant;
use App\Services\Member\Services\RoleService;
use App\Services\Member\Services\UserService;
use App\Services\Order\Services\OrderService;
use App\Services\Course\Services\VideoService;
use App\Services\Course\Services\CourseService;
use App\Http\Requests\ApiV2\PasswordLoginRequest;
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
     * @OA\Post(
     *     path="/order/course",
     *     summary="创建课程订单",
     *     tags={"订单"},
     *     @OA\RequestBody(description="",@OA\JsonContent(
     *         @OA\Property(property="course_id",description="课程id",type="integer"),
     *         @OA\Property(property="promo_code",description="优惠码",type="string"),
     *     )),
     *     @OA\Response(
     *         description="",response=200,
     *         @OA\JsonContent(
     *             @OA\Property(property="code",type="integer",description="状态码"),
     *             @OA\Property(property="message",type="string",description="消息"),
     *             @OA\Property(property="data",type="object",description="",ref="#/components/schemas/Order"),
     *         )
     *     )
     * )
     *
     * @param PasswordLoginRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function createCourseOrder(Request $request)
    {
        $courseId = $request->input('course_id');
        $course = $this->courseService->find($courseId);
        if ($course['charge'] === 0) {
            return $this->error(__('course cant buy'));
        }
        if ($this->userService->hasCourse($this->id(), $course['id'])) {
            return $this->error(__('course purchased'));
        }
        $code = $request->input('promo_code');
        $promoCode = [];
        $code && $promoCode = $this->promoCodeService->findCode($code);
        $order = $this->orderService->createCourseOrder($this->id(), $course, $promoCode['id'] ?? 0);
        $order = arr1_clear($order, ApiV2Constant::MODEL_ORDER_FIELD);
        return $this->data($order);
    }

    /**
     * @OA\Post(
     *     path="/order/role",
     *     summary="创建套餐订单",
     *     tags={"订单"},
     *     @OA\RequestBody(description="",@OA\JsonContent(
     *         @OA\Property(property="role_id",description="套餐id",type="integer"),
     *         @OA\Property(property="promo_code",description="优惠码",type="string"),
     *     )),
     *     @OA\Response(
     *         description="",response=200,
     *         @OA\JsonContent(
     *             @OA\Property(property="code",type="integer",description="状态码"),
     *             @OA\Property(property="message",type="string",description="消息"),
     *             @OA\Property(property="data",type="object",description="",ref="#/components/schemas/Order"),
     *         )
     *     )
     * )
     *
     * @param PasswordLoginRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
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
     * @OA\Post(
     *     path="/order/video",
     *     summary="创建视频订单",
     *     tags={"订单"},
     *     @OA\RequestBody(description="",@OA\JsonContent(
     *         @OA\Property(property="video_id",description="视频id",type="integer"),
     *         @OA\Property(property="promo_code",description="优惠码",type="string"),
     *     )),
     *     @OA\Response(
     *         description="",response=200,
     *         @OA\JsonContent(
     *             @OA\Property(property="code",type="integer",description="状态码"),
     *             @OA\Property(property="message",type="string",description="消息"),
     *             @OA\Property(property="data",type="object",description="",ref="#/components/schemas/Order"),
     *         )
     *     )
     * )
     *
     * @param PasswordLoginRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function createVideoOrder(Request $request)
    {
        $videoId = $request->input('video_id');
        $video = $this->videoService->find($videoId);
        if ($video['is_ban_sell'] === ApiV2Constant::YES) {
            return $this->error(__('this video cannot be sold'));
        }
        if ($video['charge'] === 0) {
            return $this->error(__('video cant buy'));
        }
        if ($this->userService->hasVideo($this->id(), $video['id'])) {
            return $this->error(__('video purchased'));
        }
        $code = $request->input('promo_code');
        $promoCode = [];
        $code && $promoCode = $this->promoCodeService->findCode($code);
        $order = $this->orderService->createVideoOrder($this->id(), $video, $promoCode['id'] ?? 0);
        $order = arr1_clear($order, ApiV2Constant::MODEL_ORDER_FIELD);
        return $this->data($order);
    }
}
