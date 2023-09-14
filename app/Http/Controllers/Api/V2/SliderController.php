<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Api\V2;

use Illuminate\Http\Request;
use App\Constant\ApiV2Constant;
use App\Constant\FrontendConstant;
use App\Meedu\Cache\Impl\SliderCache;

class SliderController extends BaseController
{
    /**
     * @api {get} /api/v2/sliders 幻灯片
     * @apiGroup 其它
     * @apiName OtherSliders
     * @apiVersion v2.0.0
     *
     * @apiParam {String="PC"} [platform] 平台
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     * @apiSuccess {String} data.thumb 图片URL
     * @apiSuccess {String} data.url 链接
     * @apiSuccess {String} data.platform 平台
     * @apiSuccess {Number} data.sort 升序
     */
    public function all(Request $request, SliderCache $sliderCache)
    {
        $platform = $request->input('platform') ?: FrontendConstant::SLIDER_PLATFORM_APP;
        $platform = strtoupper($platform);
        $sliders = $sliderCache->get($platform);
        $sliders = arr2_clear($sliders, ApiV2Constant::MODEL_SLIDER_FIELD);
        return $this->data($sliders);
    }
}
