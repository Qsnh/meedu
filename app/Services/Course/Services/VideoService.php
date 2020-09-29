<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Services\Course\Services;

use App\Services\Course\Models\Video;
use App\Services\Course\Interfaces\VideoServiceInterface;

class VideoService implements VideoServiceInterface
{
    /**
     * @param int $courseId
     *
     * @return array
     */
    public function courseVideos(int $courseId): array
    {
        return Video::with(['chapter'])
            ->show()
            ->published()
            ->whereCourseId($courseId)
            ->orderBy('published_at')
            ->get()
            ->groupBy(function ($item) {
                return $item->chapter ? $item->chapter->id : 0;
            })
            ->toArray();
    }

    /**
     * @param int $page
     * @param int $pageSize
     *
     * @return array
     */
    public function simplePage(int $page, int $pageSize): array
    {
        $query = Video::with(['course'])->show()->published()->orderByDesc('published_at');
        $total = $query->count();
        $list = $query->forPage($page, $pageSize)->get()->toArray();

        return compact('total', 'list');
    }

    /**
     * @param int $id
     *
     * @return array
     */
    public function find(int $id): array
    {
        return Video::with(['course'])->show()->published()->findOrFail($id)->toArray();
    }

    /**
     * @param int $limit
     *
     * @return array
     */
    public function getLatestVideos(int $limit): array
    {
        return Video::with(['course'])->show()->published()->orderByDesc('published_at')->limit($limit)->get()->toArray();
    }

    /**
     * @param array $ids
     *
     * @return array
     */
    public function getList(array $ids): array
    {
        return Video::with(['course'])->whereIn('id', $ids)->show()->published()->orderByDesc('published_at')->get()->toArray();
    }

    /**
     * @param array $courseIds
     * @return array
     */
    public function getCourseList(array $courseIds): array
    {
        return Video::show()->published()->orderByDesc('published_at')->whereIn('course_id', $courseIds)->get()->toArray();
    }

    /**
     * @param int $videoId
     * @param int $num
     */
    public function viewNumIncrement(int $videoId, int $num): void
    {
        Video::query()->where('id', $videoId)->increment('view_num', $num);
    }
}
