<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Services\Other\Interfaces;

interface NavServiceInterface
{
    public function all($platform = ''): array;
}
