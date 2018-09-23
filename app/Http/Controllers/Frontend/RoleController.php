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

use App\Models\Role;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Notifications\SimpleMessageNotification;

class RoleController extends FrontendController
{
    public function index()
    {
        $roles = Role::orderByDesc('weight')->get();
        ['title' => $title, 'keywords' => $keywords, 'description' => $description] = config('meedu.seo.role_list');

        return view('frontend.role.index', compact('roles', 'title', 'keywords', 'description'));
    }

    public function showBuyPage($id)
    {
        $role = Role::findOrFail($id);
        $title = sprintf('购买VIP《%s》', $role->name);

        return view('frontend.role.buy', compact('role', 'title'));
    }

    public function buyHandler($id)
    {
        $role = Role::findOrFail($id);
        $user = Auth::user();

        if ($user->role && $user->role->weight != $role->weight) {
            flash('您的账户下面已经有会员啦');

            return back();
        }

        DB::beginTransaction();
        try {
            // 创建订单记录
            $order = $user->orders()->save(new Order([
                'goods_id' => $role->id,
                'goods_type' => Order::GOODS_TYPE_ROLE,
                'charge' => $role->charge,
                'status' => Order::STATUS_PAID,
            ]));
            // 扣除余额
            $user->credit1Dec($role->charge);
            // 购买会员
            $user->buyRole($role);
            // 消息通知
            $user->notify(new SimpleMessageNotification($order->getNotificationContent()));

            DB::commit();

            flash('购买成功', 'success');

            return redirect(route('member'));
        } catch (\Exception $exception) {
            DB::rollBack();
            exception_record($exception);
            flash('系统出错');

            return back();
        }
    }
}
