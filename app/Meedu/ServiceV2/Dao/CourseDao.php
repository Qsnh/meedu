<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\ServiceV2\Dao;

use App\Meedu\ServiceV2\Models\Course;
use App\Meedu\ServiceV2\Models\CourseCategory;

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
}
