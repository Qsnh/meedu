<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Order;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RoleController extends FrontendController
{

    public function index()
    {
        $roles = Role::orderByDesc('weight')->get();
        return view('frontend.role.index', compact('roles'));
    }

    public function showBuyPage($id)
    {
        $role = Role::findOrFail($id);
        return view('frontend.role.buy', compact('role'));
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
            $user->orders()->save(new Order([
                'goods_id' => $role->id,
                'goods_type' => Order::GOODS_TYPE_ROLE,
                'charge' => $role->charge,
                'status' => Order::STATUS_PAID,
            ]));

            // 扣除余额
            $user->credit1Dec($role->charge);

            // 购买会员
            $user->buyRole($role);

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
