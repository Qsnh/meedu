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
     * @OA\Get(
     *     path="/promoCode/{code}",
     *     @OA\Parameter(in="path",name="code",description="code",required=true,@OA\Schema(type="string")),
     *     summary="优惠码详情",
     *     tags={"订单"},
     *     @OA\Response(
     *         description="",response=200,
     *         @OA\JsonContent(
     *             @OA\Property(property="code",type="integer",description="状态码"),
     *             @OA\Property(property="message",type="string",description="消息"),
     *             @OA\Property(property="data",type="object",description="",ref="#/components/schemas/PromoCode"),
     *         )
     *     )
     * )
     * @param $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function detail($code)
    {
        $code = $this->promoCodeService->findCode($code);
        $code = arr1_clear($code, ApiV2Constant::MODEL_PROMO_CODE_FIELD);
        return $this->data($code);
    }

    /**
     * @OA\Get(
     *     path="/promoCode/{code}/check",
     *     @OA\Parameter(in="path",name="code",description="code",required=true,@OA\Schema(type="string")),
     *     summary="优惠码检测",
     *     tags={"订单"},
     *     @OA\Response(
     *         description="",response=200,
     *         @OA\JsonContent(
     *             @OA\Property(property="code",type="integer",description="状态码"),
     *             @OA\Property(property="message",type="string",description="消息"),
     *             @OA\Property(property="data",type="object",description=""),
     *         )
     *     )
     * )
     *
     * @param $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkCode($code)
    {
        $code = $this->promoCodeService->findCode($code);
        if (!$code) {
            return $this->error(__('error'));
        }
        $result = $this->businessState->promoCodeCanUse($code);
        return $this->data([
            'can_use' => intval($result),
            'promo_code' => arr1_clear($code, ApiV2Constant::MODEL_PROMO_CODE_FIELD),
        ]);
    }
}
