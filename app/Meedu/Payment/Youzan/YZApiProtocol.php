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

class YZApiProtocol
{
    const APP_ID_KEY = 'app_id';
    const METHOD_KEY = 'method';
    const TIMESTAMP_KEY = 'timestamp';
    const FORMAT_KEY = 'format';
    const VERSION_KEY = 'v';
    const SIGN_KEY = 'sign';
    const SIGN_METHOD_KEY = 'sign_method';
    const TOKEN_KEY = 'access_token';
    const ALLOWED_DEVIATE_SECONDS = 600;

    const ERR_SYSTEM = -1;
    const ERR_INVALID_APP_ID = 40001;
    const ERR_INVALID_APP = 40002;
    const ERR_INVALID_TIMESTAMP = 40003;
    const ERR_EMPTY_SIGNATURE = 40004;
    const ERR_INVALID_SIGNATURE = 40005;
    const ERR_INVALID_METHOD_NAME = 40006;
    const ERR_INVALID_METHOD = 40007;
    const ERR_INVALID_TEAM = 40008;
    const ERR_PARAMETER = 41000;
    const ERR_LOGIC = 50000;

    public static function sign($appSecret, $params, $method = 'md5')
    {
        if (! is_array($params)) {
            $params = [];
        }

        ksort($params);
        $text = '';
        foreach ($params as $k => $v) {
            $text .= $k.$v;
        }

        return self::hash($method, $appSecret.$text.$appSecret);
    }

    private static function hash($method, $text)
    {
        switch ($method) {
            case 'md5':
            default:
                $signature = md5($text);
                break;
        }

        return $signature;
    }

    public static function allowed_sign_methods()
    {
        return ['md5'];
    }

    public static function allowed_format()
    {
        return ['json'];
    }
}
