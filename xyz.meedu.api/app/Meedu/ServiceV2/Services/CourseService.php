<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\ServiceV2\Services;

use App\Meedu\ServiceV2\Dao\CourseDaoInterface;

class CourseService implements CourseServiceInterface
{
    protected $courseDao;

    public function __construct(CourseDaoInterface $courseDao)
    {
        $this->courseDao = $courseDao;
    }

    public function chunk(array $ids, array $fields, array $params, array $with, array $withCount): array
    {
        return $this->courseDao->chunk($ids, $fields, $params, $with, $withCount);
    }

    public function videoChunk(array $ids, array $fields, array $params, array $with, array $withCount): array
    {
        return $this->courseDao->videoChunk($ids, $fields, $params, $with, $withCount);
    }

    public function getCoursePublishedVideos(int $courseId, array $fields): array
    {
        $videoIds = $this->courseDao->getCoursePublishedVideoIds($courseId);
        return $this->courseDao->videoChunk($videoIds, $fields, [], [], []);
    }
}
