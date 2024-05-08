<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\V2\Traits\ResponseTrait;
use App\Services\Base\Interfaces\ConfigServiceInterface;

class BaseController extends Controller
{
    use ResponseTrait;

    protected $configService;

    public function __construct(ConfigServiceInterface $configService)
    {
        $this->configService = $configService;
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
}
