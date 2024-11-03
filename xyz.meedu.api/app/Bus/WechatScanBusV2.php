<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Bus;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class WechatScanBusV2
{

    public const TTL = 300;

    public function getLoginUrl(): array
    {
        $key = Str::random(20);
        Cache::put($this->cacheKey($key), 0, self::TTL);
        return [
            'url' => route('api.v3.wechat-scan-login.page', ['key' => $key]),
            'expire' => time() + self::TTL,
        ];
    }

    public function isValid(string $key): bool
    {
        return Cache::has($this->cacheKey($key));
    }

    public function setCode(string $key, string $code): void
    {
        Cache::put($this->cacheKey($key), $code, self::TTL);
    }

    public function code(string $key): string
    {
        return Cache::get($this->cacheKey($key)) ?? '';
    }

    private function cacheKey(string $key): string
    {
        return sprintf('wechat-scan-login:%s', $key);
    }

}
