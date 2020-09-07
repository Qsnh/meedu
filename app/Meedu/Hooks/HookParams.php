<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
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
