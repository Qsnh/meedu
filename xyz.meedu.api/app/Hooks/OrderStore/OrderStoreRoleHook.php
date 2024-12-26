<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Hooks\OrderStore;

use App\Constant\BusConstant;
use App\Meedu\Hooks\HookParams;
use App\Exceptions\ServiceException;
use App\Meedu\Hooks\HookRuntimeInterface;
use App\Meedu\ServiceV2\Services\UserServiceInterface;

class OrderStoreRoleHook implements HookRuntimeInterface
{
    public function handle(HookParams $params, \Closure $closure)
    {

        $goodsType = $params->getValue('goods_type');
        $goodsId = $params->getValue('goods_id');
        if (BusConstant::ORDER_GOODS_TYPE_ROLE !== $goodsType) {
            return $closure($params);
        }

        /**
         * @var UserServiceInterface $userService
         */
        $userService = app()->make(UserServiceInterface::class);

        $role = $userService->findRoleOrFail($goodsId);

        if (1 !== (int)request()->input('agree_protocol')) {
            throw new ServiceException(__('请同意会员服务协议'));
        }

        $params->setResponse([
            'id' => $goodsId,
            'type' => $goodsType,
            'name' => $role['name'],
            'charge' => $role['charge'],
            'ori_charge' => $role['charge'],
            'thumb' => '',
        ]);

        return $closure($params);
    }


}
