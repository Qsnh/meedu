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

use App\Constant\FrontendConstant;
use App\Services\Course\Models\Course;
use App\Services\Base\Services\ConfigService;
use App\Services\Course\Models\CourseChapter;
use App\Services\Course\Models\CourseUserRecord;
use App\Services\Base\Interfaces\ConfigServiceInterface;
use App\Services\Course\Interfaces\VideoServiceInterface;
use App\Services\Course\Interfaces\CourseServiceInterface;

class CourseService implements CourseServiceInterface
{
    /**
     * @var ConfigService
     */
    protected $configService;

    public function __construct(ConfigServiceInterface $configService)
    {
        $this->configService = $configService;
    }

    /**
     * @param string $keyword
     * @param int $limit
     *
     * @return array
     */
    public function titleSearch(string $keyword, int $limit): array
    {
        return Course::show()
            ->published()
            ->with(['category'])
            ->withCount(['videos' => function ($query) {
                $query->show()->published();
            }])
            ->where('title', 'like', '%' . $keyword . '%')
            ->orderByDesc('published_at')
            ->limit($limit)->get()->toArray();
    }

    /**
     * @param int $page
     * @param int $pageSize
     * @param int $categoryId
     * @param string $scene
     * @return array
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function simplePage(int $page, int $pageSize, int $categoryId = 0, string $scene = ''): array
    {
        $query = Course::with(['category'])
            ->show()->published()
            ->withCount(['videos' => function ($query) {
                $query->show()->published();
            }])
            ->when($categoryId, function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            });
        if (!$scene) {
            $query->orderByDesc('published_at');
        } elseif ($scene == 'sub') {
            $query->orderByDesc('user_count');
        } elseif ($scene == 'recom') {
            $query->whereIsRec(FrontendConstant::YES)->orderByDesc('id');
        }
        $total = $query->count();
        $list = $query->forPage($page, $pageSize)->get()->toArray();
        $list = $this->addLatestVideos($list);

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
        $courses = Course::withCount(['videos' => function ($query) {
            $query->show()->published();
        }])
            ->with(['category'])
            ->show()
            ->published()
            ->orderByDesc('published_at')
            ->limit($limit)
            ->get()
            ->toArray();
        return $this->addLatestVideos($courses);
    }

    /**
     * @param int $limit
     * @return array
     */
    public function getRecCourses(int $limit): array
    {
        $courses = Course::withCount(['videos' => function ($query) {
            $query->show()->published();
        }])
            ->with(['category'])
            ->show()
            ->published()
            ->recommend()
            ->orderByDesc('published_at')
            ->limit($limit)
            ->get()
            ->toArray();
        return $this->addLatestVideos($courses);
    }

    /**
     * @param array $ids
     *
     * @return array
     */
    public function getList(array $ids): array
    {
        return Course::with(['category'])
            ->withCount(['videos'])
            ->show()->published()
            ->whereIn('id', $ids)->orderByDesc('published_at')->get()->toArray();
    }

    /**
     * 为课程列表中的每个课程增加3条最近的video
     *
     * @param array $list
     * @return array
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function addLatestVideos(array $list): array
    {
        /**
         * @var $videoService VideoService
         */
        $videoService = app()->make(VideoServiceInterface::class);
        $videos = collect($videoService->getCourseList(array_column($list, 'id')))->groupBy('course_id');
        $list = array_map(function ($item) use ($videos) {
            $item['videos'] = isset($videos[$item['id']]) ? $videos[$item['id']]->take(3)->toArray() : [];
            return $item;
        }, $list);
        return $list;
    }

    /**
     * @param int $userId
     * @param int $courseId
     */
    public function recordUserCount(int $userId, int $courseId): void
    {
        $userCourseRecord = CourseUserRecord::whereUserId($userId)->whereCourseId($courseId)->exists();
        if ($userCourseRecord) {
            return;
        }
        CourseUserRecord::create(['user_id' => $userId, 'course_id' => $courseId]);
        Course::whereId($courseId)->increment('user_count', 1);
    }

    /**
     * @param int $userId
     * @param int $page
     * @param int $pageSize
     * @return array
     */
    public function userLearningCoursesPaginate(int $userId, int $page, int $pageSize): array
    {
        $query = CourseUserRecord::whereUserId($userId)->orderByDesc('id')->forPage($page, $pageSize);

        $total = $query->count();
        $list = $query->get()->toArray();

        return compact('list', 'total');
    }
}
