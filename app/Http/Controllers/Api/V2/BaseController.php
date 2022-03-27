<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Api\V2;

use App\Constant\FrontendConstant;
use App\Exceptions\ApiV2Exception;
use Illuminate\Support\Facades\Auth;
use App\Services\Member\Services\UserService;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Controllers\Api\V2\Traits\ResponseTrait;
use App\Services\Member\Interfaces\UserServiceInterface;

class BaseController
{
    use ResponseTrait;

    protected $guard = FrontendConstant::API_GUARD;

    protected $user;

    /**
     * 检测是否登录
     *
     * @return boolean
     */
    protected function check(): bool
    {
        return Auth::guard($this->guard)->check();
    }

    /**
     * @return int
     */
    protected function id()
    {
        return Auth::guard($this->guard)->id();
    }

    /**
     * @return array
     */
    protected function user()
    {
        if (!$this->user) {
            /**
             * @var $userService UserService
             */
            $userService = app()->make(UserServiceInterface::class);
            $this->user = $userService->find($this->id(), ['role']);
        }
        return $this->user;
    }

    /**
     * @param $list
     * @param $total
     * @param $page
     * @param $pageSize
     *
     * @return LengthAwarePaginator
     */
    protected function paginator($list, $total, $page, $pageSize)
    {
        return new LengthAwarePaginator($list, $total, $pageSize, $page, ['path' => request()->path()]);
    }

    /**
     * @throws ApiV2Exception
     */
    protected function mobileCodeCheck()
    {
        $mobile = request()->input('mobile');
        $mobileCode = request()->input('mobile_code');

        if (mobile_code_check($mobile, $mobileCode) === false) {
            throw new ApiV2Exception(__('短信验证码错误'));
        }
    }
}
