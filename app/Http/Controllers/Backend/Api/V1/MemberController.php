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

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\Backend\MemberRequest;
use App\Events\UserInviteBalanceWithdrawHandledEvent;
use App\Services\Member\Models\UserInviteBalanceWithdrawOrder;

class MemberController extends BaseController
{
    public function index(Request $request)
    {
        $keywords = $request->input('keywords', '');

        $members = User::with(['role'])
            ->when($keywords, function ($query) use ($keywords) {
                return $query->where('nick_name', 'like', "%{$keywords}%")
                    ->orWhere('mobile', 'like', "%{$keywords}%");
            })->orderByDesc('created_at')
            ->paginate($request->input('size', 12));

        $members->appends($request->input());

        return $this->successData($members);
    }

    public function show($id)
    {
        $member = User::findOrFail($id);

        return $this->successData($member);
    }

    public function store(MemberRequest $request)
    {
        User::create($request->filldata());

        return $this->success();
    }

    public function inviteBalanceWithdrawOrders(Request $request)
    {
        $orders = UserInviteBalanceWithdrawOrder::latest()->paginate($request->input('size', 12));
        $users = \App\Services\Member\Models\User::whereIn('id', $orders->pluck('user_id'))->get()->keyBy('id');
        return $this->successData(compact('orders', 'users'));
    }

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
}
