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

use App\Services\Course\Models\CourseCategory;
use App\Services\Course\Interfaces\CourseCategoryServiceInterface;

class CourseCategoryService implements CourseCategoryServiceInterface
{

    /**
     * @return array
     */
    public function all(): array
    {
        return CourseCategory::show()->sort()->get()->toArray();
    }

    /**
     * @param int $id
     * @return array
     */
    public function findOrFail(int $id): array
    {
        return CourseCategory::findOrFail($id)->toArray();
    }
}
