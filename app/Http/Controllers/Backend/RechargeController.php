<?php

namespace App\Http\Controllers\Backend;

use App\Models\RechargePayment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RechargeController extends Controller
{

    public function index(Request $request)
    {
        $keywords = $request->input('keywords', '');
        $status = $request->input('status', '');

        $records = RechargePayment::with(['user'])
            ->when($status, function ($query) use ($status) {
                return $query->whereStatus($status);
            })->when($keywords, function ($query) use ($keywords) {
                return $query->userLike($keywords)
                    ->orWhere('third_id', 'like', "%{$keywords}%")
                    ->orWhere('pay_method', $keywords);
            })
            ->orderByDesc('created_at')
            ->paginate(10);
        return view('backend.recharge.index', compact('records'));
    }

}
