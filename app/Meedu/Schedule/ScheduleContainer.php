<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Schedule;

use Illuminate\Console\Scheduling\Schedule;

class ScheduleContainer
{
    protected $table = [];

    /**
     * @var ScheduleContainer
     */
    private static $instance = null;

    private function __construct()
    {
    }

    public static function instance()
    {
        if (!self::$instance) {
            static::$instance = new self();
        }
        return self::$instance;
    }

    public function register(callable $call)
    {
        $this->table[] = $call;
    }

    public function exec(Schedule $schedule)
    {
        if (!$this->table) {
            return;
        }
        foreach ($this->table as $call) {
            tap($schedule, $call);
        }
    }
}
