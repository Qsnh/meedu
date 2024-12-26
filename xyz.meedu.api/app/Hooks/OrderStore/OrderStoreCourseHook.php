<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Hooks\OrderStore;

use App\Constant\BusConstant;
use App\Meedu\Hooks\HookParams;
use App\Meedu\Hooks\HookRuntimeInterface;
use App\Meedu\ServiceV2\Services\CourseServiceInterface;

class OrderStoreCourseHook implements HookRuntimeInterface
{
    public function handle(HookParams $params, \Closure $closure)
    {
        $goodsType = $params->getValue('goods_type');
        $goodsId = $params->getValue('goods_id');
        if (BusConstant::ORDER_GOODS_TYPE_COURSE !== $goodsType) {
            return $closure($params);
        }

        /**
         * @var CourseServiceInterface $courseService
         */
        $courseService = app()->make(CourseServiceInterface::class);

        $course = $courseService->findOrFail($goodsId);

        $params->setResponse([
            'id' => $goodsId,
            'type' => $goodsType,
            'name' => $course['title'],
            'charge' => $course['charge'],
            'ori_charge' => $course['charge'],
            'thumb' => $course['thumb'],
        ]);

        return $closure($params);
    }


}
