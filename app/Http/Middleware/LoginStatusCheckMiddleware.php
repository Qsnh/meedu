<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Middleware;

use Closure;
use App\Constant\FrontendConstant;
use Illuminate\Support\Facades\Auth;
use App\Services\Base\Services\ConfigService;
use App\Services\Member\Services\UserService;
use App\Services\Base\Interfaces\ConfigServiceInterface;
use App\Services\Member\Interfaces\UserServiceInterface;

class LoginStatusCheckMiddleware
{

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
     * 该中间件必须在已登录的情况下使用
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        $rule = $this->configService->getLoginLimitRule();
        if ($rule === FrontendConstant::LOGIN_LIMIT_RULE_PLATFORM || $rule === FrontendConstant::LOGIN_LIMIT_RULE_ALL) {
            $lastLoginAt = $request->cookie('last_login_at');
            if (!$lastLoginAt) {
                // cookie为空
                Auth::logout();
                flash(__('please login again'));
                return redirect(route('login'));
            }

            $platform = '';
            if ($rule === FrontendConstant::LOGIN_LIMIT_RULE_PLATFORM) {
                $platform = is_h5() ? FrontendConstant::LOGIN_PLATFORM_H5 : FrontendConstant::LOGIN_PLATFORM_PC;
            }

            $userLastLoginRecord = $this->userService->findUserLastLoginRecord($user['id'], $platform);
            if (!$userLastLoginRecord) {
                // 登录记录不存在
                Auth::logout();
                flash(__('please login again'));
                return redirect(route('login'));
            }
            
            if ($lastLoginAt != strtotime($userLastLoginRecord['at'])) {
                // 最近一次登录时间不等
                Auth::logout();
                flash(__('please login again'));
                return redirect(route('login'));
            }
        }
        return $next($request);
    }
}
