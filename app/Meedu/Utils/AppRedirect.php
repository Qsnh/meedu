<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Utils;

use Illuminate\Support\Facades\Log;
use App\Exceptions\ServiceException;

class AppRedirect
{
    protected $baseUrl;
    protected $params;
    protected $expiredTime;

    public function __construct(string $baseUrl = '', array $params = [], int $expiredTime = 600)
    {
        $this->baseUrl = $baseUrl;
        $this->params = $params;
        $this->expiredTime = $expiredTime;
    }

    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function push(string $key, $value): void
    {
        $this->params[$key] = $value;
    }

    public function encryptData(): string
    {
        $data = array_merge($this->params, ['expired_time' => time() + $this->expiredTime]);
        return encrypt($data);
    }

    public function getRedirectUrl(): string
    {
        return url_append_query($this->baseUrl, ['data' => $this->encryptData()]);
    }

    public function decrypt($data)
    {
        try {
            $data = decrypt($data);

            if (!isset($data['expired_time'])) {
                throw new ServiceException(__('已过期'));
            }

            if ($data['expired_time'] < time()) {
                throw new ServiceException(__('已过期'));
            }

            return $data;
        } catch (\Exception $e) {
            Log::error(__METHOD__, ['message' => $e->getMessage(), 'data' => $data]);
            return false;
        }
    }
}
