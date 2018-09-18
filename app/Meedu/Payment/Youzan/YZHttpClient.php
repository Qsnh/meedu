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

class YZHttpClient
{
    private static $boundary = '';

    public static function get($url, $params)
    {
        $url = $url.'?'.http_build_query($params);

        return self::http($url, 'GET');
    }

    public static function post($url, $params, $files = [])
    {
        $headers = [];
        if (! $files) {
            $body = http_build_query($params);
        } else {
            $body = self::build_http_query_multi($params, $files);
            $headers[] = 'Content-Type: multipart/form-data; boundary='.self::$boundary;
        }

        return self::http($url, 'POST', $body, $headers);
    }

    private static function http($url, $method, $postfields = null, $headers = [])
    {
        $ci = curl_init();
        /* Curl settings */
        curl_setopt($ci, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        curl_setopt($ci, CURLOPT_USERAGENT, 'X-YZ-Client 2.0.0 - PHP');
        curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ci, CURLOPT_TIMEOUT, 30);
        curl_setopt($ci, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ci, CURLOPT_ENCODING, '');
        curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ci, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ci, CURLOPT_HEADER, false);

        switch ($method) {
            case 'POST':
                curl_setopt($ci, CURLOPT_POST, true);
                if (! empty($postfields)) {
                    curl_setopt($ci, CURLOPT_POSTFIELDS, $postfields);
                }
                break;
        }

        curl_setopt($ci, CURLOPT_URL, $url);
        curl_setopt($ci, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ci, CURLINFO_HEADER_OUT, true);

        $response = curl_exec($ci);
        $httpCode = curl_getinfo($ci, CURLINFO_HTTP_CODE);
        $httpInfo = curl_getinfo($ci);

        curl_close($ci);

        return $response;
    }

    private static function build_http_query_multi($params, $files)
    {
        if (! $params) {
            return '';
        }

        $pairs = [];

        self::$boundary = $boundary = uniqid('------------------');
        $MPboundary = '--'.$boundary;
        $endMPboundary = $MPboundary.'--';
        $multipartbody = '';

        foreach ($params as $key => $value) {
            $multipartbody .= $MPboundary."\r\n";
            $multipartbody .= 'content-disposition: form-data; name="'.$key."\"\r\n\r\n";
            $multipartbody .= $value."\r\n";
        }
        foreach ($files as $key => $value) {
            if (! $value) {
                continue;
            }

            if (is_array($value)) {
                $url = $value['url'];
                if (isset($value['name'])) {
                    $filename = $value['name'];
                } else {
                    $parts = explode('?', basename($value['url']));
                    $filename = $parts[0];
                }
                $field = isset($value['field']) ? $value['field'] : $key;
            } else {
                $url = $value;
                $parts = explode('?', basename($url));
                $filename = $parts[0];
                $field = $key;
            }
            $content = file_get_contents($url);

            $multipartbody .= $MPboundary."\r\n";
            $multipartbody .= 'Content-Disposition: form-data; name="'.$field.'"; filename="'.$filename.'"'."\r\n";
            $multipartbody .= "Content-Type: image/unknown\r\n\r\n";
            $multipartbody .= $content."\r\n";
        }

        $multipartbody .= $endMPboundary;

        return $multipartbody;
    }
}
