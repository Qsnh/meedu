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

use App\Services\Base\Services\RenderService;
use App\Services\Course\Models\CourseComment;

class CourseCommentService
{
    protected $renderService;

    public function __construct(RenderService $renderService)
    {
        $this->renderService = $renderService;
    }

    public function courseComments(int $courseId): array
    {
        $comments = CourseComment::whereCourseId($courseId)->orderBy('id')->get()->toArray();

        return $comments;
    }

    /**
     * @param int    $userId
     * @param int    $courseId
     * @param string $originalContent
     *
     * @return array
     */
    public function create(int $userId, int $courseId, string $originalContent): array
    {
        $renderContent = $this->renderService->render($originalContent);
        $comment = CourseComment::create([
            'user_id' => $userId,
            'course_id' => $courseId,
            'original_content' => $originalContent,
            'render_content' => $renderContent,
        ]);

        return $comment->toArray();
    }
}
