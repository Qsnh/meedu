<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\ServiceV2\Dao;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use App\Constant\BusConstant;
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

    public function findOrFail(int $id): array
    {
        return Course::query()->where('id', $id)->firstOrFail()->toArray();
    }

    public function find(int $id): array
    {
        $record = Course::query()->where('id', $id)->first();
        return $record ? $record->toArray() : [];
    }


    public function videoPaginate(int $page, int $size, array $fields, array $orderBy, array $params, array $with, array $withCount): array
    {
        $filterBlacklist = Arr::except($params, ['lte_published_at', 'is_show']);
        if ($filterBlacklist) {
            throw new \Exception(__('不支持参数 :params 过滤', ['params' => implode(',', array_keys($filterBlacklist))]));
        }

        $query = CourseVideo::query()
            ->select($fields)
            ->when(isset($params['is_show']), function ($query) use ($params) {
                $query->where('is_show', $params['is_show']);
            })
            ->when(isset($params['lte_published_at']), function ($query) use ($params) {
                $query->where('published_at', '<=', $params['lte_published_at']);
            });

        $total = $query->count();
        $data = $query
            ->with($with)
            ->withCount($withCount)
            ->orderBy($orderBy[0], $orderBy[1])
            ->forPage($page, $size)
            ->get()
            ->toArray();

        return compact('total', 'data');
    }

    public function paginate(int $page, int $size, array $fields, array $orderBy, array $params, array $with, array $withCount): array
    {
        $filterBlacklist = Arr::except($params, ['lte_published_at', 'is_show']);
        if ($filterBlacklist) {
            throw new \Exception(__('不支持参数 :params 过滤', ['params' => implode(',', array_keys($filterBlacklist))]));
        }

        $query = Course::query()
            ->select($fields)
            ->when(isset($params['is_show']), function ($query) use ($params) {
                $query->where('is_show', $params['is_show']);
            })
            ->when(isset($params['lte_published_at']), function ($query) use ($params) {
                $query->where('published_at', '<=', $params['lte_published_at']);
            });

        $total = $query->count();
        $data = $query
            ->with($with)
            ->withCount($withCount)
            ->orderBy($orderBy[0], $orderBy[1])
            ->forPage($page, $size)
            ->get()
            ->toArray();

        return compact('total', 'data');
    }

    public function findVideo(int $id): array
    {
        $record = CourseVideo::query()->where('id', $id)->first();
        return $record ? $record->toArray() : [];
    }

    public function getVideosByCourseId(int $id, array $fields): array
    {
        return CourseVideo::query()->select($fields)->where('course_id', $id)->get()->toArray();
    }

    public function getPublishedUnIndexedCourses(array $fields): array
    {
        return Course::query()
            ->select($fields)
            ->where('published_at', '<=', Carbon::now()->toDateTimeLocalString())
            ->where('is_show', 1)
            ->whereNotExists(function ($query) {
                $query->select('id')
                    ->from('search_records')
                    ->whereColumn('resource_id', 'courses.id')
                    ->where('resource_type', BusConstant::FULL_SEARCH_RESOURCE_TYPE_VOD_COURSE);
            })
            ->get()
            ->toArray();
    }

    public function getPublishedUnIndexedVideos(array $fields): array
    {
        return CourseVideo::query()
            ->select($fields)
            ->where('published_at', '<=', Carbon::now()->toDateTimeLocalString())
            ->where('is_show', 1)
            ->whereNotExists(function ($query) {
                $query->select('id')
                    ->from('search_records')
                    ->whereColumn('resource_id', 'videos.id')
                    ->where('resource_type', BusConstant::FULL_SEARCH_RESOURCE_TYPE_VOD_COURSE_VIDEO);
            })
            ->get()
            ->toArray();
    }
}
