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
use App\Services\Base\Interfaces\ConfigServiceInterface;
use App\Services\Member\Interfaces\RoleServiceInterface;
use App\Services\Order\Interfaces\OrderServiceInterface;

class RoleController extends FrontendController
{
    protected $roleService;
    protected $configService;
    protected $orderService;

    public function __construct(
        RoleServiceInterface $roleService,
        ConfigServiceInterface $configService,
        OrderServiceInterface $orderService
    ) {
        $this->roleService = $roleService;
        $this->configService = $configService;
        $this->orderService = $orderService;
    }

    public function index()
    {
        $roles = $this->roleService->all();
        [
            'title' => $title,
            'keywords' => $keywords,
            'description' => $description
        ] = $this->configService->getSeoRoleListPage();

        return v('frontend.role.index', compact('roles', 'title', 'keywords', 'description'));
    }

    public function showBuyPage($id)
    {
        $role = $this->roleService->find($id);
        $title = sprintf('购买VIP《%s》', $role['name']);

        return v('frontend.role.buy', compact('role', 'title'));
    }

    public function buyHandler($id)
    {
        $role = $this->roleService->find($id);
        $order = $this->orderService->createRoleOrder(Auth::id(), $role);

        flash(__('order successfully, please pay'), 'success');

        return redirect(route('order.show', $order['order_id']));
    }
}
