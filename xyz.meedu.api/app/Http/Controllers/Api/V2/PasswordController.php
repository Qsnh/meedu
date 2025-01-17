<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Api\V2;

use App\Services\Member\Services\UserService;
use App\Http\Requests\ApiV2\PasswordChangeRequest;
use App\Services\Member\Interfaces\UserServiceInterface;

class PasswordController extends BaseController
{

    /**
     * @api {post} /api/v2/password/reset [V2]密码重置
     * @apiGroup 用户认证
     * @apiName PasswordReset
     * @apiVersion v2.0.0
     *
     * @apiParam {String} mobile 手机号
     * @apiParam {String} mobile_code 短信验证码
     * @apiParam {String} password 密码
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     */
    public function reset(PasswordChangeRequest $request, UserServiceInterface $userService)
    {
        $this->mobileCodeCheck();

        /**
         * @var UserService $userService
         */

        ['mobile' => $mobile, 'password' => $password] = $request->filldata();

        $user = $userService->findMobile($mobile);
        if (!$user) {
            return $this->error(__('手机号不存在'));
        }

        $userService->changePassword($user['id'], $password);

        return $this->success();
    }
}
