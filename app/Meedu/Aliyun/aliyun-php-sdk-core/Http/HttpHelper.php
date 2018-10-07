<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

class HttpHelper
{
    public static $connectTimeout = 30; //30 second
    public static $readTimeout = 80; //80 second

    public static function curl($url, $httpMethod = 'GET', $postFields = null, $headers = null)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $httpMethod);
        if (ENABLE_HTTP_PROXY) {
            curl_setopt($ch, CURLOPT_PROXYAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_PROXY, HTTP_PROXY_IP);
            curl_setopt($ch, CURLOPT_PROXYPORT, HTTP_PROXY_PORT);
            curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FAILONERROR, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, is_array($postFields) ? self::getPostHttpBody($postFields) : $postFields);

        if (self::$readTimeout) {
            curl_setopt($ch, CURLOPT_TIMEOUT, self::$readTimeout);
        }
        if (self::$connectTimeout) {
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, self::$connectTimeout);
        }
        //https request
        if (strlen($url) > 5 && strtolower(substr($url, 0, 5)) == 'https') {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }
        if (is_array($headers) && 0 < count($headers)) {
            $httpHeaders = self::getHttpHearders($headers);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $httpHeaders);
        }
        $httpResponse = new HttpResponse();
        $httpResponse->setBody(curl_exec($ch));
        $httpResponse->setStatus(curl_getinfo($ch, CURLINFO_HTTP_CODE));
        if (curl_errno($ch)) {
            throw new ClientException('Server unreachable: Errno: '.curl_errno($ch).' '.curl_error($ch), 'SDK.ServerUnreachable');
        }
        curl_close($ch);

        return $httpResponse;
    }

    public static function getPostHttpBody($postFildes)
    {
        $content = '';
        foreach ($postFildes as $apiParamKey => $apiParamValue) {
            $content .= "$apiParamKey=".urlencode($apiParamValue).'&';
        }

        return substr($content, 0, -1);
    }

    public static function getHttpHearders($headers)
    {
        $httpHeader = [];
        foreach ($headers as $key => $value) {
            array_push($httpHeader, $key.':'.$value);
        }

        return $httpHeader;
    }
}
