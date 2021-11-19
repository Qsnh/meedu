<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Api\V2;

use App\Constant\ApiV2Constant;
use App\Businesses\BusinessState;
use App\Services\Order\Services\PromoCodeService;
use App\Services\Order\Interfaces\PromoCodeServiceInterface;

class PromoCodeController extends BaseController
{

    /**
     * @var PromoCodeService
     */
    protected $promoCodeService;
    protected $businessState;

    public function __construct(PromoCodeServiceInterface $promoCodeService, BusinessState $businessState)
    {
        $this->promoCodeService = $promoCodeService;
        $this->businessState = $businessState;
    }

    /**
     * @api {get} /api/v2/promoCode/{code} 优惠码详情
     * @apiGroup 订单
     * @apiVersion v2.0.0
     *
     * @apiParam {String} code 优惠码/邀请码
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     * @apiSuccess {Number} data.id
     * @apiSuccess {String} data.code 优惠码/邀请码
     * @apiSuccess {String} data.expired_at 过期时间
     * @apiSuccess {Number} data.invited_user_reward 被邀请用户奖励
     * @apiSuccess {Number} data.invite_user_reward 邀请用户奖励
     */
    public function detail($code)
    {
        $code = $this->promoCodeService->findCode($code);
        $code = arr1_clear($code, ApiV2Constant::MODEL_PROMO_CODE_FIELD);
        return $this->data($code);
    }

    /**
     * @api {get} /api/v2/promoCode/{code}/check 优惠码检测
     * @apiGroup 订单
     * @apiVersion v2.0.0
     *
     * @apiParam {String} code 优惠码/邀请码
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     * @apiSuccess {Number} data.can_use 是否可以使用[1:可以,0否]
     * @apiSuccess {Object} data.promo_code
     * @apiSuccess {Number} data.promo_code.id
     * @apiSuccess {String} data.promo_code.code 优惠码/邀请码
     * @apiSuccess {String} data.promo_code.expired_at 过期时间
     * @apiSuccess {Number} data.promo_code.invited_user_reward 被邀请用户奖励
     * @apiSuccess {Number} data.promo_code.invite_user_reward 邀请用户奖励
     */
    public function checkCode($code)
    {
        $code = $this->promoCodeService->findCode($code);
        $canUse = 0;
        $data = [];
        if ($code) {
            $canUse = (int)$this->businessState->promoCodeCanUse($this->id(), $code);
            $data = arr1_clear($code, ApiV2Constant::MODEL_PROMO_CODE_FIELD);
        }
        return $this->data([
            'can_use' => $canUse,
            'promo_code' => $data,
        ]);
    }
}
