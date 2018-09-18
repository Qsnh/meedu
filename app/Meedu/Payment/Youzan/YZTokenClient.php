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

class YZTokenClient
{
    private static $request_url = 'https://open.youzan.com/api/oauthentry/';

    public function __construct($access_token)
    {
        if ('' == $access_token) {
            throw new Exception('access_token不能为空');
        }
        $this->access_token = $access_token;
    }

    public function get($method, $api_version, $params = [])
    {
        return $this->parse_response(
            YZHttpClient::get($this->url($method, $api_version), $this->build_request_params($method, $params))
        );
    }

    public function post($method, $api_version, $params = [], $files = [])
    {
        return $this->parse_response(
            YZHttpClient::post($this->url($method, $api_version), $this->build_request_params($method, $params), $files)
        );
    }

    public function url($method, $api_version)
    {
        $method_array = explode('.', $method);
        $method = '/'.$api_version.'/'.$method_array[count($method_array) - 1];
        array_pop($method_array);
        $method = implode('.', $method_array).$method;
        $url = self::$request_url.$method;

        return $url;
    }

    private function parse_response($response_data)
    {
        $data = json_decode($response_data, true);
        if (null === $data) {
            throw new Exception('response invalid, data: '.$response_data);
        }

        return $data;
    }

    private function build_request_params($method, $api_params)
    {
        if (! is_array($api_params)) {
            $api_params = [];
        }
        $pairs = $this->get_common_params($this->access_token, $method);
        foreach ($api_params as $k => $v) {
            if (isset($pairs[$k])) {
                throw new Exception('参数名冲突');
            }
            $pairs[$k] = $v;
        }

        return $pairs;
    }

    private function get_common_params($access_token, $method)
    {
        $params = [];
        $params[YZApiProtocol::TOKEN_KEY] = $access_token;
        $params[YZApiProtocol::METHOD_KEY] = $method;

        return $params;
    }
}
