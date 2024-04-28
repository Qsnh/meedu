<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Cache;

class MemoryCache
{
    private static $instance = null;
    private $bucket;

    private function __construct()
    {
        $this->bucket = [];
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function set($key, $val, $force = false)
    {
        if (isset($this->bucket[$key]) && $force === false) {
            throw new \Exception(sprintf('The key[%s] has exists', $key));
        }
        $this->bucket[$key] = $val;
    }

    public function get($key, $default = null)
    {
        return $this->bucket[$key] ?? $default;
    }

    public function exists($key): bool
    {
        return isset($this->bucket[$key]);
    }
}
