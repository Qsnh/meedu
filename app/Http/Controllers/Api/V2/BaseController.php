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
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Controllers\Api\V2\Traits\ResponseTrait;

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
        if (! $imageKey) {
            throw new ApiV2Exception(__(ApiV2Constant::PLEASE_INPUT_IMAGE_CAPTCHA));
        }
        $imageCaptcha = request()->input('image_captcha', '');
        if (! captcha_api_check($imageCaptcha, $imageKey)) {
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
}
