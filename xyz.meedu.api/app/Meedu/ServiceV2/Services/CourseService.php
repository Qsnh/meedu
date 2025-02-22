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

    public function findAttachByIdAndCourseId(int $attachId, int $courseId): array
    {
        return $this->courseDao->attachFind(['id' => $attachId, 'course_id' => $courseId]);
    }

    public function findAttachById(int $id): array
    {
        return $this->courseDao->attachFind(['id' => $id]);
    }

    public function attachDownload(int $userId, int $courseId, int $attachId, array $data): void
    {
        $this->courseDao->storeCourseAttachDownloadRecord($userId, $courseId, $attachId, $data);
        $this->courseDao->attachIncDownloadTimes($attachId);
    }

    public function findOrFail(int $id): array
    {
        return $this->courseDao->findOrFail($id);
    }

    public function find(int $id): array
    {
        return $this->courseDao->find($id);
    }


    public function videoPaginate(int $page, int $size, array $fields, array $orderBy, array $params, array $with, array $withCount): array
    {
        return $this->courseDao->videoPaginate($page, $size, $fields, $orderBy, $params, $with, $withCount);
    }

    public function paginate(int $page, int $size, array $fields, array $orderBy, array $params, array $with, array $withCount): array
    {
        return $this->courseDao->paginate($page, $size, $fields, $orderBy, $params, $with, $withCount);
    }

    public function findVideo($id): array
    {
        return $this->courseDao->findVideo($id);
    }

    public function getCourseVideos($id, array $fields): array
    {
        return $this->courseDao->getVideosByCourseId($id, $fields);
    }

    public function getPublishedUnIndexedCourses(array $fields): array
    {
        return $this->courseDao->getPublishedUnIndexedCourses($fields);
    }

    public function getPublishedUnIndexedVideos(array $fields): array
    {
        return $this->courseDao->getPublishedUnIndexedVideos($fields);
    }
}
