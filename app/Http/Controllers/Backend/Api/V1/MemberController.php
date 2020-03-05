<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Controllers\Backend\Api\V1;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Services\Member\Models\Role;
use App\Services\Member\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Backend\MemberRequest;
use App\Events\UserInviteBalanceWithdrawHandledEvent;
use App\Services\Member\Models\UserInviteBalanceWithdrawOrder;

class MemberController extends BaseController
{
    public function index(Request $request)
    {
        $keywords = $request->input('keywords', '');
        $roleId = $request->input('role_id');
        $sort = $request->input('sort', 'created_at');
        $order = $request->input('order', 'desc');

        $members = User::with(['role'])
            ->when($keywords, function ($query) use ($keywords) {
                return $query->where('nick_name', 'like', "%{$keywords}%")
                    ->orWhere('mobile', 'like', "%{$keywords}%");
            })
            ->when($roleId, function ($query) use ($roleId) {
                $query->whereRoleId($roleId)->where('role_expired_at', '>', Carbon::now());
            })
            ->orderBy($sort, $order)
            ->paginate($request->input('size', 20));

        $members->appends($request->input());

        $roles = Role::select(['id', 'name'])->get();

        return $this->successData(compact('members', 'roles'));
    }

    public function create()
    {
        $roles = Role::all();
        return $this->successData(compact('roles'));
    }

    public function edit($id)
    {
        $member = User::findOrFail($id);

        return $this->successData($member);
    }

    public function store(MemberRequest $request)
    {
        User::create($request->filldata());

        return $this->success();
    }

    // 用户提现订单
    public function inviteBalanceWithdrawOrders(Request $request)
    {
        $orders = UserInviteBalanceWithdrawOrder::latest()->paginate($request->input('size', 12));
        $users = \App\Services\Member\Models\User::whereIn('id', $orders->pluck('user_id'))->get()->keyBy('id');
        return $this->successData(compact('orders', 'users'));
    }

    // 用户提现订单处理
    public function inviteBalanceWithdrawOrderHandle(Request $request)
    {
        $ids = $request->input('ids');
        $status = $request->input('status');
        $remark = $request->input('remark', '');
        UserInviteBalanceWithdrawOrder::whereIn('id', $ids)->update([
            'status' => $status,
            'remark' => $remark,
        ]);
        event(new UserInviteBalanceWithdrawHandledEvent($ids, $status));
        return $this->success();
    }

    // 用户编辑
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $data = $request->all();
        $data = Arr::only($data, [
            'avatar', 'nick_name', 'mobile', 'password',
            'is_lock', 'is_active', 'role_id', 'role_expired_at',
            'invite_user_id', 'invite_balance', 'invite_user_expired_at',
        ]);
        ($data['password'] ?? '') && $data['password'] = Hash::make($data['password']);
        $user->fill($data)->save();
        return $this->success();
    }
}
