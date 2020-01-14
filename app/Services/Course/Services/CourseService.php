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

use App\Services\Course\Models\Course;
use App\Services\Course\Models\CourseChapter;
use App\Services\Base\Interfaces\ConfigServiceInterface;
use App\Services\Course\Interfaces\CourseServiceInterface;

class CourseService implements CourseServiceInterface
{
    protected $configService;

    public function __construct(ConfigServiceInterface $configService)
    {
        $this->configService = $configService;
    }

    /**
     * @param int $page
     * @param int $pageSize
     * @param int $categoryId
     * @return array
     */
    public function simplePage(int $page, int $pageSize, int $categoryId = 0): array
    {
        $query = Course::with(['category'])
            ->show()->published()
            ->withCount(['videos' => function ($query) {
                $query->show()->published();
            }])
            ->when($categoryId, function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            })->orderByDesc('published_at');
        $total = $query->count();
        $list = $query->forPage($page, $pageSize)->get()->toArray();

        return compact('list', 'total');
    }

    /**
     * @param int $id
     *
     * @return array
     */
    public function find(int $id): array
    {
        $course = Course::show()->published()->findOrFail($id);

        return $course->toArray();
    }

    /**
     * @param int $courseId
     *
     * @return array
     */
    public function chapters(int $courseId): array
    {
        return CourseChapter::whereCourseId($courseId)->orderBy('sort')->get()->toArray();
    }

    /**
     * @param int $limit
     *
     * @return array
     */
    public function getLatestCourses(int $limit): array
    {
        return Course::withCount(['videos' => function ($query) {
            $query->show()->published();
        }])
            ->with(['category'])
            ->show()
            ->published()
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
        return Course::show()->published()->whereIn('id', $ids)->orderByDesc('published_at')->get()->toArray();
    }
}
