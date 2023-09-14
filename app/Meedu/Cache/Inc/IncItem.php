<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Cache\Inc;

abstract class IncItem
{
    protected $inc = 1;
    protected $limit = 100;

    /**
     * @return int
     */
    public function getInc(): int
    {
        return $this->inc;
    }

    /**
     * @param int $inc
     */
    public function setInc(int $inc): void
    {
        $this->inc = $inc;
    }

    /**
     * @param int $limit
     */
    public function setLimit(int $limit): void
    {
        $this->limit = $limit;
    }


    public function getKey(): string
    {
    }

    public function save(): void
    {
    }

    public function getLimit(): int
    {
        return $this->limit;
    }
}
