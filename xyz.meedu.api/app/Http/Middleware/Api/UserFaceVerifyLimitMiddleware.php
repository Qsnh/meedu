<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Middleware\Api;

use App\Bus\MemberBus;
use App\Constant\FrontendConstant;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\V2\Traits\ResponseTrait;
use App\Meedu\ServiceV2\Services\ConfigServiceInterface;

class UserFaceVerifyLimitMiddleware
{
    use ResponseTrait;

    protected $configService;
    protected $memberBus;

    public function __construct(ConfigServiceInterface $configService, MemberBus $memberBus)
    {
        $this->configService = $configService;
        $this->memberBus = $memberBus;
    }

    public function handle($request, \Closure $next)
    {
        if ($this->configService->enabledFaceVerify() === false) {
            return $next($request);
        }

        $userId = Auth::guard(FrontendConstant::API_GUARD)->id();
        if ($this->memberBus->isVerify($userId) === false) {
            return $this->error(__('请先完成实名认证'));
        }

        return $next($request);
    }
}
