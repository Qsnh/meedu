<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Services\Other\Services;

use App\Services\Other\Models\Announcement;
use App\Services\Other\Interfaces\AnnouncementServiceInterface;

class AnnouncementService implements AnnouncementServiceInterface
{
    public function latest(): array
    {
        $a = Announcement::query()->latest()->first();

        return $a ? $a->toArray() : [];
    }

    /**
     * @param int $id
     * @return array
     */
    public function findOrFail(int $id): array
    {
        $a = Announcement::findOrFail($id);
        return $a->toArray();
    }

    /**
     * @param int $id
     */
    public function viewTimesInc(int $id): void
    {
        Announcement::whereId($id)->increment('view_times');
    }
}
