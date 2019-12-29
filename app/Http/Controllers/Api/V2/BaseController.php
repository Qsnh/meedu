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
use App\Exceptions\ApiV2Exception;
use Illuminate\Support\Facades\Auth;
use App\Services\Base\Services\CacheService;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Controllers\Api\V2\Traits\ResponseTrait;
use App\Services\Base\Interfaces\CacheServiceInterface;

/**
 * @OpenApi\Annotations\Swagger(
 *     @OA\Info(
 *         title="MeEdu API V2",
 *         version="2.0"
 *     )
 * )
 * @OA\SecurityScheme(
 *     securityScheme="https",
 *     type="http",
 *     scheme="Bearer",
 *     description="Authorization Bearer token",
 * )
 *
 * Class BaseController
 */
class BaseController
{
    use ResponseTrait;

    protected $guard = 'apiv2';

    /**
     * @OA\Get(
     *     path="/captcha/image",
     *     summary="图形验证码",
     *     @OA\Response(
     *         description="",response=200,
     *     )
     * )
     *
     * @throws ApiV2Exception
     */
    protected function checkImageCaptcha()
    {
        $imageKey = request()->input('image_key');
        if (!$imageKey) {
            throw new ApiV2Exception(__(ApiV2Constant::PLEASE_INPUT_IMAGE_CAPTCHA));
        }
        $imageCaptcha = request()->input('image_captcha', '');
        if (!captcha_api_check($imageCaptcha, $imageKey)) {
            throw new ApiV2Exception(__(ApiV2Constant::IMAGE_CAPTCHA_ERROR));
        }
    }

    /**
     * @return mixed
     */
    protected function id()
    {
        return Auth::guard($this->guard)->id();
    }

    /**
     * @param $list
     * @param $total
     * @param $page
     * @param $pageSize
     *
     * @return LengthAwarePaginator
     */
    protected function paginator($list, $total, $page, $pageSize)
    {
        return new LengthAwarePaginator($list, $total, $pageSize, $page, ['path' => request()->path()]);
    }

    /**
     * @throws ApiV2Exception
     */
    protected function mobileCodeCheck()
    {
        $mobile = request()->input('mobile');
        $mobileCode = request()->input('mobile_code');
        if (!$mobileCode) {
            throw new ApiV2Exception(__(ApiV2Constant::MOBILE_OR_PASSWORD_ERROR));
        }
        /**
         * @var $cacheService CacheService
         */
        $cacheService = app()->make(CacheServiceInterface::class);
        $key = sprintf(ApiV2Constant::MOBILE_CODE_CACHE_KEY, $mobile);
        $code = $cacheService->pull($key, null);
        // 取出来只有就删除，防止恶意碰撞攻击
        $code && $cacheService->forget($key);
        if ($code != $mobileCode) {
            throw new ApiV2Exception(__(ApiV2Constant::MOBILE_OR_PASSWORD_ERROR));
        }
    }
}
