<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Api\V2;

use Illuminate\Http\Request;
use App\Services\Base\Services\ConfigService;
use App\Bus\AuthBus;
use App\Http\Requests\ApiV2\RegisterSmsRequest;
use App\Http\Requests\ApiV2\RegisterRequest;
use App\Services\Member\Services\UserService;
use App\Constant\ApiV2Constant;

class RegisterController extends BaseController
{
    public function __construct(
        private ConfigService $configService,
        private AuthBus $authBus,
        private UserService $userService
    ) {}

    /**
     * @api {post} /api/v2/register/sms 手机短信注册
     * @apiGroup 注册
     * @apiName RegisterSms
     * @apiVersion 2.0.0
     *
     * @apiParam {String} mobile 手机号
     * @apiParam {String} mobile_code 手机验证码
     * @apiParam {String} password 密码
     */
    public function smsHandler(RegisterSmsRequest $request)
    {
        ['mobile' => $mobile, 'mobile_code' => $mobileCode, 'password' => $password] = $request->validated();

        if ($this->userService->findMobile($mobile)) {
            return $this->error(__('mobile has exists'));
        }

        $user = $this->userService->createWithMobile($mobile, $password);
        $token = $this->authBus->loginUsingId($user['id']);

        return $this->data([
            'token' => $token,
            'user' => $user,
        ]);
    }
}