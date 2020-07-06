<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Controllers\Frontend;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;
use App\Services\Member\Services\UserService;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Services\Member\Interfaces\UserServiceInterface;

class FrontendController extends BaseController
{
    /**
     * @param $list
     * @param $total
     * @param $page
     * @param $pageSize
     * @param string $path
     * @return LengthAwarePaginator
     */
    protected function paginator($list, $total, $page, $pageSize, $path = '')
    {
        $path = $path ?: sprintf('/%s', request()->path());
        return new LengthAwarePaginator($list, $total, $pageSize, $page, ['path' => $path]);
    }

    /**
     * @return bool
     */
    public function check(): bool
    {
        return Auth::check();
    }

    /**
     * @return array|mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function user(): array
    {
        if ($this->check()) {
            /**
             * @var $userService UserService
             */
            $userService = app()->make(UserServiceInterface::class);
            return $userService->find($this->id(), ['role']);
        }
        return [];
    }
}
