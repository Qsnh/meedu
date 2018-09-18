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

class YZSignClient
{
    const VERSION = '1.0';

    private static $request_url = 'https://open.youzan.com/api/entry/';
    private $app_id;
    private $app_secret;
    private $format = 'json';
    private $sign_method = 'md5';

    public function __construct($app_id, $app_secret)
    {
        if ('' == $app_id || '' == $app_secret) {
            throw new Exception('app_id 和 app_secret 不能为空');
        }
        $this->app_id = $app_id;
        $this->app_secret = $app_secret;
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

    public function set_format($format)
    {
        if (! in_array($format, YZApiProtocol::allowed_format())) {
            throw new Exception('设置的数据格式错误');
        }
        $this->format = $format;

        return $this;
    }

    public function set_sign_method($method)
    {
        if (! in_array($method, YZApiProtocol::allowed_sign_methods())) {
            throw new Exception('设置的签名方法错误');
        }
        $this->sign_method = $method;

        return $this;
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
        if ($this->app_id) {
        }
        $pairs = $this->get_common_params($method);
        foreach ($api_params as $k => $v) {
            if (isset($pairs[$k])) {
                throw new Exception('参数名冲突');
            }
            $pairs[$k] = $v;
        }
        $pairs[YZApiProtocol::SIGN_KEY] = YZApiProtocol::sign($this->app_secret, $pairs, $this->sign_method);

        return $pairs;
    }

    private function get_common_params($method)
    {
        $params = [];
        $params[YZApiProtocol::APP_ID_KEY] = $this->app_id;
        $params[YZApiProtocol::METHOD_KEY] = $method;
        $params[YZApiProtocol::TIMESTAMP_KEY] = date('Y-m-d H:i:s');
        $params[YZApiProtocol::FORMAT_KEY] = $this->format;
        $params[YZApiProtocol::SIGN_METHOD_KEY] = $this->sign_method;
        $params[YZApiProtocol::VERSION_KEY] = self::VERSION;

        return $params;
    }
}
