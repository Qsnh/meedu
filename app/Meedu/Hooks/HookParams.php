<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Hooks;

use Illuminate\Support\Arr;

class HookParams
{
    protected $params = null;

    protected $response;

    public function __construct(array $params)
    {
        $this->params = $params;
    }

    public function setParams(array $params): void
    {
        $this->params = $params;
    }

    public function getParams(): array
    {
        return $this->params ?? [];
    }

    public function getValue($key, $default = null)
    {
        return Arr::get($this->params ?? [], $key, $default);
    }

    public function setResponse($response): void
    {
        $this->response = $response;
    }

    public function getResponse()
    {
        return $this->response;
    }
}
