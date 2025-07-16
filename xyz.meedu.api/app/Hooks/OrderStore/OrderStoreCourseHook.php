<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Hooks\OrderStore;

use App\Constant\BusConstant;
use App\Meedu\Hooks\HookParams;
use App\Constant\AgreementConstant;
use App\Exceptions\ServiceException;
use App\Meedu\Hooks\HookRuntimeInterface;
use App\Meedu\Cache\Impl\ActiveAgreementCache;
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

        // 检查付费内容购买协议同意情况
        if (1 !== (int)request()->input('agree_protocol')) {
            throw new ServiceException(__('请同意付费内容购买协议'));
        }

        $params->setResponse([
            'id' => $goodsId,
            'type' => $goodsType,
            'name' => $course['title'],
            'charge' => $course['charge'],
            'ori_charge' => $course['charge'],
            'thumb' => $course['thumb'],
            'agreement_id' => ActiveAgreementCache::getActiveId(AgreementConstant::TYPE_PAID_CONTENT_PURCHASE_AGREEMENT),
        ]);

        return $closure($params);
    }
}
