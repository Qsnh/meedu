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

use App\Events\CourseCommentEvent;
use Illuminate\Support\Facades\Auth;
use App\Services\Base\Services\RenderService;
use App\Services\Course\Models\CourseComment;
use App\Services\Base\Interfaces\RenderServiceInterface;
use App\Services\Course\Interfaces\CourseCommentServiceInterface;

class CourseCommentService implements CourseCommentServiceInterface
{
    /**
     * @var RenderService
     */
    protected $renderService;

    public function __construct(RenderServiceInterface $renderService)
    {
        $this->renderService = $renderService;
    }

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
        $renderContent = $this->renderService->render($originalContent);
        $comment = CourseComment::create([
            'user_id' => Auth::id(),
            'course_id' => $courseId,
            'original_content' => $originalContent,
            'render_content' => $renderContent,
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
