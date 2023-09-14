<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Hooks;

use Illuminate\Support\Arr;

class HookParams
{
    protected $params = null;

    protected $response;

    public function __construct($params)
    {
        $this->params = $params;
    }

    public function setParams($params): void
    {
        $this->params = $params;
    }

    public function getParams()
    {
        return $this->params ?? null;
    }

    public function getValue($key, $default = null)
    {
        if (!is_array($this->params)) {
            return $this->params;
        }
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
