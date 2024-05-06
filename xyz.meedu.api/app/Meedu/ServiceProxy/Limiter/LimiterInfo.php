<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\ServiceProxy\Limiter;

class LimiterInfo
{
    protected $name;

    protected $maxTimes;

    protected $minutes;

    /**
     * LimiterInfo constructor.
     *
     * @param $name
     * @param $maxTimes
     * @param $minutes
     */
    public function __construct($name, $maxTimes, $minutes)
    {
        $this->name = $name;
        $this->maxTimes = $maxTimes;
        $this->minutes = $minutes;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getMaxTimes()
    {
        return $this->maxTimes;
    }

    /**
     * @param mixed $maxTimes
     */
    public function setMaxTimes($maxTimes): void
    {
        $this->maxTimes = $maxTimes;
    }

    /**
     * @return mixed
     */
    public function getMinutes()
    {
        return $this->minutes;
    }

    /**
     * @param mixed $minutes
     */
    public function setMinutes($minutes): void
    {
        $this->minutes = $minutes;
    }
}
