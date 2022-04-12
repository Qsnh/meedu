<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Services\Course\Services;

use Carbon\Carbon;
use App\Services\Course\Models\Video;
use App\Services\Course\Models\MediaVideo;
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
            ->where('is_show', 1)
            ->where('published_at', '<=', Carbon::now())
            ->where('course_id', $courseId)
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
        $query = Video::query()
            ->with(['course'])
            ->where('is_show', 1)
            ->where('published_at', '<=', Carbon::now())
            ->orderByDesc('published_at');

        $total = $query->count();
        $list = $query->forPage($page, $pageSize)->get()->toArray();

        return compact('total', 'list');
    }

    /**
     * @param int $id
     * @param array $with
     *
     * @return mixed
     */
    public function findOrNull(int $id, $with = [])
    {
        $video = Video::query()
            ->with($with)
            ->where('id', $id)
            ->where('is_show', 1)
            ->where('published_at', '<=', Carbon::now())
            ->first();
        return $video ?: null;
    }

    /**
     * @param int $id
     *
     * @return array
     */
    public function find(int $id): array
    {
        return Video::query()
            ->with(['course'])
            ->where('is_show', 1)
            ->where('published_at', '<=', Carbon::now())
            ->findOrFail($id)
            ->toArray();
    }

    /**
     * @param int $limit
     *
     * @return array
     */
    public function getLatestVideos(int $limit): array
    {
        return Video::query()
            ->with(['course'])
            ->where('is_show', 1)
            ->where('published_at', '<=', Carbon::now())
            ->orderByDesc('published_at')
            ->limit($limit)
            ->get()
            ->toArray();
    }

    /**
     * @param array $ids
     *
     * @return array
     */
    public function getList(array $ids): array
    {
        return Video::query()
            ->with(['course'])
            ->whereIn('id', $ids)
            ->where('is_show', 1)
            ->where('published_at', '<=', Carbon::now())
            ->orderByDesc('published_at')
            ->get()
            ->toArray();
    }

    /**
     * @param array $courseIds
     * @return array
     */
    public function getCourseList(array $courseIds): array
    {
        return Video::query()
            ->where('is_show', 1)
            ->where('published_at', '<=', Carbon::now())
            ->orderByDesc('published_at')
            ->whereIn('course_id', $courseIds)
            ->get()
            ->toArray();
    }

    /**
     * @param int $videoId
     * @param int $num
     */
    public function viewNumIncrement(int $videoId, int $num): void
    {
        Video::query()->where('id', $videoId)->increment('view_num', $num);
    }

    /**
     * @param string $fileId
     * @param string $service
     * @return array
     */
    public function findOpenVideo(string $fileId, string $service): array
    {
        $mediaVideo = MediaVideo::query()
            ->where('storage_file_id', $fileId)
            ->where('storage_driver', $service)
            ->where('is_open', 1)
            ->first();

        return $mediaVideo ? $mediaVideo->toArray() : [];
    }
}
