<?php

namespace App\Http\Controllers\Backend;

use App\Exports\RechargePaymentExport;
use App\Models\RechargePayment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class RechargeController extends Controller
{

    public function index(Request $request)
    {
        if ($request->has('export')) {
            return redirect(route('backend.recharge.export', $request->all()));
        }
        $records = RechargePayment::filter($request)->paginate(10);
        return view('backend.recharge.index', compact('records'));
    }

    public function exportToExcel(Request $request)
    {
        $records = RechargePayment::filter($request)->get();
        return Excel::download(new RechargePaymentExport($records), 'recharge_records.xlsx');
    }

}
