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

use Illuminate\Support\Str;
use App\Constant\ApiV2Constant;
use App\Exceptions\ApiV2Exception;
use App\Http\Requests\ApiV2\RegisterRequest;
use App\Services\Member\Services\UserService;
use App\Services\Member\Interfaces\UserServiceInterface;

/**
 * Class RegisterController
 * @package App\Http\Controllers\Api\V2
 */
class RegisterController extends BaseController
{

    /**
     * @var UserService
     */
    protected $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @OA\Post(
     *     path="/register/mobile",
     *     summary="手机号注册",
     *     tags={"Auth"},
     *     @OA\RequestBody(description="",@OA\JsonContent(
     *         @OA\Property(property="mobile",description="手机号",type="string"),
     *         @OA\Property(property="mobile_code",description="手机验证码",type="string"),
     *     )),
     *     @OA\Response(
     *         description="",response=200,
     *         @OA\JsonContent(
     *             @OA\Property(property="code",type="integer",description="状态码"),
     *             @OA\Property(property="message",type="string",description="消息"),
     *             @OA\Property(property="data",type="object",description=""),
     *         )
     *     )
     * )
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ApiV2Exception
     */
    public function mobileRegister(RegisterRequest $request)
    {
        $this->mobileCodeCheck();
        ['mobile' => $mobile] = $request->filldata();
        $user = $this->userService->findMobile($mobile);
        if ($user) {
            return $this->error(__(ApiV2Constant::MOBILE_HAS_EXISTS));
        }
        $this->userService->createWithMobile($mobile, '', '');
        return $this->success();
    }
}
