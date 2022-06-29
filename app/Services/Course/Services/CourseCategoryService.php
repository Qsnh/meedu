<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Services\Course\Services;

use App\Services\Course\Models\CourseCategory;
use App\Services\Course\Interfaces\CourseCategoryServiceInterface;

class CourseCategoryService implements CourseCategoryServiceInterface
{

    /**
     * @return array
     */
    public function all(): array
    {
        $categories = CourseCategory::query()
            ->select(['id', 'sort', 'name', 'parent_id'])
            ->where('parent_id', 0)
            ->orderBy('sort')
            ->get()
            ->toArray();

        if (!$categories) {
            return [];
        }

        $children = CourseCategory::query()
            ->select(['id', 'sort', 'name', 'parent_id'])
            ->whereIn('parent_id', array_column($categories, 'id'))
            ->orderBy('sort')
            ->get()
            ->groupBy('parent_id')
            ->toArray();

        foreach ($categories as $key => $category) {
            $categories[$key]['children'] = $children[$category['id']] ?? [];
        }

        return $categories;
    }

    /**
     * @param int $id
     * @return array
     */
    public function findOrFail(int $id): array
    {
        return CourseCategory::query()->where('id', $id)->firstOrFail()->toArray();
    }
}
