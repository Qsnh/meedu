<?php

namespace App\Http\Controllers\Frontend;

use Exception;
use App\Http\Controllers\Controller;
use App\Meedu\Payment\Youzan\Youzan;
use App\Models\RechargePayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{

    public function index()
    {
        return view('frontend.payment.index');
    }

    public function rechargeHandler(Request $request)
    {
        $money = abs($request->input('money', 0));
        if ($money <= 0) {
            flash('请输入正确的数字');
            return back();
        }

        $user = Auth::user();

        DB::beginTransaction();
        try {
            // 创建订单
            $recharge = $user->rechargePayments()->save(new RechargePayment([
                'money' => $money,
                'status' => RechargePayment::STATUS_NO_PAY,
                'pay_method' => 'youzan',
            ]));

            // 创建远程订单
            $result = (new Youzan)->create($recharge);
            if ($result->status === false) {
                throw new Exception('远程充值订单创建失败');
            }
            $pay = $result->data;

            DB::commit();

            return view('frontend.payment.pay', compact('pay', 'money'));
        } catch (Exception $exception) {
            DB::rollBack();
            exception_record($exception);
            flash('系统错误');
            return back();
        }
    }

    // 支付回调
    public function callback()
    {
        return (new Youzan)->callback();
    }

}
