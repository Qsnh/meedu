<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Middleware\Api;

use Closure;
use App\Constant\FrontendConstant;
use Illuminate\Support\Facades\Auth;
use App\Services\Base\Services\ConfigService;
use App\Services\Member\Services\UserService;
use App\Http\Controllers\Api\V2\Traits\ResponseTrait;
use App\Services\Base\Interfaces\ConfigServiceInterface;
use App\Services\Member\Interfaces\UserServiceInterface;

class LoginStatusCheckMiddleware
{
    use ResponseTrait;

    /**
     * @var ConfigService
     */
    protected $configService;

    /**
     * @var UserService
     */
    protected $userService;

    public function __construct(ConfigServiceInterface $configService, UserServiceInterface $userService)
    {
        $this->configService = $configService;
        $this->userService = $userService;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $guard = FrontendConstant::API_GUARD;
        $user = Auth::guard($guard)->user();

        $rule = $this->configService->getLoginLimitRule();
        if ($rule === FrontendConstant::LOGIN_LIMIT_RULE_ALL) {
            $lastLoginAt = Auth::guard($guard)->payload()[FrontendConstant::USER_LOGIN_AT_COOKIE_NAME] ?? '';
            if (!$lastLoginAt) {
                // 当前token中没有最后登录时间 -> 主动退出登录
                Auth::guard($guard)->logout();
                return $this->error(__('请重新登录'), 401);
            }

            $userLastLoginRecord = $this->userService->findUserLastLoginRecord($user['id'], '');
            if (!$userLastLoginRecord) {
                // 当前用户没有登录记录 -> 主动退出
                Auth::guard($guard)->logout();
                return $this->error(__('请重新登录'), 401);
            }

            if ($lastLoginAt != strtotime($userLastLoginRecord['at'])) {
                // 最近一次登录时间不等
                Auth::guard($guard)->logout();
                return $this->error(__('请重新登录'), 401);
            }
        }
        return $next($request);
    }
}
