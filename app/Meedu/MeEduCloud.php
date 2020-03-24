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

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class MeEduCloud
{
    protected $domain;

    protected $userId;

    protected $password;

    protected $client;

    public function __construct($domain, $userId, $password)
    {
        $this->domain = $domain;
        $this->userId = $userId;
        $this->password = $password;
        $this->client = new Client([
            'base_uri' => $this->domain,
            'timeout' => 5.0,
        ]);
    }

    public function version()
    {
        $uri = '/api/v1/version';
        return $this->get($uri);
    }

    /**
     * 插件
     * @param int $page
     * @param int $pageSize
     * @return mixed
     * @throws \Exception
     */
    public function addons($page = 1, $pageSize = 10)
    {
        $uri = sprintf('/api/v1/addons?page=%d&page_size=%d', $page, $pageSize);
        $res = $this->get($uri);
        return $res['list'];
    }

    /**
     * @param $addonsId
     * @param $versionId
     * @return mixed
     * @throws \Exception
     */
    public function addonsDownloadUrl($addonsId, $versionId)
    {
        $uri = sprintf('/api/v1/addons/%d/%d/downloadUrl', $addonsId, $versionId);
        $url = $this->get($uri, true);
        return $url . '&token=' . $this->getAccessToken();
    }

    /**
     * 插件购买
     * @param $addonsId
     * @return mixed
     * @throws \Exception
     */
    public function addonsBuy($addonsId)
    {
        $uri = sprintf('/api/v1/addons/%d/buy', $addonsId);
        return $this->get($uri, true);
    }

    /**
     * 用户信息
     * @return mixed
     * @throws \Exception
     */
    public function user()
    {
        $uri = '/api/v1/user';
        return $this->get($uri, true);
    }

    /**
     * 我的插件
     * @return mixed
     * @throws \Exception
     */
    public function userAddons()
    {
        $uri = '/api/v1/user/addons';
        return $this->get($uri, true);
    }

    public function getAccessToken()
    {
        $key = 'mc:at';
        if (Cache::has($key)) {
            return Cache::pull($key);
        }
        $token = $this->requestAccessToken();
        Cache::put($key, $token, 3600);
        return $token;
    }

    public function requestAccessToken()
    {
        $uri = sprintf('/api/v1/login?id=%d&password=%s', $this->userId, $this->password);
        $data = $this->get($uri);
        return $data['token'];
    }

    protected function get($url, $needToken = false)
    {
        $token = '';
        if ($needToken) {
            $token = $this->getAccessToken();
        }
        $res = $this->client->get($url, [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ],
        ]);
        if ($res->getStatusCode() !== 200) {
            throw new \Exception('http error code:' . $res->getStatusCode());
        }
        $body = json_decode($res->getBody()->getContents(), true);
        if ($body['code'] !== 0) {
            throw new \Exception($body['message'] ?? '');
        }
        return $body['data'] ?? '';
    }
}
