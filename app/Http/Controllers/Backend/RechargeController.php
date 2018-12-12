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

use Illuminate\Http\Request;
use App\Models\RechargePayment;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RechargePaymentExport;

class RechargeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('export')) {
            return redirect(route('backend.recharge.export', $request->all()));
        }
        $records = RechargePayment::filter($request)->paginate(10);

        return v('backend.recharge.index', compact('records'));
    }

    public function exportToExcel(Request $request)
    {
        $records = RechargePayment::filter($request)->get();

        return Excel::download(new RechargePaymentExport($records), 'recharge_records.xlsx');
    }
}
