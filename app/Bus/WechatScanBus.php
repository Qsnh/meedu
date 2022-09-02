<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Bus;

use Illuminate\Support\Str;
use App\Constant\CacheConstant;
use Illuminate\Support\Facades\Cache;

class WechatScanBus
{
    const LOGIN_PREFIX = 'scan_v2_';
    const BIND_PREFIX = 'bind_v2_';

    /**
     * 获取登录随机code
     *
     * @return string
     */
    public function generateLoginCode(): string
    {
        return self::LOGIN_PREFIX . Str::random(10);
    }

    /**
     * 判断是否登录code
     *
     * @param string $code
     * @return bool
     */
    public function isLoginAction(string $code): bool
    {
        return Str::startsWith($code, self::LOGIN_PREFIX);
    }

    /**
     * 获取绑定随机code
     *
     * @param string $userId
     * @return string
     */
    public function generateBindCode(string $userId): string
    {
        return self::BIND_PREFIX . $userId;
    }

    /**
     * @param string $code
     * @return int
     */
    public function bindUserId(string $code): int
    {
        return (int)str_replace(self::BIND_PREFIX, '', $code);
    }

    /**
     * 判断是否绑定code
     * @param string $code
     * @return bool
     */
    public function isBindAction(string $code): bool
    {
        return Str::startsWith($code, self::BIND_PREFIX);
    }

    /**
     * 设置登录的userId
     *
     * @param string $code
     * @param int $userId
     * @return void
     */
    public function setLoginUserId(string $code, int $userId): void
    {
        $cacheKey = get_cache_key(CacheConstant::WECHAT_SCAN['name'], $code);
        Cache::put($cacheKey, $userId, CacheConstant::WECHAT_SCAN['expire']);
    }

    /**
     * 获取登录后的userId
     *
     * @param string $code
     * @return int
     */
    public function getLoginUserId(string $code): int
    {
        $cacheKey = get_cache_key(CacheConstant::WECHAT_SCAN['name'], $code);
        return (int)Cache::get($cacheKey);
    }

    /**
     * @param string $code
     * @param $data
     * @return void
     */
    public function setLoginUser(string $code, $data): void
    {
        $cacheKey = get_cache_key(CacheConstant::WECHAT_SCAN_USER['name'], $code);
        Cache::put($cacheKey, $data, CacheConstant::WECHAT_SCAN_USER['expire']);
    }

    /**
     * @param string $code
     * @return mixed
     */
    public function getLoginUser(string $code)
    {
        $cacheKey = get_cache_key(CacheConstant::WECHAT_SCAN_USER['name'], $code);
        return Cache::get($cacheKey);
    }

    /**
     * @param string $code
     * @return void
     */
    public function delLoginUser(string $code): void
    {
        $cacheKey = get_cache_key(CacheConstant::WECHAT_SCAN_USER['name'], $code);
        Cache::forget($cacheKey);
    }
}
