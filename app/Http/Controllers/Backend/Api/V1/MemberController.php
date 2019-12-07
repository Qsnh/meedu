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
            ->paginate($request->input('page_size', 12));

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
}
