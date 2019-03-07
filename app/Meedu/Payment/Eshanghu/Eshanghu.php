<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Meedu\Payment\Eshanghu;

use App\Models\Order;
use App\Events\PaymentSuccessEvent;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Meedu\Payment\Contract\Payment;
use App\Meedu\Payment\Contract\PaymentStatus;

class Eshanghu implements Payment
{
    public $eshanghu;

    const CACHE_KEY = 'eshanghu_code_url_%s';
    const CACHE_EXPIRE = 60;

    public function __construct()
    {
        $this->eshanghu = new EshanghuClient();
    }

    public function create(Order $order): PaymentStatus
    {
//        $result = $this->eshanghu->create($order->order_id, $order->getOrderListTitle(), $order->charge * 100);
        $result = $this->eshanghu->create($order->order_id, $order->getOrderListTitle(), 1);
        $codeUrl = $result['code_url'];

        // 缓存保存
        Cache::put(
            sprintf(self::CACHE_KEY, $order->order_id),
            $codeUrl,
            self::CACHE_EXPIRE
        );

        $response = view('frontend.payment.eshanghu', compact('codeUrl', 'order'));

        return new PaymentStatus(true, $response);
    }

    public function query(Order $order): PaymentStatus
    {
    }

    public function callback()
    {
        try {
            $data = request()->post();
            Log::debug($data);

            $this->eshanghu->callback($data);

            $order = Order::whereOrderId($data['out_trade_no'])->firstOrFail();

            event(new PaymentSuccessEvent($order));
        } catch (\Exception $exception) {
            exception_record($exception);
        }

        return 'success';
    }

    public static function payUrl(Order $order): string
    {
        return route('order.eshanghu.wechat', ['order_id' => $order->order_id]);
    }
}
