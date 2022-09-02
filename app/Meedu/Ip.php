<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use App\Services\Base\Services\ConfigService;
use App\Services\Base\Interfaces\ConfigServiceInterface;

class Ip
{
    public static function ip2area($ip)
    {
        /**
         * @var ConfigService $configService
         */
        $configService = app()->make(ConfigServiceInterface::class);
        $key = $configService->getAmapkey();
        if (!$key) {
            Log::info(__METHOD__ . '|未配置高德地图配置');
            return '';
        }

        $clinet = new Client(['timeout' => 5.0]);
        try {
            $response = $clinet->get('https://restapi.amap.com/v3/ip?key=' . $key . '&ip=' . $ip . '&output=JSON');
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
            $status = (int)($content['status'] ?? 0);
            if ($status !== 1) {
                Log::error(__METHOD__ . '|ip接口错误信息', $content['info'] ?? '');
                return false;
            }

            $country = $content['province'] ?? '';
            $city = $content['city'] ?? '';

            return $country . $city;
        } catch (\Exception $e) {
            Log::error(__METHOD__ . '|' . $e->getMessage());
            return false;
        }
    }
}
