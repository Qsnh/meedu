<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Backend\Api\V1\Traits;

use App\Services\Course\Models\CourseCategory;

trait CourseCategoryTrait
{
    public function getCourseCategoriesAndChildren(): array
    {
        $categories = CourseCategory::query()
            ->select(['id', 'name', 'sort'])
            ->where('parent_id', 0)
            ->orderBy('sort')
            ->get()
            ->toArray();

        if (!$categories) {
            return [];
        }

        $children = CourseCategory::query()
            ->select(['id', 'name', 'sort', 'parent_id'])
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
}
