<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

namespace App\Http\Controllers;

use App\Constant\FrontendConstant;
use Illuminate\Support\Facades\Auth;
use App\Services\Base\Services\ConfigService;
use App\Http\Controllers\Api\V2\Traits\ResponseTrait;
use App\Services\Base\Interfaces\ConfigServiceInterface;

class BaseController extends Controller
{
    use ResponseTrait;

    /**
     * @var ConfigService $configService
     */
    protected $configService;

    public function __construct()
    {
        $this->configService = app()->make(ConfigServiceInterface::class);
    }

    public function id()
    {
        return Auth::id();
    }

    public function check()
    {
        return Auth::check();
    }

    public function user()
    {
        return Auth::user()->toArray();
    }

    public function recordRedirectTo(): void
    {
        $request = request();

        // 主动配置redirect
        $redirect = $request->input('redirect');
        if (!$redirect) {
            $redirect = url('/');
        }

        // 存储redirectTo
        $redirect && session([FrontendConstant::LOGIN_CALLBACK_URL_KEY => $redirect]);
    }

    public function redirectTo()
    {
        return session(FrontendConstant::LOGIN_CALLBACK_URL_KEY) ?: url('/');
    }

    public function userPlatform(): string
    {
        return is_h5() ? FrontendConstant::LOGIN_PLATFORM_H5 : FrontendConstant::LOGIN_PLATFORM_PC;
    }
}
