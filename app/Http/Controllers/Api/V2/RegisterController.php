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

use App\Services\Member\Services\UserService;
use App\Http\Requests\ApiV2\RegisterSmsRequest;
use App\Services\Member\Interfaces\UserServiceInterface;

class RegisterController extends BaseController
{

    /**
     * @OA\Post(
     *     path="/register/sms",
     *     summary="短信注册",
     *     tags={"Auth"},
     *     @OA\RequestBody(description="",@OA\JsonContent(
     *         @OA\Property(property="mobile",description="手机号",type="string"),
     *         @OA\Property(property="mobile_code",description="短信验证码",type="string"),
     *         @OA\Property(property="password",description="密码",type="string"),
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
     */
    public function smsHandler(RegisterSmsRequest $request, UserServiceInterface $userService)
    {
        /**
         * @var UserService $userService
         */

        $this->mobileCodeCheck();

        ['mobile' => $mobile, 'password' => $password] = $request->filldata();

        if ($userService->findMobile($mobile)) {
            return $this->error(__('mobile.unique'));
        }

        $userService->createWithMobile($mobile, $password, '');

        return $this->success();
    }
}
