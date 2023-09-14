<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
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
     * @param $page
     * @param $size
     * @return array
     */
    public function paginate($page, $size): array
    {
        $data = Announcement::query()
            ->orderByDesc('id')
            ->paginate(
                $size,
                ['id', 'announcement', 'created_at', 'view_times', 'title'],
                null,
                $page
            );

        return [
            'data' => $data->items(),
            'total' => $data->total(),
        ];
    }

    /**
     * @param int $id
     * @return array
     */
    public function findOrFail(int $id): array
    {
        $a = Announcement::query()->where('id', $id)->firstOrFail();
        return $a->toArray();
    }

    /**
     * @param int $id
     */
    public function viewTimesInc(int $id): void
    {
        Announcement::query()->where('id', $id)->increment('view_times');
    }
}
