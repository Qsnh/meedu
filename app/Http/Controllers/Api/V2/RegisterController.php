<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Api\V2;

use App\Services\Member\Services\UserService;
use App\Http\Requests\ApiV2\RegisterSmsRequest;
use App\Services\Member\Interfaces\UserServiceInterface;

class RegisterController extends BaseController
{

    /**
     * @api {post} /api/v2/register/sms 短信注册
     * @apiGroup Auth
     * @apiVersion v2.0.0
     *
     * @apiParam {String} mobile 手机号
     * @apiParam {String} mobile_code 短信验证码
     * @apiParam {String} password 密码
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     */
    public function smsHandler(RegisterSmsRequest $request, UserServiceInterface $userService)
    {
        /**
         * @var UserService $userService
         */

        $this->mobileCodeCheck();

        ['mobile' => $mobile, 'password' => $password] = $request->filldata();

        if ($userService->findMobile($mobile)) {
            return $this->error(__('手机号已存在'));
        }

        $userService->createWithMobile($mobile, $password, '');

        return $this->success();
    }
}
