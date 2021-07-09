<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Hooks;

class HookContainer
{
    protected $hooks = [];

    protected static $instance = null;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * 埋点注册
     * @param $hook
     * @param $callback
     */
    public function register($hook, $callback): void
    {
        $hooks = $this->hooks[$hook] ?? [];

        if (is_array($callback)) {
            $hooks = array_merge($hooks, $callback);
        } else {
            $hooks[] = $callback;
        }

        $this->hooks[$hook] = $hooks;
    }

    /**
     * 获取已注册埋点
     * @param $hook
     * @return array
     */
    public function get($hook): array
    {
        return $this->hooks[$hook] ?? [];
    }
}
