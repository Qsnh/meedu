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

use Mews\Captcha\Captcha;
use App\Constant\ApiV2Constant;
use App\Constant\CacheConstant;
use App\Exceptions\ApiV2Exception;
use Illuminate\Support\Facades\Auth;
use App\Services\Base\Services\CacheService;
use App\Services\Member\Services\UserService;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Controllers\Api\V2\Traits\ResponseTrait;
use App\Services\Base\Interfaces\CacheServiceInterface;
use App\Services\Member\Interfaces\UserServiceInterface;

/**
 * @OpenApi\Annotations\Swagger(
 *     @OA\Info(
 *         title="MeEdu API V2",
 *         version="2.0"
 *     ),
 *     @OA\Server(
 *         url="http://127.0.0.1:8000/api/v2",
 *         description="local"
 *     )
 * )
 * @OA\SecurityScheme(
 *     securityScheme="BasicAuth",
 *     in="header",
 *     type="http",
 *     scheme="scheme",
 *     bearerFormat="bearer",
 *     name="bearer"
 * )
 * @OA\Tag(
 *     name="课程",
 *     description="课程相关接口",
 * ),
 * @OA\Tag(
 *     name="视频",
 *     description="视频相关接口",
 * ),
 * @OA\Tag(
 *     name="用户",
 *     description="用户相关接口",
 * ),
 * @OA\Tag(
 *     name="Auth",
 *     description="登录/注册相关接口",
 * ),
 * @OA\Tag(
 *     name="其它",
 *     description="其它接口",
 * ),
 */

/**
 * Class BaseController
 * @package App\Http\Controllers\Api\V2
 */
class BaseController
{
    use ResponseTrait;

    protected $guard = 'apiv2';

    protected $user;

    /**
     * 图形验证码校验
     * @throws ApiV2Exception
     */
    protected function checkImageCaptcha()
    {
        $imageKey = request()->input('image_key');
        if (!$imageKey) {
            throw new ApiV2Exception(__(ApiV2Constant::PLEASE_INPUT_IMAGE_CAPTCHA));
        }
        $imageCaptcha = request()->input('image_captcha', '');
        if (!app()->make(Captcha::class)->check_api($imageCaptcha, $imageKey)) {
            throw new ApiV2Exception(__(ApiV2Constant::IMAGE_CAPTCHA_ERROR));
        }
    }

    /**
     * 检测是否登录
     *
     * @return boolean
     */
    protected function check(): bool
    {
        return Auth::guard($this->guard)->check();
    }

    /**
     * @return mixed
     */
    protected function id()
    {
        return Auth::guard($this->guard)->id();
    }

    protected function user()
    {
        if (!$this->user) {
            /**
             * @var $userService UserService
             */
            $userService = app()->make(UserServiceInterface::class);
            $this->user = $userService->find($this->id(), ['role']);
        }
        return $this->user;
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
            throw new ApiV2Exception(__(ApiV2Constant::MOBILE_CODE_ERROR));
        }

        /**
         * @var $cacheService CacheService
         */
        $cacheService = app()->make(CacheServiceInterface::class);
        $key = get_cache_key(CacheConstant::MOBILE_CODE['name'], $mobile);
        $code = $cacheService->get($key);
        // 取出来之后删除[一个验证码只能用一次]
        $code && $cacheService->forget($key);
        if ($code != $mobileCode) {
            throw new ApiV2Exception(__(ApiV2Constant::MOBILE_CODE_ERROR));
        }
    }
}
