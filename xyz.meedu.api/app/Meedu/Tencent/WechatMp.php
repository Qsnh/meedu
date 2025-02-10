<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Tencent;

use GuzzleHttp\Client;
use Illuminate\Support\Str;
use App\Meedu\ServiceV2\Services\ConfigServiceInterface;

class WechatMp
{
    protected $appId;
    protected $appSecret;
    protected $client;

    public function __construct(ConfigServiceInterface $configService)
    {
        $config = $configService->getWechatMpConfig();
        $this->appId = $config['app_id'];
        $this->appSecret = $config['app_secret'];
        $this->client = new Client(['timeout' => 5]);
    }

    /**
     * 生成基础授权URL(静默授权)
     * @param string $redirectUrl 回调地址
     * @param string $state 状态参数
     * @return string
     */
    public function getBaseAuthUrl(string $redirectUrl, string $state = ''): string
    {
        $state = $state ?: Str::random(10);
        $redirectUrl = urlencode($redirectUrl);
        return sprintf(
            'https://open.weixin.qq.com/connect/oauth2/authorize?appid=%s&redirect_uri=%s&response_type=code&scope=snsapi_base&state=%s#wechat_redirect',
            $this->appId,
            $redirectUrl,
            $state
        );
    }

    /**
     * 生成用户信息授权URL(非静默授权)
     * @param string $redirectUrl 回调地址
     * @param string $state 状态参数
     * @return string
     */
    public function getUserInfoAuthUrl(string $redirectUrl, string $state = ''): string
    {
        $state = $state ?: Str::random(10);
        $redirectUrl = urlencode($redirectUrl);
        return sprintf(
            'https://open.weixin.qq.com/connect/oauth2/authorize?appid=%s&redirect_uri=%s&response_type=code&scope=snsapi_userinfo&state=%s#wechat_redirect',
            $this->appId,
            $redirectUrl,
            $state
        );
    }

    /**
     * 通过code获取access_token
     * @param string $code
     * @return array
     * @throws \Exception
     */
    public function getAccessToken(string $code): array
    {
        $url = sprintf(
            'https://api.weixin.qq.com/sns/oauth2/access_token?appid=%s&secret=%s&code=%s&grant_type=authorization_code',
            $this->appId,
            $this->appSecret,
            $code
        );

        $response = $this->client->get($url);
        $data = json_decode($response->getBody()->getContents(), true);
        if (isset($data['errcode'])) {
            throw new \Exception($data['errmsg'] ?? '获取access_token失败');
        }
        return $data;
    }

    /**
     * 获取用户信息
     * @param string $accessToken
     * @param string $openid
     * @return array
     * @throws \Exception
     */
    public function getUserInfo(string $accessToken, string $openid): array
    {
        $url = sprintf(
            'https://api.weixin.qq.com/sns/userinfo?access_token=%s&openid=%s&lang=zh_CN',
            $accessToken,
            $openid
        );

        $response = $this->client->get($url);
        $data = json_decode($response->getBody()->getContents(), true);
        if (isset($data['errcode'])) {
            throw new \Exception($data['errmsg'] ?? '获取用户信息失败');
        }
        return $data;
    }

    /**
     * 获取微信公众号全局access_token
     * @return string
     * @throws \Exception
     */
    public function getGlobalAccessToken(): string
    {
        $cacheKey = sprintf('wechat:mp:global_access_token:%s', $this->appId);
        return cache()->remember($cacheKey, 30 * 60, function () {
            $url = sprintf(
                'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=%s&secret=%s',
                $this->appId,
                $this->appSecret
            );

            $response = $this->client->get($url);
            $data = json_decode($response->getBody()->getContents(), true);
            if (isset($data['errcode'])) {
                throw new \Exception($data['errmsg'] ?? '获取access_token失败');
            }
            return $data['access_token'];
        });
    }

    /**
     * 获取jsapi_ticket
     * @return string
     * @throws \Exception
     */
    public function getJsapiTicket(): string
    {
        $cacheKey = sprintf('wechat:mp:jsapi_ticket:%s', $this->appId);
        return cache()->remember($cacheKey, 7200, function () {
            $accessToken = $this->getGlobalAccessToken();

            $url = sprintf(
                'https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=%s&type=jsapi',
                $accessToken
            );

            $response = $this->client->get($url);
            $data = json_decode($response->getBody()->getContents(), true);
            if ($data['errcode'] !== 0) {
                throw new \Exception($data['errmsg'] ?? '获取jsapi_ticket失败');
            }
            return $data['ticket'];
        });
    }

    /**
     * 生成JSSDK配置
     * @param string $url 当前网页的URL，不包含#及其后面部分
     * @param array $jsApiList 需要使用的JS接口列表
     * @param bool $debug 是否开启调试模式
     * @param bool $beta 是否开启beta版
     * @param bool $json 是否返回json
     * @param array $openTagList 开放标签列表
     * @return array|string
     * @throws \Exception
     */
    public function buildJsConfig(
        string $url,
        array  $jsApiList = [],
        bool   $debug = false,
        bool   $beta = false,
        bool   $json = false,
        array  $openTagList = []
    ): array {
        $ticket = $this->getJsapiTicket();
        $timestamp = time();
        $nonceStr = Str::random(15);

        // 这里参数的顺序要按照字典序排序
        $string = "jsapi_ticket=$ticket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
        $signature = sha1($string);

        $config = [
            'appId' => $this->appId,
            'nonceStr' => $nonceStr,
            'timestamp' => $timestamp,
            'signature' => $signature,
            'jsApiList' => $jsApiList,
            'debug' => $debug,
            'beta' => $beta,
            'openTagList' => $openTagList,
        ];

        return $json ? json_encode($config) : $config;
    }
}
