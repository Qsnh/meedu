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
        return CourseCategory::query()
            ->select([
                'id', 'sort', 'name', 'parent_id', 'is_show',
            ])
            ->with(['children:id,sort,name,parent_id,is_show'])
            ->where('parent_id', 0)
            ->where('is_show', 1)
            ->orderBy('sort')
            ->get()
            ->toArray();
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
