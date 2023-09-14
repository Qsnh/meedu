<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Services\Other\Services;

use App\Services\Other\Models\Link;
use App\Services\Other\Interfaces\LinkServiceInterface;

class LinkService implements LinkServiceInterface
{
    public function all(): array
    {
        return Link::query()->orderBy('sort')->get()->toArray();
    }
}
