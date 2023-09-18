<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Services\Course\Interfaces;

interface CourseCommentServiceInterface
{
    public function courseComments(int $courseId): array;

    public function create(int $userId, int $courseId, string $originalContent): array;
}
