<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Meedu\Payment\Youzan;

use Exception;
use App\Models\RechargePayment;
use App\Events\PaymentSuccessEvent;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Meedu\Payment\Contract\Payment;
use App\Meedu\Payment\Contract\PaymentStatus;

class Youzan implements Payment
{
    const VERSION = '3.0.0';

    protected $config;

    public function __construct()
    {
        $this->config = config('meedu.payment.youzan');
    }

    public function create(RechargePayment $payment): PaymentStatus
    {
        try {
            $client = new YZTokenClient($this->getToken());
            $params = [
                'qr_name' => $payment->getGoodsTitle(),
                'qr_price' => $payment->money * 100,
                'qr_type' => 'QR_TYPE_DYNAMIC',
            ];
            $response = $client->post('youzan.pay.qrcode.create', self::VERSION, $params);
            $response = $response['response'];

            // 记录第三方ID
            $payment->third_id = $response['qr_id'];
            $payment->save();

            return new PaymentStatus(true, $response);
        } catch (Exception $exception) {
            exception_record($exception);

            return new PaymentStatus();
        }
    }

    public function query(RechargePayment $payment): PaymentStatus
    {
        try {
            $client = new YZTokenClient($this->getToken());
            $params = [
                'qr_id' => $payment->third_id,
                'status' => 'TRADE_RECEIVED',
            ];
            $response = $client->post('youzan.trades.qr.get', self::VERSION, $params);
            $response = $response['response'];
            if (! $response['qr_trades']) {
                return new PaymentStatus();
            }

            return new PaymentStatus(true, $response);
        } catch (Exception $exception) {
            exception_record($exception);

            return new PaymentStatus();
        }
    }

    public function callback()
    {
        $data = request()->post();
        Log::info($data);

        try {
            $this->checkSing($data);
            if (
                'trade_TradePaid' === $data['type'] &&
                false === $data['test'] &&
                'TRADE_PAID' === $data['status']
            ) {
                $msg = json_decode(urldecode($data['msg']), true);
                event(new PaymentSuccessEvent($msg['qr_info']['qr_id']));
            }
        } catch (Exception $exception) {
            exception_record($exception);
        }

        return ['code' => 0, 'msg' => 'success'];
    }

    protected function checkSing($data)
    {
        $sign = md5($this->config['client_id'].$data['msg'].$this->config['client_secret']);
        if ($sign != $data['sign']) {
            throw new Exception('有赞回调签名错误');
        }
    }

    protected function getTokenCache()
    {
        $self = $this;

        return Cache::remember('payment:youzan:token', 360, function () use ($self) {
            return $self->getToken();
        });
    }

    protected function getToken()
    {
        $token = new YZGetTokenClient($this->config['client_id'], $this->config['client_secret']);
        $type = 'self';
        $keys['kdt_id'] = $this->config['kdt_id'];
        $tokenString = $token->get_token($type, $keys);

        return $tokenString['access_token'] ?? '';
    }
}
