<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Controllers\Frontend;

use Exception;
use Illuminate\Http\Request;
use App\Models\RechargePayment;
use Illuminate\Support\Facades\DB;
use App\Meedu\Payment\Youzan\Youzan;
use Illuminate\Support\Facades\Auth;

class PaymentController extends FrontendController
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
            $result = (new Youzan())->create($recharge);
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
        return (new Youzan())->callback();
    }
}
