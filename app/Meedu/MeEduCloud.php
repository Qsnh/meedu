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

use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class MeEduCloud
{
    const URI = 'https://meedu.vip';
    const ACCESS_TOKEN_KEY = 'meedu_cloud_access_token';

    protected $clientId;
    protected $clientSecret;
    protected $username;
    protected $password;

    protected $client;

    public function __construct()
    {
        $this->clientId = config('meedu.cloud.client_id');
        $this->clientSecret = config('meedu.cloud.client_secret');
        $this->username = config('meedu.cloud.username');
        $this->password = config('meedu.cloud.password');
        $this->client = new Client([
            'base_uri' => self::URI,
            'verify' => false,
            'timeout' => 5.0,
        ]);
    }

    /**
     * 经过缓存层读取AccessToken.
     *
     * @return mixed|string
     *
     * @throws Exception
     */
    public function accessToken()
    {
        if (Cache::has(self::ACCESS_TOKEN_KEY)) {
            return Cache::get(self::ACCESS_TOKEN_KEY);
        }
        $accessToken = $this->requestToken();
        Cache::put(self::ACCESS_TOKEN_KEY, $accessToken, 360);

        return $accessToken;
    }

    /**
     * 请求AccessToken.
     *
     * @return string
     *
     * @throws Exception
     */
    public function requestToken()
    {
        $response = $this->client->post('/oauth/token', [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'username' => $this->username,
                'password' => $this->password,
                'scope' => '',
            ],
        ]);

        $body = json_decode($response->getBody(), true);
        $accessToken = $body['access_token'] ?? '';
        if (! $accessToken) {
            throw new Exception('access_token is empty');
        }

        return $accessToken;
    }

    /**
     * 我的插件.
     *
     * @return array
     *
     * @see https://www.yuque.com/meedu/meedu-cloud/tdvkzn
     */
    public function addons(): array
    {
        $response = $this->client->get('/api/addons');
        $body = json_decode($response->getBody(), true);

        return $body['data'] ?? [];
    }

    /**
     * 插件详情.
     *
     * @param string $sign
     *
     * @return array
     *
     * @see https://www.yuque.com/meedu/meedu-cloud/et4awh
     */
    public function addonsDetail(string $sign)
    {
        $response = $this->client->get('/api/addons/'.$sign);
        $body = json_decode($response->getBody(), true);

        return $body['data'] ?? [];
    }

    /**
     * 插件下载地址
     *
     * @param string $sign
     *
     * @see https://www.yuque.com/meedu/meedu-cloud/gdg4gw
     */
    public function addonsDownloadUrl(string $sign)
    {
        $response = $this->client->get('/api/addons/'.$sign.'/url');
        $body = json_decode($response->getBody(), true);

        return $body['data'] ?? '';
    }

    /**
     * 我的模板
     *
     * @return array
     *
     * @see https://www.yuque.com/meedu/meedu-cloud/ym1qxc
     */
    public function templates(): array
    {
        $response = $this->client->get('/api/templates');
        $body = json_decode($response->getBody(), true);

        return $body['data'] ?? [];
    }

    /**
     * 模板详情.
     *
     * @param string $sign
     *
     * @return array
     *
     * @see https://www.yuque.com/meedu/meedu-cloud/aruocg
     */
    public function templateDetail(string $sign)
    {
        $response = $this->client->get('/api/template/'.$sign);
        $body = json_decode($response->getBody(), true);

        return $body['data'] ?? [];
    }

    /**
     * 模板下载地址
     *
     * @param string $sign
     *
     * @see https://www.yuque.com/meedu/meedu-cloud/dtxz7k
     */
    public function templateDownloadUrl(string $sign)
    {
        $response = $this->client->get('/api/template/'.$sign.'/url');
        $body = json_decode($response->getBody(), true);

        return $body['data'] ?? '';
    }
}
