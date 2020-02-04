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

use App\Constant\ApiV2Constant;
use App\Services\Base\Services\ConfigService;
use App\Services\Member\Services\RoleService;
use App\Services\Order\Services\OrderService;
use App\Services\Base\Interfaces\ConfigServiceInterface;
use App\Services\Member\Interfaces\RoleServiceInterface;
use App\Services\Order\Interfaces\OrderServiceInterface;

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
     *     tags={"role"},
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
        $roles = arr2_clear($roles, ApiV2Constant::MODEL_ROLE_FIELD);
        return $this->data($roles);
    }

    /**
     * @OA\Get(
     *     path="/role/{id}",
     *     @OA\Parameter(in="path",name="id",description="视频id",required=true,@OA\Schema(type="integer")),
     *     summary="套餐详情",
     *     tags={"role"},
     *     @OA\Response(
     *         description="",response=200,
     *         @OA\JsonContent(
     *             @OA\Property(property="code",type="integer",description="状态码"),
     *             @OA\Property(property="message",type="string",description="消息"),
     *             @OA\Property(property="data",type="object",description="",ref="#/components/schemas/Role"),
     *         )
     *     )
     * )
     * @return \Illuminate\Http\JsonResponse
     */
    public function detail($id)
    {
        $role = $this->roleService->find($id);
        $role = arr1_clear($role, ApiV2Constant::MODEL_ROLE_FIELD);
        return $this->data($role);
    }
}
