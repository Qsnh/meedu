<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu;

use App\Meedu\Utils\IP;

class Visitor
{

    public static function data(): array
    {
        $ip = request()->getClientIp();
        $ipProvince = IP::queryProvince($ip);

        return [
            'ip' => $ip,
            'ip_province' => $ipProvince,
            'ua' => request_ua(190),
            'platform' => get_platform(),
        ];
    }

}
