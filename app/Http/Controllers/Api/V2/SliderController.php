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
use App\Services\Other\Services\SliderService;
use App\Services\Other\Interfaces\SliderServiceInterface;

class SliderController extends BaseController
{

    /**
     * @OA\Get(
     *     path="/sliders",
     *     summary="幻灯片",
     *     tags={"role"},
     *     @OA\Response(
     *         description="",response=200,
     *         @OA\JsonContent(
     *             @OA\Property(property="code",type="integer",description="状态码"),
     *             @OA\Property(property="message",type="string",description="消息"),
     *             @OA\Property(property="data",type="array",description="",@OA\Items(ref="#/components/schemas/Slider")),
     *         )
     *     )
     * )
     * @return \Illuminate\Http\JsonResponse
     */
    public function all(SliderServiceInterface $sliderService)
    {
        $sliders = $sliderService->all();
        $sliders = arr2_clear($sliders, ApiV2Constant::MODEL_SLIDER_FIELD);
        return $this->data($sliders);
    }
}
