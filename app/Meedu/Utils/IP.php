<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Utils;

class IP
{

    public const UNKNOWN = 'UNKNOWN';

    public static function queryCity(string $ip): string
    {
        ['region' => $region] = (new \Ip2Region())->memorySearch($ip);
        if (!$region) {
            return self::UNKNOWN;
        }
        // 返回的结果示例：
        // 中国|0|浙江省|杭州市|电信
        // 0|0|0|内网IP|内网IP
        $region = str_replace('0|', '', $region);
        $region = explode('|', $region);

        if (isset($region[2])) {
            return $region[2];
        } elseif (isset($region[1])) {
            return $region[1];
        }
        return $region[0] ?? self::UNKNOWN;
    }

    public static function queryProvince(string $ip): string
    {
        ['region' => $region] = (new \Ip2Region())->memorySearch($ip);
        if (!$region) {
            return self::UNKNOWN;
        }
        // 返回的结果示例：中国|0|浙江省|杭州市|电信
        $region = str_replace('0|', '', $region);
        $region = explode('|', $region);

        if (isset($region[1])) {
            return $region[1];
        }
        return $region[0] ?? self::UNKNOWN;
    }

}
