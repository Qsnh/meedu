<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Middleware\Api;

use Closure;
use App\Events\UserLogoutEvent;
use App\Constant\FrontendConstant;
use Illuminate\Support\Facades\Auth;
use App\Meedu\ServiceV2\Services\UserService;
use App\Http\Controllers\Api\V2\Traits\ResponseTrait;
use App\Meedu\ServiceV2\Services\ConfigServiceInterface;

class LoginStatusCheckMiddleware
{
    use ResponseTrait;

    protected $configService;
    protected $userService;

    public function __construct(ConfigServiceInterface $configService, UserService $userService)
    {
        $this->configService = $configService;
        $this->userService = $userService;
    }

    public function handle($request, Closure $next)
    {
        $rule = $this->configService->getLoginLimitRule();

        if ($rule === FrontendConstant::LOGIN_LIMIT_RULE_ALL) {
            $userId = Auth::guard(FrontendConstant::API_GUARD)->id();

            // 当前登录用户使用的token
            $authorization = $request->header('Authorization');
            if ($authorization) {
                $token = explode(' ', $authorization)[1];
                $tokenPayload = token_payload($token);
                $jti = $tokenPayload['jti'];

                $lastLoginJTI = $this->userService->findLastLoginJTI($userId);
                if ($lastLoginJTI && $lastLoginJTI !== $jti) {
                    event(new UserLogoutEvent($userId, $token));
                    Auth::guard(FrontendConstant::API_GUARD)->logout();
                    return $this->error(__('请重新登录'), 401);
                }
            }
        }

        return $next($request);
    }
}
