<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Meedu;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class Ip
{
    public static function ip2area($ip)
    {
        $clinet = new Client(['timeout' => 5.0]);
        try {
            $response = $clinet->get('http://ip-api.com/json/' . $ip . '?lang=zh-CN');
            if ($response->getStatusCode() !== 200) {
                // http请求错误
                Log::error(__METHOD__ . '|ip接口无法请求');
                return false;
            }
            $content = json_decode($response->getBody(), true);
            if (!$content) {
                Log::error(__METHOD__ . '|ip接口返回不支持的信息', ['content' => $response->getBody()]);
                return false;
            }
            $status = $content['status'] ?? '';
            if ($status !== 'success') {
                Log::error(__METHOD__ . '|ip接口错误信息', $content);
                return false;
            }

            $country = $content['country'] ?? '';
            $city = $content['city'] ?? '';
            return $city ?: $country;
        } catch (\Exception $e) {
            exception_record($e);
            return false;
        }
    }
}
