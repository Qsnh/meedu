<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers;

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

    public function redirectTo()
    {
        return url('/');
    }

    public function userPlatform()
    {
        return get_platform();
    }
}
