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

use App\Services\Base\Services\ConfigService;
use App\Services\Member\Services\RoleService;
use App\Services\Order\Services\OrderService;
use App\Services\Base\Interfaces\ConfigServiceInterface;
use App\Services\Member\Interfaces\RoleServiceInterface;
use App\Services\Order\Interfaces\OrderServiceInterface;

/**
 * @OpenApi\Annotations\Schemas(
 *     @OA\Schema(
 *         schema="Role",
 *         type="object",
 *         title="会员套餐",
 *         @OA\Property(property="id",type="integer",description="套餐id"),
 *         @OA\Property(property="name",type="string",description="套餐名"),
 *         @OA\Property(property="charge",type="integer",description="套餐价格"),
 *         @OA\Property(property="expire_days",type="integer",description="套餐天数"),
 *         @OA\Property(property="description",type="string",description="套餐描述"),
 *     ),
 * )
 */

/**
 * Class RoleController
 * @package App\Http\Controllers\Api\V2
 */
class RoleController extends BaseController
{

    /**
     * @var RoleService
     */
    protected $roleService;
    /**
     * @var ConfigService
     */
    protected $configService;
    /**
     * @var OrderService
     */
    protected $orderService;

    public function __construct(
        RoleServiceInterface $roleService,
        ConfigServiceInterface $configService,
        OrderServiceInterface $orderService
    ) {
        $this->roleService = $roleService;
        $this->configService = $configService;
        $this->orderService = $orderService;
    }

    /**
     * @OA\Get(
     *     path="/roles",
     *     summary="套餐列表",
     *     @OA\Response(
     *         description="",response=200,
     *         @OA\JsonContent(
     *             @OA\Property(property="code",type="integer",description="状态码"),
     *             @OA\Property(property="message",type="string",description="消息"),
     *             @OA\Property(property="data",type="array",description="",@OA\Items(ref="#/components/schemas/Role")),
     *         )
     *     )
     * )
     * @return \Illuminate\Http\JsonResponse
     */
    public function roles()
    {
        $roles = $this->roleService->all();
        return $this->data($roles);
    }
}
