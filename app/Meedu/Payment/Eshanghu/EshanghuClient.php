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

use GuzzleHttp\Client;

class EshanghuClient
{
    public $appKey;
    public $appSecret;
    public $subMchId;
    public $notify;
    public $client;

    public function __construct()
    {
        $this->appKey = config('eshanghu.app_key');
        $this->appSecret = config('eshanghu.app_secret');
        $this->subMchId = config('eshanghu.sub_mch_id');
        $this->notify = config('eshanghu.notify');

        $this->client = new Client([
            'timeout' => 10.0,
            'verify' => false,
        ]);
    }

    /**
     * 创建签名.
     *
     * @param string $outTradeNo
     * @param string $subject
     * @param int    $totalFee
     * @param string $extra
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function create(string $outTradeNo, string $subject, int $totalFee, string $extra = '')
    {
        $data = [
            'app_key' => $this->appKey,
            'out_trade_no' => $outTradeNo,
            'total_fee' => $totalFee,
            'subject' => $subject,
            'extra' => $extra.'a',
            'notify_url' => $this->notify,
        ];
        $data['sign'] = $this->getSign($data);

        $response = $this->client->post('https://1shanghu.com/api/wechat/native', [
            'form_params' => $data,
        ]);
        if ($response->getStatusCode() != 200) {
            throw new \Exception('无法创建远程支付订单');
        }
        $responseContent = json_decode($response->getBody(), true);
        if ($responseContent['code'] != 200) {
            throw new \Exception($responseContent['message']);
        }

        return $responseContent['data'];
    }

    /**
     * 获取签名.
     *
     * @param array $data
     *
     * @return string
     */
    public function getSign(array $data)
    {
        ksort($data);
        $need = [];
        foreach ($data as $key => $value) {
            if (! $value || $key == 'sign') {
                continue;
            }
            $need[] = "{$key}={$value}";
        }
        $string = implode('&', $need).$this->appSecret;

        return strtoupper(md5($string));
    }

    /**
     * 验证sign.
     *
     * @param array $data
     *
     * @return bool
     */
    public function verifySign(array $data)
    {
        $sign = $data['sign'];

        return strtoupper($sign) === $this->getSign($data);
    }

    /**
     * 异步回调.
     *
     * @param array $data
     *
     * @return array
     *
     * @throws \Exception
     */
    public function callback(array $data)
    {
        if (! $this->verifySign($data)) {
            throw new \Exception('签名校验失败');
        }

        return $data;
    }
}
