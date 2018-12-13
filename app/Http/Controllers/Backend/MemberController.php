<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Controllers\Backend;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $keywords = $request->input('keywords', '');

        $members = User::when($keywords, function ($query) use ($keywords) {
            return $query->where('nick_name', 'like', "%{$keywords}%")
                ->orWhere('mobile', 'like', "%{$keywords}%");
        })->orderByDesc('created_at')
            ->paginate($request->input('page_size', 15));

        $members->appends($request->input());

        return view('backend.member.index', compact('members'));
    }

    public function show($id)
    {
        $member = User::findOrFail($id);

        return view('backend.member.show', compact('member'));
    }
}
