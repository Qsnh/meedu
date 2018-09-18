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

class YZGetTokenClient
{
    private static $request_url = 'https://open.youzan.com/oauth/token';

    public function __construct($client_id, $client_secret, $access_token = null, $refresh_token = null)
    {
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
        $this->access_token = $access_token;
        $this->refresh_token = $refresh_token;
    }

    /**
     * 获取access_token.
     */
    public function get_token($type, $keys = [])
    {
        $params = [];
        $params['client_id'] = $this->client_id;
        $params['client_secret'] = $this->client_secret;
        if ($type === 'oauth') {
            $params['grant_type'] = 'authorization_code';
            $params['code'] = $keys['code'];
            $params['redirect_uri'] = $keys['redirect_uri'];
        } elseif ($type === 'refresh_token') {
            $params['grant_type'] = 'refresh_token';
            $params['refresh_token'] = $keys['refresh_token'];
        } elseif ($type === 'self') {
            $params['grant_type'] = 'silent';
            $params['kdt_id'] = $keys['kdt_id'];
        } elseif ($type === 'platform_init') {
            $params['grant_type'] = 'authorize_platform';
        } elseif ($type === 'platform') {
            $params['grant_type'] = 'authorize_platform';
            $params['kdt_id'] = $keys['kdt_id'];
        }

        return $this->parse_response(
            YZHttpClient::post(self::$request_url, $params)
        );
    }

    private function parse_response($response_data)
    {
        $data = json_decode($response_data, true);
        if (null === $data) {
            throw new Exception('response invalid, data: '.$response_data);
        }

        return $data;
    }
}
