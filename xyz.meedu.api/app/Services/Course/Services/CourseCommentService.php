<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Services\Course\Services;

use App\Meedu\Utils\IP;
use App\Events\CourseCommentEvent;
use App\Services\Course\Models\CourseComment;
use App\Services\Course\Interfaces\CourseCommentServiceInterface;

class CourseCommentService implements CourseCommentServiceInterface
{
    public function courseComments(int $courseId): array
    {
        return CourseComment::query()->whereCourseId($courseId)->orderByDesc('id')->limit(200)->get()->toArray();
    }

    public function create(int $userId, int $courseId, string $originalContent): array
    {
        $ip = request()->getClientIp();

        $comment = CourseComment::create([
            'user_id' => $userId,
            'course_id' => $courseId,
            'original_content' => $originalContent,
            'render_content' => $originalContent,
            'ip' => $ip,
            'ip_province' => IP::queryProvince($ip),
        ]);

        event(new CourseCommentEvent($courseId, $comment['id']));

        return $comment->toArray();
    }
}
