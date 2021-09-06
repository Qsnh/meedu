<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Api\V2;

use App\Constant\ApiV2Constant;
use App\Services\Base\Services\ConfigService;
use App\Services\Member\Services\RoleService;
use App\Services\Order\Services\OrderService;
use App\Services\Base\Interfaces\ConfigServiceInterface;
use App\Services\Member\Interfaces\RoleServiceInterface;
use App\Services\Order\Interfaces\OrderServiceInterface;

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
     * @api {get} /api/v2/roles VIP会员列表
     * @apiGroup VIP
     * @apiVersion v2.0.0
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object[]} data 数据
     * @apiSuccess {Number} data.id VIPid
     * @apiSuccess {String} data.name VIP名
     * @apiSuccess {Number} data.charge 价格
     * @apiSuccess {Number} data.expire_days 有效天数
     * @apiSuccess {String[]} data.desc_rows 描述
     */
    public function roles()
    {
        $roles = $this->roleService->all();
        $roles = arr2_clear($roles, ApiV2Constant::MODEL_ROLE_FIELD);
        return $this->data($roles);
    }

    /**
     * @api {get} /api/v2/role/{id} VIP会员详情
     * @apiGroup VIP
     * @apiVersion v2.0.0
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     * @apiSuccess {Number} data.id VIPid
     * @apiSuccess {String} data.name VIP名
     * @apiSuccess {Number} data.charge 价格
     * @apiSuccess {Number} data.expire_days 有效天数
     * @apiSuccess {String[]} data.desc_rows 描述
     */
    public function detail($id)
    {
        $role = $this->roleService->find($id);
        $role = arr1_clear($role, ApiV2Constant::MODEL_ROLE_FIELD);
        return $this->data($role);
    }
}
