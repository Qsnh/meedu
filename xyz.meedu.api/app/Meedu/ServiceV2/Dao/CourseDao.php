<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\ServiceV2\Dao;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use App\Meedu\ServiceV2\Models\Course;
use App\Meedu\ServiceV2\Models\CourseVideo;
use App\Meedu\ServiceV2\Models\CourseAttach;
use App\Meedu\ServiceV2\Models\CourseCategory;
use App\Meedu\ServiceV2\Models\CourseAttachDownloadRecord;

class CourseDao implements CourseDaoInterface
{
    public function chunk(array $ids, array $fields, array $params, array $with, array $withCount): array
    {
        return Course::query()
            ->select($fields)
            ->with($with)
            ->withCount($withCount)
            ->whereIn('id', $ids)
            ->when($params, function ($query) use ($params) {
                if (isset($params['category_id'])) {
                    $ids = [$params['category_id']];
                    $childrenIds = CourseCategory::query()
                        ->select(['id'])
                        ->where('parent_id', $params['category_id'])
                        ->get()
                        ->pluck('id')
                        ->toArray();
                    $childrenIds && $ids = array_merge($ids, $childrenIds);
                    $query->whereIn('category_id', $ids);
                }
                if (isset($params['lte_published_at'])) {
                    $query->where('published_at', '<=', $params['lte_published_at']);
                }
                if (isset($params['is_show'])) {
                    $query->where('is_show', $params['is_show']);
                }
                if (isset($params['charge'])) {
                    $query->where('charge', $params['charge']);
                }
            })
            ->get()
            ->toArray();
    }

    public function videoChunk(array $ids, array $fields, array $params, array $with, array $withCount): array
    {
        return CourseVideo::query()
            ->select($fields)
            ->with($with)
            ->withCount($withCount)
            ->whereIn('id', $ids)
            ->when($params, function ($query) use ($params) {
                if (isset($params['lte_published_at'])) {
                    $query->where('published_at', '<=', $params['lte_published_at']);
                }
                if (isset($params['is_show'])) {
                    $query->where('is_show', $params['is_show']);
                }
                if (isset($params['charge'])) {
                    $query->where('charge', $params['charge']);
                }
            })
            ->get()
            ->toArray();
    }

    public function getCoursePublishedVideoIds(int $courseId): array
    {
        return CourseVideo::query()
            ->where('course_id', $courseId)
            ->select(['id'])
            ->where('published_at', '<=', Carbon::now())
            ->where('is_show', 1)
            ->get()
            ->pluck('id')
            ->toArray();
    }

    public function attachFind(array $array): array
    {
        $data = Arr::only($array, ['id', 'course_id']);
        if (!$data) {
            throw new \Exception('attachFind的过滤条件为空');
        }
        $record = CourseAttach::query()
            ->when(isset($data['id']), function ($query) use ($data) {
                $query->where('id', $data['id']);
            })
            ->when(isset($data['course_id']), function ($query) use ($data) {
                $query->where('course_id', $data['course_id']);
            })
            ->first();
        return $record ? $record->toArray() : [];
    }

    public function attachIncDownloadTimes(int $attachId): int
    {
        return CourseAttach::query()->where('id', $attachId)->increment('download_times');
    }

    public function storeCourseAttachDownloadRecord(int $userId, int $courseId, int $attachId, array $extra): int
    {
        $data = array_merge($extra ?? [], [
            'user_id' => $userId,
            'course_id' => $courseId,
            'attach_id' => $attachId,
        ]);
        $record = new CourseAttachDownloadRecord();
        $record->fill($data)->save();
        return $record['id'];
    }

}
