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
    protected function success($message = '', $data = [])
    {
        return [
            'code' => 200,
            'message' => $message,
            'data' => $data,
        ];
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
        return new LengthAwarePaginator($list, $total, $pageSize, $page, ['path' => sprintf('/%s', request()->path())]);
    }

    protected function user()
    {
        if (Auth::check()) {
            /**
             * @var $userService UserService
             */
            $userService = app()->make(UserServiceInterface::class);
            return $userService->find(Auth::id(), ['role']);
        }
        return [];
    }
}
