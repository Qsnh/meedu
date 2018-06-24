<?php

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
            return $query->where('name', 'like', "%{$keywords}%")
                ->orWhere('name', 'like', "%{$keywords}%");
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
