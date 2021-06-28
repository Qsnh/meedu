<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

namespace App\Http\Controllers\Api\V2;

use App\Services\Member\Services\UserService;
use App\Http\Requests\ApiV2\PasswordChangeRequest;
use App\Services\Member\Interfaces\UserServiceInterface;

class PasswordController extends BaseController
{
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
