<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

namespace App\Services\Course\Services;

use App\Events\CourseCommentEvent;
use Illuminate\Support\Facades\Auth;
use App\Services\Course\Models\CourseComment;
use App\Services\Course\Interfaces\CourseCommentServiceInterface;

class CourseCommentService implements CourseCommentServiceInterface
{

    /**
     * @param int $courseId
     * @return array
     */
    public function courseComments(int $courseId): array
    {
        $comments = CourseComment::query()->whereCourseId($courseId)->orderByDesc('id')->limit(200)->get()->toArray();

        return $comments;
    }

    /**
     * @param int $courseId
     * @param string $originalContent
     *
     * @return array
     */
    public function create(int $courseId, string $originalContent): array
    {
        $comment = CourseComment::create([
            'user_id' => Auth::id(),
            'course_id' => $courseId,
            'original_content' => $originalContent,
            'render_content' => $originalContent,
        ]);

        event(new CourseCommentEvent($courseId, $comment['id']));

        return $comment->toArray();
    }

    /**
     * @param int $id
     * @return array
     */
    public function find(int $id): array
    {
        return CourseComment::findOrFail($id)->toArray();
    }
}
